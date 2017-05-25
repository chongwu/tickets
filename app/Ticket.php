<?php

namespace App;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;


/**
 * App\Ticket
 *
 * @property integer $id
 * @property string $text
 * @property integer $status
 * @property integer $work_type_id
 * @property integer $ticket_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $user_id
 * @property boolean $track
 * @property-read \App\User $author
 * @property-read \App\WorkType $workType
 * @property-read \App\Ticket $parent
 * @property-read \Carbon\Carbon $complete_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $childTickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $specialists
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TicketRow[] $rows
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereWorkTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Ticket whereTrack($value)
 * @mixin \Eloquent
 */
class Ticket extends Model
{
    use AlgoliaEloquentTrait;

    protected $fillable = ['text', 'status', 'work_type_id', 'ticket_id', 'user_id', 'track'];

    protected $dates = ['created_at', 'updated_at', 'complete_date'];
    protected $with = ['specialists', 'rows'];

    const CREATED = 0;
    const IN_WORK = 1;
    const ON_APPROVAL = 2;
    const IN_REWORK = 3;
    const COMPLETED = 4;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('dateOrder', function(Builder $builder){
            $builder->orderBy('status');
            $builder->orderBy('created_at', 'desc');
        });
    }

    public static function statuses()
    {
        return [
            self::CREATED => 'Создана',
            self::IN_WORK => 'В работе',
            self::ON_APPROVAL => 'На подтверждении',
            self::IN_REWORK => 'Отправлена на доработку',
            self::COMPLETED => 'Выполнена',
        ];
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specialists()
    {
        return $this->belongsToMany('App\User')->withPivot('date_to');
    }

    public function workType()
    {
        return $this->belongsTo('App\WorkType');
    }

    public function parent()
    {
        return $this->belongsTo('App\Ticket');
    }

    public function childTickets()
    {
        return $this->hasMany('App\Ticket');
    }

    /**
     * @return HasMany
     */
    public function rows()
    {
        return $this->hasMany('App\TicketRow')->orderBy('created_at', 'desc');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param integer $status
     * @return Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', '=', $status);
    }

    /**
     * @return Carbon
     */
    public function getCompleteDateAttribute()
    {
        $createDate = $this->created_at;
        $workLength = $this->workType->days;
        for ($workLength; $workLength>=0;$workLength--){
            if($createDate->isWeekend()){
                $workLength++;
            }
            $createDate->addDay();
        }
        return $createDate->addDay($workLength);
    }


    public function setTrackAttribute($value)
    {
        $this->attributes['track'] = (is_null($value) || $value == 'off')?0:1;
    }

    public function getStatusLabel()
    {
        $labelClass = '';
        switch ($this->status){
            case self::CREATED:
                $labelClass = 'default';
                break;
            case self::IN_WORK:
                $labelClass = 'info';
                break;
            case self::ON_APPROVAL:
                $labelClass = 'primary';
                break;
            case self::IN_REWORK:
                $labelClass = 'warning';
                break;
            case self::COMPLETED:
                $labelClass = 'success';
                break;
        }
        return \Html::tag('span', self::statuses()[$this->status], ['class' => 'label label-'.$labelClass])->toHtml();
    }

    public function getCalendarFileName()
    {
        return 'cal-'.$this->id.'.ics';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getUsersByWorkType()
    {
        $users = [];
        foreach ($this->workType->specialistGroups as $group){
            foreach ($group->users as $user){
                $users[] = $user;
            }
        }
        return collect($users);
    }

    public function generateICalendar()
    {
        //@todo всё-таки доработать работу с календарем
        $vCalendar = new Calendar('-//Events Calendar//iCal4j 1.0//EN');
        $vEvent = new Event();
        $vEvent
            ->setDtStart($this->created_at)
            ->setDtEnd($this->complete_date)
            ->setNoTime(true)
            ->setSummary($this->text);
        $vCalendar->addComponent($vEvent);

        header('Content-Type: text/calendar; charset=utf-8');

        Storage::disk('public')->put($this->getCalendarFileName(), $vCalendar->render());
    }

    public function iAmAuthor()
    {
        return $this->user_id === Auth::user()->id;
    }

    public function canBeTakenInWork()
    {
        return $this->getUsersByWorkType()->contains('id', Auth::user()->id);
    }

    public function canBeWorkedOut()
    {
        return $this->specialists->contains('id', Auth::user()->id);
    }
}

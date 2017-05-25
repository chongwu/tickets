<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;


/**
 * App\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $telegram_id
 * @property boolean $specialist
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $activeTickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $onApproveTickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $workTickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Equipment[] $allEquipments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Place[] $allPlaces
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SpecialistGroup[] $specialistGroups
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTelegramId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereSpecialist($value)
 * @mixin \Eloquent
 * @property boolean $header
 * @method static \Illuminate\Database\Query\Builder|\App\User whereHeader($value)
 * @property-read mixed $ticket_complete_date
 */
class User extends Authenticatable
{
    use Notifiable;

    public $adldapUser;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('name', function(Builder $builder){
            $builder->orderBy('name', 'asc');
        });
    }

    protected $fillable = [
        'name', 'email', 'password', 'telegram_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getTicketCompleteDateAttribute()
    {
        return Carbon::parse($this->pivot->date_to)->format('d.m.Y');
    }

    public function ticketsCanBeTaken()
    {
        $tickets = [];
        foreach ($this->specialistGroups as $group){
            foreach ($group->workTypes as $workType){
                foreach ($workType->getTicketsByStatus(Ticket::CREATED) as $ticket){
                    $tickets[] = $ticket;
                }
            }
        }
        return collect($tickets)->unique('id');
    }

    /**
     * Метод возвращает коллекцию заявок, доступных пользователю
     * @param integer|null $status
     * @return Collection|static
     */
    public function allTickets($status = null)
    {
        if($this->header){
            $allTickets = Ticket::with(['author', 'workType.specialistGroups.users']); //->get()->all()
        }
        else{
            $allTickets = Ticket::with(['workType', 'author'])
                ->where('user_id', $this->id);
            if($this->isSpecialist()){
                $newTickets = Ticket::whereHas('workType', function ($query) {
                    $query->whereHas('specialistGroups', function ($q) {
                        $q->whereHas('users', function ($q){
                            $q->where('id', $this->id);
                        });
                    });
                })->where('status', Ticket::CREATED);
                $allTickets = Ticket::whereHas('specialists', function ($query){
                    $query->where('id', $this->id);
                })
                    ->with(['workType.specialistGroups.users', 'author'])
                    ->unionAll($allTickets)->unionAll($newTickets);
//                    ->get()->unique('id')->all();
            }
            /*else{
                $allTickets = $allTickets; //->get()->all()
            }*/
        }
        $allTickets = (is_null($status))?$allTickets:$allTickets->status($status);
        return $allTickets->get();
    }

    public function onApproveTickets()
    {
        return $this->belongsToMany('App\Ticket')->withPivot('date_to')->where('status', '=', Ticket::ON_APPROVAL);
    }

    public function activeTickets()
    {
        return $this->belongsToMany('App\Ticket')->withPivot('date_to')->whereIn('status', [Ticket::IN_WORK, Ticket::IN_REWORK]);
    }

    public function workTickets()
    {
        return $this->belongsToMany('App\Ticket')->withPivot('date_to')->where('status', '<>', Ticket::COMPLETED);
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }

    public function equipments()
    {
        return $this->allEquipments()->wherePivot('to', null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allEquipments()
    {
            return $this->belongsToMany('App\Equipment')->withPivot(['from', 'to']);
    }

    public function places()
    {
        return $this->allPlaces()->wherePivot('to', null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allPlaces()
    {
        return $this->belongsToMany('App\Place')->withPivot(['from', 'to']);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function freeUsers()
    {
        $busyUsersId = self::has('places')->get(['id'])->toArray();
        return self::whereNotIn('id', $busyUsersId)->get(['id', 'name'])->pluck('name', 'id');
    }

    public function specialistGroups()
    {
        return $this->belongsToMany('App\SpecialistGroup', 'specialists', 'user_id', 'specialist_group_id');
    }

    public function isSpecialist()
    {
        return $this->specialistGroups->count() > 0 || $this->specialist;
    }

    public function isHeader()
    {
        return $this->header;
    }
}

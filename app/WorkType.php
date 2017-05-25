<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\WorkType
 *
 * @property integer $id
 * @property string $name
 * @property integer $equipment_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\EquipmentType $equipmentType
 * @method static \Illuminate\Database\Query\Builder|\App\WorkType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkType whereEquipmentTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\WorkType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $days
 * @method static \Illuminate\Database\Query\Builder|\App\WorkType whereDays($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SpecialistGroup[] $specialistGroups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ticket[] $tickets
 */
class WorkType extends Model
{
    protected $fillable = ['name', 'equipment_type_id', 'days'];

    public function equipmentType()
    {
        return $this->belongsTo('App\EquipmentType');
    }

    public function setDaysAttribute($value)
    {
        $this->attributes['days'] = empty($value)?1:$value;
    }

    public function setEquipmentTypeIdAttribute($value)
    {
        $this->attributes['equipment_type_id'] = (empty($value))?null:$value;
    }

    public function specialistGroups()
    {
        return $this->belongsToMany('App\SpecialistGroup', 'work_by_groups', 'work_type_id', 'specialist_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * @param integer $status
     * @return \Illuminate\Database\Eloquent\Collection|\App\Ticket[]
     */
    public function getTicketsByStatus($status)
    {
        return $this->tickets()->where('status', '=', $status)->get();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Equipment
 *
 * @property integer $id
 * @property string $inventory_number
 * @property string $name
 * @property-read string $fullName
 * @property string $content
 * @property integer $equipment_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $allUsers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Place[] $places
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Place[] $allPlaces
 * @property-read \App\EquipmentType $equipmentType
 * @method static \Illuminate\Database\Query\Builder|\App\Equipment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Equipment whereInventoryNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Equipment whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Equipment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Equipment whereEquipmentTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Equipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Equipment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $full_name
 */
class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = ['inventory_number', 'name', 'content', 'equipment_type_id'];

    public function getFullNameAttribute()
    {
        return $this->inventory_number.' - '.$this->name;
    }

    public function equipmentType()
    {
        return $this->belongsTo('App\EquipmentType');
    }

    public function users()
    {
        return $this->allUsers()->wherePivot('to', null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allUsers()
    {
        return $this->belongsToMany('App\User')->withPivot(['from', 'to']);
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
    public static function freeEquipments()
    {
        $busyUsersId = self::has('places')->get(['id'])->toArray();
        return self::whereNotIn('id', $busyUsersId)->get(['id', 'name', 'inventory_number'])->pluck('fullName', 'id');
    }

    public function equipmentsWithoutUser()
    {

    }
}

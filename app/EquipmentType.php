<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\EquipmentType
 *
 * @property integer $id
 * @property string $name
 * @property boolean $folder
 * @property integer $parent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\EquipmentType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EquipmentType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EquipmentType whereFolder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EquipmentType whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EquipmentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EquipmentType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Equipment[] $equipments
 * @property-read \App\EquipmentType $parentType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EquipmentType[] $childTypes
 */
class EquipmentType extends Model
{
    protected $fillable = ['name', 'folder', 'parent_id'];

    public function equipments()
    {
        return $this->hasMany('App\Equipment');
    }

    public function parentType()
    {
        return $this->belongsTo('App\EquipmentType');
    }

    public function childTypes()
    {
        return $this->hasMany('App\EquipmentType', 'parent_id');
    }
}

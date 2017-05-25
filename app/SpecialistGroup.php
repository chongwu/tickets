<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SpecialistGroup
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\SpecialistGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SpecialistGroup whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SpecialistGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SpecialistGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\WorkType[] $workTypes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 */
class SpecialistGroup extends Model
{
    protected $fillable = ['name'];

    public function workTypes()
    {
        return $this->belongsToMany('App\WorkType', 'work_by_groups', 'specialist_group_id', 'work_type_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'specialists', 'specialist_group_id', 'user_id');
    }
}

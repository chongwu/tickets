<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Specialist
 *
 * @property integer $user_id
 * @property integer $specialist_group_id
 * @property-read \App\User $user
 * @property-read \App\SpecialistGroup $group
 * @method static \Illuminate\Database\Query\Builder|\App\Specialist whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Specialist whereSpecialistGroupId($value)
 * @mixin \Eloquent
 */
class Specialist extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function group()
    {
        return $this->belongsTo('App\SpecialistGroup');
    }
}

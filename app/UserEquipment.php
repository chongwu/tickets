<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserEquipment
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $equipment_id
 * @property string $from
 * @property string $to
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $place_id
 * @property-read \App\Place $place
 * @property-read \App\Equipment $equipment
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\UserEquipment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserEquipment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserEquipment whereEquipmentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserEquipment whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserEquipment whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserEquipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserEquipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\UserEquipment wherePlaceId($value)
 * @mixin \Eloquent
 */
class UserEquipment extends Model
{
    public function place()
    {
        return $this->belongsTo('App\Place');
    }

    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

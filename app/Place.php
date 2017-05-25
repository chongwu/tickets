<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Place
 *
 * @property integer $id
 * @property string $place
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Equipment[] $equipments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Equipment[] $allEquipments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $allUsers
 * @method static \Illuminate\Database\Query\Builder|\App\Place whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Place wherePlace($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Place whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Place extends Model
{
    protected $fillable = ['place'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('place', function (Builder $builder){
            $builder->orderBy('place', 'asc');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
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
}

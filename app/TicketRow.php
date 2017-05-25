<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TicketRow
 *
 * @property integer $id
 * @property string $text
 * @property integer $ticket_id
 * @property integer $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\TicketRow whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketRow whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketRow whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketRow whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketRow whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketRow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TicketRow extends Model
{
    protected $fillable = ['text', 'type'];

    const USER = 1;
    const SPECIALIST = 2;

    public static function authorTypes()
    {
        return [
            self::USER => 'Обычный пользователь',
            self::SPECIALIST => 'Специалист'
        ];
    }
}

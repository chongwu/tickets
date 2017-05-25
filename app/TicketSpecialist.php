<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TicketSpecialist
 *
 * @property integer $specialist_id
 * @property integer $ticket_id
 * @property string $date_to
 * @property-read \App\Ticket $ticket
 * @property-read \App\Specialist $specialist
 * @method static \Illuminate\Database\Query\Builder|\App\TicketSpecialist whereSpecialistId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketSpecialist whereTicketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TicketSpecialist whereDateTo($value)
 * @mixin \Eloquent
 */
class TicketSpecialist extends Model
{
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }

    public function specialist()
    {
        return $this->belongsTo('App\Specialist');
    }
}

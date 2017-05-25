<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\TicketRow;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class TicketRowController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'text' => 'required|string',
            'ticket_id' => 'required|integer'
        ]);
        /* @var Ticket $ticket */
        $ticket = Ticket::findOrFail(Input::get('ticket_id'));
        $ticket->rows()->create([
            'text' => Input::get('text'),
            'type' => TicketRow::USER
        ]);
        return redirect()->route('tickets.show', [$ticket->id]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

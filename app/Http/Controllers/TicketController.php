<?php

namespace App\Http\Controllers;

use App\Events\TicketChangeDate;
use App\Events\TicketChangeEmployee;
use App\Events\TicketEvent;
use App\Http\Requests\TicketConfirmRequest;
use App\Http\Requests\TicketRequest;
use App\Http\Requests\TicketShowRequest;
use App\Ticket;
use App\TicketRow;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Auth::user()->allTickets(Ticket::CREATED);

//        $page = Input::get('page', 1);
//        $paginate = env('TICKETS_PER_PAGE', 15);
//        $tickets = array_slice($allTickets, $paginate * ($page - 1), $paginate);
//        $paginator = new LengthAwarePaginator($tickets, count($allTickets), $paginate, $page);
        return view('ticket.index', ['tickets' => $tickets, 'specialists' => User::whereHas('specialistGroups')->get()->pluck('name', 'id')]); //'paginator' => $paginator
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketRequest|\Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        $ticket = new Ticket();
        $ticket->fill($request->all());
        $ticket->user_id = \Auth::user()->id;
        $ticket->save();
        event(new TicketEvent($ticket));
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Http\Requests\TicketShowRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(TicketShowRequest $request, $id)
    {
        $ticket = Ticket::with(['author', 'workType'])->where('id', $id)->first();
        if(!is_null($ticket)){
            return view('ticket.show')->with('ticket', $ticket);
        }
        return abort(404);
    }

    public function getTickets(Request $request, $status)
    {
        if($request->ajax()){
            return view('ticket._list')->with([
            	'tickets' => Auth::user()->allTickets($status),
	            'specialists' => $status>Ticket::CREATED?User::whereHas('specialistGroups')->get()->pluck('name', 'id'):null
            ]);
        }
        return abort(405);
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
     * @param TicketRequest|\Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, $id)
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

    public function confirm(TicketConfirmRequest $request, $id)
    {
        /* @var Ticket $ticket */
        $ticket = Ticket::findOrFail($id);
        $ticket->status = Ticket::IN_WORK;
        $ticket->save();
        $ticket->specialists()->attach(Auth::user()->id, ['date_to' => $ticket->complete_date]);
        event(new TicketEvent($ticket));
        return redirect()->route('home');
    }

    public function checkComplete(Request $request, $id)
    {
        /* @var Ticket $ticket */
        $ticket = Ticket::findOrFail($id);
        $ticket->status = Ticket::ON_APPROVAL;
        if($ticket->save() && \Request::exists(['text'])){
            $this->validate($request, [
                'text' => 'required|string'
            ]);
            $ticket->rows()->create([
                'text' => Input::get('text'),
                'type' => TicketRow::SPECIALIST
            ]);
        }
        event(new TicketEvent($ticket));
        return redirect()->route('home');
    }

    public function approve(Request $request, $id, $approve = null)
    {
        /* @var Ticket $ticket */
        $ticket = Ticket::findOrFail($id);
        if(is_null($approve) && \Request::exists('text')){
            if(\Request::exists('approve'))
                $ticket->status = Ticket::COMPLETED;
            elseif (\Request::exists('not_approve')){
                $ticket->status = Ticket::IN_REWORK;
            }
        }
        else{
            $ticket->status = $approve?Ticket::COMPLETED:Ticket::IN_REWORK;
        }
        if($ticket->save()){
            if(!empty(Input::get('text'))) {
                $ticket->rows()->create(
                    [
                        'text' => Input::get('text'),
                        'type' => TicketRow::USER
                    ]
                );
            }
        }
        event(new TicketEvent($ticket));
        return redirect()->route('home');
    }

    public function resend(Ticket $ticket)
    {
        /* @var Ticket $newTicket */
        $newTicket = $ticket->replicate(['specialists', 'rows']);
        $newTicket->status = Ticket::CREATED;
        $newTicket->save();
        event(new TicketEvent($newTicket));
        return redirect()->route('home');
    }

    public function changeDate(Ticket $ticket)
    {
        $ticket->specialists()->updateExistingPivot($ticket->specialists->first()->id, ['date_to' => Carbon::parse(Input::get('date'))]);
        event(new TicketChangeDate($ticket->id));
        return redirect()->route('home');
    }

    public function changeEmployee(Ticket $ticket)
    {
        /* @var User $prevEmployee */
        $prevEmployee = $ticket->specialists->first();
        if($prevEmployee->id != Input::get('employee')){
            $dateTo = $prevEmployee->pivot->date_to;
            $ticket->specialists()->detach();
            $ticket->specialists()->attach(Input::get('employee'), ['date_to' => $dateTo]);
            $ticket->load('specialists');
            event(new TicketChangeEmployee($ticket, $prevEmployee));
        }
        return redirect()->route('home');
    }

    public function reindex()
    {
//        Ticket::$autoIndex = false;
        Ticket::clearIndices();
        Ticket::reindex();
//        Ticket::$autoIndex = true;
        return redirect()->route('home');
    }
}

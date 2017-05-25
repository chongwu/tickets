@if(Auth::user()->isSpecialist())
    @if($ticket->status === \App\Ticket::CREATED && $ticket->canBeTakenInWork())
        {!! Form::open(['route' => ['tickets.confirm', $ticket->id], 'method' => 'PATCH', 'class' => 'display-inline']) !!}
        {{ Form::button('<i class="fa fa-hand-paper-o" aria-hidden="true"></i>', ['type' => 'submit','class' => 'btn btn-primary btn-xs', 'title' => 'Принять к исполнению']) }}
        {!! Form::close() !!}
    @endif
    @if(in_array($ticket->status, [\App\Ticket::IN_WORK, \App\Ticket::IN_REWORK]) && $ticket->canBeWorkedOut())
        {!! Form::open(['route' => ['tickets.checkComplete', $ticket->id], 'method' => 'PATCH', 'class' => 'display-inline']) !!}
        {{ Form::button('<i class="fa fa-check" aria-hidden="true"></i>', ['type' => 'submit','class' => 'btn btn-success btn-xs', 'title' => 'Выполнить заявку']) }}
        {!! Form::close() !!}
    @endif
@endif
@if($ticket->iAmAuthor())
    @if($ticket->status === \App\Ticket::ON_APPROVAL)
        {!! Form::open(['route' => ['tickets.approve', $ticket->id, 1], 'method' => 'PATCH', 'class' => 'display-inline']) !!}
        {{ Form::button('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-success btn-xs', 'title' => 'Одобрить выполнение']) }}
        {!! Form::close() !!}
        {!! Form::open(['route' => ['tickets.approve', $ticket->id, 0], 'method' => 'PATCH', 'class' => 'display-inline']) !!}
        {{ Form::button('<i class="fa fa-thumbs-o-down" aria-hidden="true"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'title' => 'Отклонить выполнение']) }}
        {!! Form::close() !!}
    @elseif($ticket->status === \App\Ticket::COMPLETED)
        {!! Form::open(['route' => ['tickets.resend', $ticket->id], 'method' => 'PATCH', 'class' => 'display-inline']) !!}
        {{ Form::button('<i class="fa fa-retweet" aria-hidden="true"></i>', ['type' => 'submit','class' => 'btn btn-primary btn-xs', 'title' => 'Отправить заново']) }}
        {!! Form::close() !!}
    @endif
@endif
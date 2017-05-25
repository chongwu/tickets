@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>
            Заявка #{{ $ticket->id }}
            @include('ticket._buttons', ['ticket' => $ticket])
        </h3>
        <p><strong>Статус:</strong> {!! $ticket->getStatusLabel() !!}</p>
        <p><strong>Категория:</strong> {{ $ticket->workType->name }}</p>
        <p><strong>Дата открытия:</strong> {{ \Carbon\Carbon::parse($ticket->created_at)->format('d.m.Y') }}</p>
        @if(!$ticket->specialists->isEmpty())
            <p><strong>Дата выполнения:</strong> {{ \Carbon\Carbon::parse($ticket->specialists->first()->pivot->date_to)->format('d.m.Y') }}</p>
        @endif
        <p><strong>Заказчик:</strong> {{ Html::link(route('users.show', [$ticket->author->id]), $ticket->author->name) }}</p>
        @if(!$ticket->specialists->isEmpty())
            <p><strong>Исполнитель:</strong> {{ $ticket->specialists->implode('name', ', ') }}</p>
        @endif
        <p><strong>Содержание:</strong> {{ $ticket->text }}</p>
        @if($ticket->rows->count() > 0)
        <div class="block-header">Комментарии</div>
            <div class="ticket-comments">
                @foreach($ticket->rows as $row)
                    <div class="row comment{{ $row->type === \App\TicketRow::SPECIALIST?' bg-success':'' }}">
                        <div class="col-xs-2 col-md-1{{ $row->type === \App\TicketRow::SPECIALIST?' pull-right':'' }}">
                            <img src="http://placehold.it/80" class="img-circle img-responsive" alt="" />
                        </div>
                        <div class="col-xs-10 col-md-11{{ $row->type === \App\TicketRow::SPECIALIST?' text-right':'' }}">
                            <div>
                                <div class="comment-info">
                                    <strong>{{ $row->created_at->format('d.m.Y') }}</strong>
                                </div>
                            </div>
                            <div class="comment-text">
                                {{ $row->text }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if($ticket->status !== \App\Ticket::COMPLETED)
            @if($ticket->rows->count() > 0 && $ticket->canBeWorkedOut() && in_array($ticket->status, [\App\Ticket::IN_WORK, \App\Ticket::IN_REWORK]))
                {!! Form::open(['route' => ['tickets.checkComplete', $ticket->id], 'class' => 'margin-top-30', 'method' => 'patch']) !!}
                    <div class="form-group">
                        {!! Form::label('text', 'Текст ответа') !!}
                        {!! Form::textarea('text', null, ['class' => 'form-control', 'rows'=>6]) !!}
                    </div>
                    {!! Form::submit('Ответить и выполнить заявку', ['class' => 'btn btn-success']) !!}
                {!! Form::close() !!}
            @elseif($ticket->iAmAuthor())
                @if($ticket->status === \App\Ticket::ON_APPROVAL)
                    {!! Form::open(['route' => ['tickets.approve', $ticket->id], 'method' => 'patch', 'class' => 'margin-top-30']) !!}
                @else
                    {!! Form::open(['route' => ['ticket-rows.store'], 'class' => 'margin-top-30']) !!}
                    {!! Form::hidden('ticket_id', $ticket->id) !!}
                @endif
                <div class="form-group">
                    {!! Form::label('text', 'Комментарий') !!}
                    {!! Form::textarea('text', null, ['class' => 'form-control', 'rows'=>6, 'required']) !!}
                </div>
                @if($ticket->status === \App\Ticket::ON_APPROVAL)
                    {!! Form::button('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Одобрить выполнение и дать комментарий', ['type' => 'submit', 'class' => 'btn btn-success', 'name' => 'approve']) !!}
                    {!! Form::button('<i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Отклонить выполнение и дать комментарий', ['type' => 'submit', 'class' => 'btn btn-danger', 'name' => 'not_approve']) !!}
                @else
                    {!! Form::submit('Добавить комментарий', ['class' => 'btn btn-info']) !!}
                @endif
                {!! Form::close() !!}
            @endif
        @endif
    </div>
@endsection
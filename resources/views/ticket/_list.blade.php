<div class="tickets-list">
    <table class="table table-bordered table-hover table-condensed tickets">
        <thead>
        <tr>
            <th>#</th>
            <th>Дата открытия</th>
            <th>Содержание</th>
            {{--<th>Статус</th>--}}
            <th>Заказчик</th>
            <th>Исполнитель</th>
            <th>Категория</th>
            <th>Дата выполнения</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tickets->all() as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->created_at->format('d.m.Y') }}</td>
                <td>
                    {{ Html::link(route('tickets.show', [$ticket->id]), $ticket->text) }}
                    @if(!$ticket->rows->isEmpty())
                        <span class="comments-count" title="Количество комментариев">
                                        {!! Html::tag('i', '', ['class' => 'fa fa-comments-o'])->toHtml() !!}
                            {{ $ticket->rows->count() }}
                                    </span>
                    @endif

                </td>
                {{--<td>{!! $ticket->getStatusLabel() !!}</td>--}}
                <td>{{ Html::link(route('users.show', [$ticket->author->id]), $ticket->author->name) }}</td>
                <td>
                    @if($ticket->specialists->count() > 0)
                        @if(Auth::user()->isHeader() && $ticket->status !== \App\Ticket::COMPLETED)
                            <span class="change-ticket" title="Изменить исполнителя">
                                            {{ $ticket->specialists->first()->name }}
                                        </span>
                            {!! Form::open(['route' => ['tickets.changeEmployee', $ticket->id], 'method' => 'PATCH', 'class' => 'display-inline change-ticket-employee-form hidden']) !!}
                            {!! Form::select('employee', $specialists, null, ['class' => 'form-control new-employee-select', 'placeholder' => 'Выберите сотрудника']) !!}
                            <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
                            <button class="btn btn-xs btn-danger cancel-change"><i class="fa fa-times" aria-hidden="true"></i></button>
                            {!! Form::close() !!}
                        @else
                            {{ $ticket->specialists->first()->name }}
                        @endif
                    @endif
                </td>
                <td>{{ $ticket->workType->name }}</td>
                <td>
                    @if($ticket->specialists->count() > 0)
                        @if(Auth::user()->isHeader() && $ticket->status !== \App\Ticket::COMPLETED)
                            <span class="change-ticket complete-date" title="Изменить дату исполнения">
                                            {{ $ticket->specialists->first()->ticket_complete_date }}
                                        </span>
                            {!! Form::open(['route' => ['tickets.changeDate', $ticket->id], 'method' => 'PATCH', 'class' => 'display-inline change-ticket-complete-date-form hidden']) !!}
                            <input type="text" name="date" class="form-control ticket-new-date" placeholder="дд.мм.гггг" value="{{ $ticket->specialists->first()->ticket_complete_date }}" title="Дата выполнения">
                            <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
                            <button class="btn btn-xs btn-danger cancel-change"><i class="fa fa-times" aria-hidden="true"></i></button>
                            {!! Form::close() !!}
                        @else
                            {{ $ticket->specialists->first()->ticket_complete_date }}
                        @endif
                    @endif
                </td>
                <td class="buttons">@include('ticket._buttons', ['ticket' => $ticket])</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

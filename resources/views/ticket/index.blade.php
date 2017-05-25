@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Заявки</h3>
        <div class="margin-top-10 margin-bottom-10">
            {{ Html::link(route('tickets.create'), 'Добавить заявку', ['class' => 'btn btn-info']) }}
        </div>
        @if(Session::has('message'))
            <div class="alert alert-info">
            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            	<strong>{{ Session::get('message') }}</strong>
            </div>
        @endif
        <!-- TAB NAVIGATION -->
        <ul class="nav nav-tabs" role="tablist">
        @foreach(\App\Ticket::statuses() as $key => $status)
            <li {{($loop->first)?'class=active':''}}><a href="{{ route('tickets.getTickets', ['status' => $key]) }}" role="tab" data-toggle="tabajax">{{$status}}</a></li>
        @endforeach
        </ul>

        <!-- TAB CONTENT -->
        <div class="tab-content">
            @include('ticket._list', ['tickets' => $tickets])
        </div>
        {{--{{ $paginator->render() }}--}}
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" rel="script">
        var oldDate;
        $(document)//'.tickets'
            .on("click", '.change-ticket', function () {
                var span = $(this);
                var form = span.next('form');
                if(span.hasClass('complete-date')) {
                    oldDate = $.trim(span.html());
                }
                span.addClass('hidden');
                form.removeClass('hidden');
                return false;
            })
            .on("click", '.cancel-change', function () {
                var form = $(this).parent('form');
                var span = form.prev('span');
                form.addClass('hidden');
                if(span.hasClass('complete-date')) {
                    form.find('input.ticket-new-date').val(oldDate);
                }
                else{
                    form.find('select').prop('selectedIndex', 0);
                }
                span.removeClass('hidden');
                return false;
            });
            $('.nav-tabs').on('click', "a[data-toggle='tabajax']", function () {
                var link = $(this);
                var tab = link.parent('li');
                if(!tab.hasClass('active')){
                    var url = link.attr('href');
                    $('.nav-tabs li').removeClass('active');
                    tab.addClass('active');
                    $('.tab-content').load(url);
                }
                return false;
            });
    </script>
@endsection
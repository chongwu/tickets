@if($model->users->count() > 0)
    <h4>Сотрудники</h4>
    <table id="users" class="table table-bordered">
        <thead>
        <tr>
            <th width="165px">Дата прикрепления</th>
            <th>Ф.И.О.</th>
            <th width="70px" class="button-column"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($model->users as $user)
            <tr>
                <td>
                    {{ \Carbon\Carbon::parse($user->pivot->from)->format('d.m.Y') }}
                </td>
                <td>
                    @include('user._info', ['user' => $user])
                </td>
                <td class="buttons">
                    {!! Form::open(['route' => [str_plural(strtolower((new ReflectionClass(get_class($model)))->getShortName())).'.unPinUser',$model->id, $user->id], 'method' => 'PATCH', 'class' => 'display-inline']) !!}
                    {!! Form::button(Html::tag('i', '', ['class' => 'fa fa-sign-out fa-flip-horizontal', 'aria-hidden'=>true])->toHtml(), ['type' => 'submit', 'class' => 'btn btn-info btn-xs', 'title'=>'Открепить']) !!}
                    {!! Form::close() !!}

                    {!! Form::open(['route' => [str_plural(strtolower((new ReflectionClass(get_class($model)))->getShortName())).'.deleteUser',$model->id, $user->id], 'method' => 'DELETE', 'class' => 'display-inline']) !!}
                    {!! Form::button(Html::tag('i', '', ['class' => 'fa fa-times', 'aria-hidden'=>true])->toHtml(), ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'title'=>'Удалить']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
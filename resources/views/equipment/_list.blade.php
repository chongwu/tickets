@if($equipments->count() > 0)
    {!! isset($withoutHeader) && $withoutHeader?'':'<h4>Оборудование</h4>' !!}
    <table id="users" class="table table-bordered">
        <thead>
        <tr>
            <th>Дата прикрепления</th>
            <th>Инвентарный номер</th>
            <th>Наименование</th>
            <th>Описание</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($equipments as $equipment)
            <tr>
                <td>
                    {{ \Carbon\Carbon::parse($equipment->pivot->from)->format('d.m.Y') }}
                </td>
                <td>{{ $equipment->inventory_number }}</td>
                <td>{{ Html::link(route('equipments.show', [$equipment->id]), $equipment->name) }}</td>
                <td>{{ $equipment->content }}</td>
                <td class="buttons">
                    {!! Form::open(['route' => [str_plural(strtolower((new ReflectionClass(get_class($model)))->getShortName())).'.unPinEquipment',$model->id, $equipment->id], 'method' => 'PATCH', 'class' => 'display-inline']) !!}
                    {!! Form::button(Html::tag('i', '', ['class' => 'fa fa-sign-out fa-flip-horizontal', 'aria-hidden'=>true])->toHtml(), ['type' => 'submit', 'class' => 'btn btn-info btn-xs', 'title'=>'Открепить']) !!}
                    {!! Form::close() !!}

                    {!! Form::open(['route' => [str_plural(strtolower((new ReflectionClass(get_class($model)))->getShortName())).'.deleteEquipment',$model->id, $equipment->id], 'method' => 'DELETE', 'class' => 'display-inline']) !!}
                    {!! Form::button(Html::tag('i', '', ['class' => 'fa fa-times', 'aria-hidden'=>true])->toHtml(), ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'title'=>'Удалить']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
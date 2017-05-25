<legend>Оборудование</legend>
<div class="form-group{{$errors->has('inventory_number') ? ' has-error' : ''}}">
    {{ Form::label('inventory_number', 'Инвентарный номер') }}
    {{ Form::text('inventory_number', old('inventory_number'), array('class' => 'form-control', 'placeholder' => 'Инвентарный номер', 'required')) }}
    @if ($errors->has('inventory_number'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('inventory_number'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>

<div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
    {{ Form::label('name', 'Наименование') }}
    {{ Form::text('name', old('Name'), array('class' => 'form-control', 'placeholder' => 'Наименование', 'required')) }}
    @if ($errors->has('name'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('name'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>
<div class="form-group{{$errors->has('content') ? ' has-error' : ''}}">
    {{ Form::label('content', 'Описание') }}
    {{ Form::textarea('content', old('content'), array('class' => 'form-control', 'placeholder' => 'Описание')) }}
    @if ($errors->has('content'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('content'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>
<div class="form-group{{$errors->has('equipment_type_id') ? ' has-error' : ''}}">
    {{ Form::label('equipment_type_id', 'Тип оборудования') }}
    {{ Form::select('equipment_type_id', \App\EquipmentType::where('folder', 0)->get()->pluck('name', 'id'), isset($equipmentType)?$equipmentType:null, ['class' => 'form-control', 'placeholder' => 'Выберите тип', 'required']) }}
    @if ($errors->has('equipment_type_id'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('equipment_type_id'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>
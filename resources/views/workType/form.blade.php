<legend>Тип работы</legend>
<div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
    {{ Form::label('name', 'Тип работы') }}
    {{ Form::text('name', old('Name'), array('class' => 'form-control', 'placeholder' => 'Тип работы', 'required')) }}
    @if ($errors->has('name'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('name'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>
<div class="form-group{{$errors->has('equipment_type_id') ? ' has-error' : ''}}">
    {{ Form::label('equipment_type_id', 'Тип оборудования') }}
    {{ Form::select('equipment_type_id', \App\EquipmentType::where('folder', 0)->get()->pluck('name', 'id'), isset($equipmentType)?$equipmentType:null, ['class' => 'form-control', 'placeholder' => 'Выберите тип']) }}
    @if ($errors->has('equipment_type_id'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('equipment_type_id'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>
<div class="form-group{{$errors->has('days') ? ' has-error' : ''}}">
    {{ Form::label('days', 'Количество рабочих дней для исполнения') }}
    {{ Form::input('number', 'days', null, ['class' => 'form-control', 'placeholder' => '1', 'min' => 1, 'max'=>30]) }}
    @if ($errors->has('days'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('days'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>
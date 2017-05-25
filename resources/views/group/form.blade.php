<legend>Новая группа</legend>
<div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
    {{ Form::label('name', 'Наименование группы') }}
    {{ Form::text('name', old('Name'), array('class' => 'form-control', 'placeholder' => 'Наименование группы', 'required')) }}
    @if ($errors->has('name'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('name'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>
<div class="form-group">
    {{ Form::label('users[]', 'Сотрудники') }}
    {{ Form::select('users[]', \App\User::all('id', 'name')->pluck('name', 'id'), isset($group)?$group->users->modelKeys():null, ['class' => 'form-control users-list', 'multiple' => 'multiple']) }}
</div>
<div class="form-group">
    {{ Form::label('workTypes[]', 'Типы работ') }}
    {{ Form::select('workTypes[]', \App\WorkType::all('id', 'name')->pluck('name', 'id'), isset($group)?$group->workTypes->modelKeys():null, ['class' => 'form-control work-types-list', 'multiple' => 'multiple']) }}
</div>

@section('stylesheet')
    @parent
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $(".users-list").select2({
            placeholder: "Выберите сотрудников",
            allowClear: true
        });
        $(".work-types-list").select2({
            placeholder: "Выберите типы работ",
            allowClear: true
        });
    </script>
@endsection
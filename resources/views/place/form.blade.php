<legend>Кабинеты</legend>
<div class="form-group{{$errors->has('place') ? ' has-error' : ''}}">
    {{ Form::label('place', 'Кабинет') }}
    {{ Form::text('place', old('place'), array('class' => 'form-control', 'placeholder' => 'Кабинет', 'required')) }}
    @if ($errors->has('place'))
        {{ Html::tag('span', Html::tag('strong', $errors->first('place'))->toHtml(),['class' => 'help-block']) }}
    @endif
</div>
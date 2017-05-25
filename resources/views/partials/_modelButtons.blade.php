<a href="{{route((in_array($class = strtolower((new ReflectionClass($model))->getShortName()), \Illuminate\Support\Pluralizer::$uncountable)?$class.'s':str_plural($class)).'.edit', [$model->id])}}" class="btn btn-info btn-xs" title="Редактировать">
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
</a>
{!! Form::open(['route' => [(in_array($class = strtolower((new ReflectionClass($model))->getShortName()), \Illuminate\Support\Pluralizer::$uncountable)?$class.'s':str_plural($class)).'.destroy', $model->id], 'method' => 'delete', 'class' => 'display-inline']) !!}
{{ Form::button('<i class="fa fa-times" aria-hidden="true"></i>', ['type' => 'submit','class' => 'btn btn-danger btn-xs', 'title' => 'Удалить']) }}
{!! Form::close() !!}
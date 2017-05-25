<h5>{{ Html::link(route('users.show', $user->id), $user->name) }}</h5>
{{ Html::link(route('users.addEquipment', [$user->id]), 'Закрепить оборудование', ['class' => 'btn btn-info btn-xs']) }}
@include('user._equipments', ['user' => $user])
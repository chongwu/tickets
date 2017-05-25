<div class="margin-top-10">
    @include('equipment._list', ['model' => $user, 'equipments' => $user->equipments, 'withoutHeader' => true])
</div>
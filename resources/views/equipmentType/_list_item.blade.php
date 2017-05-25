<a href="{{$equipmentType->folder?'#':route('equipment-types.show', [$equipmentType->id])}}" data-id="{{$equipmentType->id}}" class="list-group-item equipment-type{{$equipmentType->folder?' folder':''}}">
    <div class="col{{isset($deep)?' left-'.$deep:''}}" data-deep="{{isset($deep)?$deep:0}}">
        <i class="folder-icon fa {{$equipmentType->folder?'fa-folder-o':'fa-file-o'}}" aria-hidden="true"></i>
        <span class="equipment-type-name">{{$equipmentType->name}}</span>
        <form class="equipment-edit-name display-inline display-none" method="POST">
            <input type="text" class="form-control edit-name" data-id="{{$equipmentType->id}}" name="name"
                   placeholder="Наименование">
            <button data-url="{{route('equipment-types.update', $equipmentType->id)}}" class="btn btn-success btn-xs update-name" title="Сохранить">
                <i class="fa fa-floppy-o" aria-hidden="true"></i>
            </button>
            <button class="btn btn-danger btn-xs cancel-update" title="Отменить">
                <i class="fa fa-undo" aria-hidden="true"></i>
            </button>
        </form>
        <button data-url="{{route('equipment-types.edit', $equipmentType->id)}}" class="btn btn-info btn-xs edit-equipment-type" title="Редактировать">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </button>
        <button data-url="{{route('equipment-types.destroy', $equipmentType->id)}}" class="btn btn-danger btn-xs delete-equipment-type" title="Удалить">
            <i class="fa fa-times" aria-hidden="true"></i>
        </button>
    </div>
</a>
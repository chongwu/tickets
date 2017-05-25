<div class="row">
    <form class="form-inline equipment-form" method="POST">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="col-sm-4">
                <input id="name" type="text" class="form-control" name="name" placeholder="Наименование" size="50" required>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input id="folder" name="folder" type="checkbox"> Папка
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input id="rootfolder" name="rootfolder" type="checkbox" disabled="disabled"> Корневая папка
            </label>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-info">Добавить</button>
            </div>
        </div>
    </form>
</div>
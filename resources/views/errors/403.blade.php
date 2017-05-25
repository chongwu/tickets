<!DOCTYPE html>
<html>
    <head>
        <title>Ошибка 403</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        @include('errors._style')
    </head>
    <body>
    <div class="container">
        <div class="content">
            <div class="title">{{isset($error)?$error:'У вас недостаточно прав!'}}</div>
            <div>
                {{ Html::link(URL::previous(), 'Назад', ['class' => 'btn btn-info']) }}
                {{ Html::link(URL::route('home'), 'На главную', ['class' => 'btn btn-info']) }}
            </div>
        </div>
    </div>
    </body>
</html>

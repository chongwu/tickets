<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @section('stylesheet')
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @show

    <!-- Scripts -->
    @section('headScripts')
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    @show
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if(!Auth::guest())
                        @if(Auth::user()->isHeader())
                            <li>
                                <a href="{{ url('/report') }}">Отчет</a>
                            </li>
                        @endif
                        @if(Auth::user()->isSpecialist())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Справочники <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>{{ Html::link(route('equipment-types'), 'Типы оборудования') }}</li>
                                    <li>{{ Html::link(route('places.index'), 'Кабинеты') }}</li>
                                    <li>{{ Html::link(route('users.index'), 'Сотрудники') }}</li>
                                    <li>{{ Html::link(route('users.specialists'), 'Специалисты') }}</li>
                                    <li>{{ Html::link(route('work-types.index'), 'Типы работ') }}</li>
                                    <li>{{ Html::link(route('groups.index'), 'Группы специалистов')  }}</li>
                                    <li>{{ Html::link(route('import.equipments'), 'Загрузить оборудование') }}</li>
                                </ul>
                            </li>
                        @endif
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                Выйти ({{ Auth::user()->name }})
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div id="app">
        @yield('content')
    </div>

    <!-- Scripts -->
    @section('scripts')
        <script src="{{ asset('js/app.js') }}"></script>
    @show
</body>
</html>

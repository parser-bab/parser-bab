@extends('layouts.app')

@section('content')

    @guest
        <h1 class="text-white text-center">Авторизуйтесь, чтобы продолжить работу</h1>
    @else
        @if(!empty(auth()->user()->vk_token))
            <h3 class="text-white text-center">Действителен до [{{auth()->user()->vk_token_expires}}]</h3>
            <h3 class="text-white text-center">Количество запросов - @if(auth()->user()->requests_number == 0) 0 @else {{auth()->user()->requests_number}} @endif</h3>
        @endif


        <div class="container">
            @include('PersonalCabinet.includes.result_messages')
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <nav class="navbar navbar-toggler navbar-light">
                        <a class="btn btn-primary" href="{{route('PersonalCabinetCreateTask')}}">Добавить</a>
                    </nav>
                    <h3 class="text-center text-white">Список задач</h3>
                    <table class="table table-hover table-dark table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Название группы</th>
                            <th>Количество баб</th>
                            <th>Процесс выполнения</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endguest
@endsection

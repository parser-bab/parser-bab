@extends('layouts.app')

@section('content')

    @guest
        <h1 class="text-white text-center">Авторизуйтесь, чтобы продолжить работу</h1>
    @else
        @if(!empty(auth()->user()->vk_token))
            <h3 class="text-white text-center">Токен активен [{{auth()->user()->vk_token}}]</h3>
        @endif


        <div class="container">
            @include('PersonalCabinet.includes.result_messages')
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <nav class="navbar navbar-toggler navbar-light">
                        <a class="btn btn-primary" href="">Добавить</a>
                    </nav>
                    <table class="table table-hover table-dark table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Категория</th>
                            <th>Родитель</th>
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

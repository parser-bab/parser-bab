@extends('layouts.app')

@section('content')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <div class="container1">
        <div class="row1">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    <a class="btn btn-primary" href="{{route('PersonalCabinet')}}">На главную</a>
                    <form method="post" action="{{route('ApplicationResetCount')}}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-xs" data-title="Delete">Сбросить счетчик
                        </button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table id="mytable" class="table table-hover table-dark table-hover">
                        <thead>
                        <th>№</th>
                        <th>Client ID</th>
                        <th>Client Secret</th>
                        <th>Действителен до</th>
                        <th>Количество запросов</th>
                        <th>Получить токен</th>
                        <th>Удалить</th>
                        </thead>
                        <tbody class="">
                        @foreach($applications as $application)
                            <tr>
                                <td class="align-middle"><h3>{{$loop->iteration}}.</h3></td>
                                <td class="align-middle"><h3>{{$application->client_id}}</h3></td>
                                <td class="align-middle"><h3>{{$application->client_secret}}</h3></td>
                                <td class="align-middle"><h3>{{$application->vk_token_expires}}</h3></td>
                                <td class="align-middle"><h3>{{$application->count}}/5000</h3></td>
                                <td class="align-middle">
                                    <a class="btn btn-primary" href="{{route('ApplicationWriteId', $application->id)}}">+</a>
                                </td>
                                <td class="align-middle">
                                    <form style="margin: 0" method="post"
                                          action="{{route('application.destroy', ['application' => $application->id])}}">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-xs" data-title="Delete">X
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

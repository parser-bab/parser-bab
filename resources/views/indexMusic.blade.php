@extends('layouts.app')

@section('content')
    <div class="container">
        @include('PersonalCabinet.includes.result_messages')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav class="navbar navbar-toggler navbar-light">
                    @if(!auth()->guest())
                        @if (auth()->user()->id == 1)
                            <a class="btn btn-primary" href="{{route('PersonalCabinetCreateMusic')}}">Добавить бабу</a>
                            <a class="btn btn-primary" href="{{route('girl.online')}}">Обновить онлайн</a>
                        @endif
                    @endif
                    <a class="btn btn-primary" href="{{route('indexMusicAll')}}">Все бабы</a>
                    <a class="btn btn-primary" href="{{route('indexNormMusic')}}">Все бабы нормальные</a>
                    <a class="btn btn-primary" href="{{route('indexByDateMusic')}}">Все бабы по дате</a>
                    <a class="btn btn-primary" href="{{route('indexByCount')}}">Все бабы по количеству</a>
                </nav>
                <h3 class="text-center text-white">Баб</h3>
                <table class="table table-hover table-dark table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Количество баб</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($musics as $music)
                        <tr>
                            <td>
                                <a href="{{route('PersonalCabinetShowMusic', $music->id)}}"><h4>{{$music->title}}</h4></a>
                            </td>
                            <td>
                                <h4>{{$music->chickens_count}}</h4>
                            </td>
                            @if(!auth()->guest())
                                @if (auth()->user()->id == 1)
{{--                                    <td class="align-middle">--}}
{{--                                        <form style="margin: 0" method="post"--}}
{{--                                              action="">--}}
{{--                                            @csrf--}}
{{--                                            @method('delete')--}}
{{--                                            <button type="submit" class="btn btn-danger btn-xs" data-title="Delete">X--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
{{--                                    </td>--}}
                                @endif
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

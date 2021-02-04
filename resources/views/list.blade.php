@extends('layouts.app')

@section('content')


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <div class="container1">
        <div class="row1">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    <a class="btn btn-primary" href="{{route('PersonalCabinet')}}">На главную</a>
                </div>
                <div class="table-responsive">
                    <table id="mytable" class="table table-hover table-dark table-hover">
                        <thead>
                        <th>№</th>
                        <th>Фото</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Дата</th>
                        <th>Группа</th>
                        @if (auth()->user()->id == 1)
                            <th>Посты</th>
                            <th>Удалить</th>
                        @endif
                        </thead>
                        <tbody class="">
                        @foreach($lists as $list)


                            <tr @if($list->is_pisal === 1) style="background-color: #1a3972" @endif>
                                <td class="align-middle"><h3>{{$loop->iteration}}.</h3></td>
                                <td class="align-middle">
                                    <a href="{{$list->url}}" target="_blank">
                                        <img src="{{$list->photo}}" class="rounded-circle" width="200"
                                             height="200">
                                    </a>

                                </td>
                                <td class="align-middle"><h3>{{$list->first_name}}</h3></td>
                                <td class="align-middle"><h3>{{$list->last_name}}</h3></td>
                                <td class="align-middle"><h3>{{$list->bdate}}</h3></td>
                                <td class="align-middle">
                                    @foreach($list->groups as $group)
                                        <h3><a href="{{$group->url_group}}">| {{$group->title}} |</a></h3>
                                    @endforeach
                                </td>
                                @if (auth()->user()->id == 1)
                                    <td class="align-middle">
                                        <h3><a href="{{route('girl.show', $list->id)}}">Список постов</a></h3>
                                    </td>

                                    <td class="align-middle">
                                        <form style="margin: 0" method="post"
                                              action="{{route('list.destroy', ['list' => $list->id])}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-xs" data-title="Delete">X
                                            </button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        let cords = ['scrollX', 'scrollY'];
        // Перед закрытием записываем в локалсторадж window.scrollX и window.scrollY как scrollX и scrollY
        window.addEventListener('unload', e => cords.forEach(cord => localStorage[cord] = window[cord]));
        // Прокручиваем страницу к scrollX и scrollY из localStorage (либо 0,0 если там еще ничего нет)
        window.scroll(...cords.map(cord => localStorage[cord]));
    </script>
@endsection

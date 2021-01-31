@extends('layouts.app')

@section('content')

<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary" href="{{route('PersonalCabinet')}}">На главную</a>
            </div>

                <table class="table table-hover table-dark table-hover">
                    <thead>
                    <th>№</th>
                    <th>Фото</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Дата</th>
                    <th>Группа</th>
                    <th>Посты</th>
                    <th>Удалить</th>
                    </thead>
                    <tbody class="">
                    @foreach($lists as $list)


                        <tr @if($list->is_pisal === 1) style="background-color: #1a3972" @endif>
                            <td class="align-middle">{{$loop->iteration}}.</td>
                            <td class="align-middle">
                                <a href="{{$list->url}}" target="_blank">
                                    <img src="{{$list->photo}}" class="img-fluid rounded-circle" width="80" height="80">
                                </a>

                            </td>
                            <td class="align-middle">{{$list->first_name}}</td>
                            <td class="align-middle">{{$list->last_name}}</td>
                            <td class="align-middle">{{$list->bdate}}</td>
                            <td class="align-middle">
                                <a href="{{$list->group}}">{{$list->group_name}}</a>
                            </td>
                            <td class="align-middle">
                                <a href="{{route('girl.show', $list->id)}}">Список постов</a>
                            </td>
                            <td class="align-middle">
                                <form style="margin: 0" method="post" action="{{route('list.destroy', ['list' => $list->id])}}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-xs" data-title="Delete">X</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
<script>
    let cords = ['scrollX','scrollY'];
    // Перед закрытием записываем в локалсторадж window.scrollX и window.scrollY как scrollX и scrollY
    window.addEventListener('unload', e => cords.forEach(cord => localStorage[cord] = window[cord]));
    // Прокручиваем страницу к scrollX и scrollY из localStorage (либо 0,0 если там еще ничего нет)
    window.scroll(...cords.map(cord => localStorage[cord]));
</script>

@endsection

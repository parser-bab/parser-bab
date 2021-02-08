@extends('layouts.app')

@section('content')


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удаление бабы</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Удалить эту бабу?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
                    <button id="deleted" type="button" class="btn btn-danger" data-dismiss="modal">Пошла нахер, шкура
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container1">
        <div class="row1">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    <a class="btn btn-primary" href="{{route('PersonalCabinet')}}">На главную</a>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $lists->links() }}
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
                        @if(!auth()->guest())
                            @if (auth()->user()->id == 1)
                                <th>Писал</th>
                                <th>Посты</th>
                                <th>Удалить</th>
                            @endif
                        @endif

                        </thead>
                        <tbody class="">
                        @foreach($lists as $list)


                            <tr id="girl-{{$list->id}}"
                                @if($list->is_pisal === 1) style="background-color: #1a3972" @endif>
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
                                @if(!auth()->guest())
                                    @if (auth()->user()->id == 1)
                                        <td class="align-middle">
                                            <div class="form-check">
                                                {{--                                        <input name="is_pisal"--}}
                                                {{--                                               type="hidden"--}}
                                                {{--                                               value="{{['0' => $list->id]}}">--}}
                                                <input style=""
                                                       name="is_pisal"
                                                       type="checkbox"
                                                       class="btn-check"
                                                       id="{{$list->id}}" autocomplete="off"
                                                       value="{{$list->id}}"
                                                       @if($list->is_pisal)
                                                       checked="checked"
                                                    @endif
                                                >
                                                <label class="btn btn-outline-primary" for="{{$list->id}}">Писал</label>
                                            </div>
                                        </td>

                                        <td class="align-middle">
                                            <h3><a href="{{route('girl.show', $list->id)}}">Список постов</a></h3>
                                        </td>

                                        <td class="align-middle">
                                            <button type="button" class="delete-button btn btn-danger"
                                                    data-id="{{$list->id}}" data-toggle="modal"
                                                    data-target="#exampleModal">
                                                Удалить
                                            </button>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $lists->links() }}
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
    <script>
        $(function () {
            $('.btn-check').change(function () {
                if ($(this).is(":checked")) {
                    let id = $(this).val()
                    axios.post('/setpisal', {
                        id: id,
                        is_pisal: 1,
                    }).then((response) => {
                        console.log(id)
                        console.log(response.data)
                        $('#girl-' + (id)).css('background-color', function () {
                            return '#1a3972';
                        })
                    })
                } else {
                    let id = $(this).val()
                    axios.post('/setpisal', {
                        id: id,
                        is_pisal: 0,
                    }).then((response) => {
                        console.log(id)
                        console.log(response.data)
                        $('#girl-' + (id)).css('background-color', function () {
                            return '';
                        })
                    })
                }
            })

            $('.delete-button').on('click', function () {
                let a = $(this).data('id');
                $('#deleted').data('id', a)
                console.log($('#deleted').data('id'))
            })

            $('#deleted').on('click', function () {
                let id = $(this).data('id')
                axios.post('/deletegirl', {
                    id: id
                }).then((response) => {
                    console.log(id)
                    $('#girl-' + id).remove();
                })
            })

        })
    </script>
@endsection

@extends('layouts.app')

@section('content')

    @guest
        <h1 class="text-white text-center">Авторизуйтесь, чтобы продолжить работу</h1>
    @else
        @if(!empty(auth()->user()->vk_token))
            <h3 class="text-white text-center">Действителен до [{{auth()->user()->vk_token_expires}}]</h3>
            <h3 class="text-white text-center">Количество запросов - @if(auth()->user()->requests_number == 0)
                    0 @else {{auth()->user()->requests_number}} @endif</h3>

        @endif


        <div class="container">
            @include('PersonalCabinet.includes.result_messages')
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <nav class="navbar navbar-toggler navbar-light">
                        <a class="btn btn-primary" href="{{route('PersonalCabinetCreateTask')}}">Добавить</a>
                        <a class="btn btn-primary" href="{{route('list.index')}}">Все бабы</a>
                        <form style="margin: 0" method="post" action="{{route('job.clear')}}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-xs" data-title="Delete">Очистить джоб</button>
                        </form>
                        <a class="btn btn-primary" href="{{route('job.logs')}}">Logs job</a>
                    </nav>
                    <h3 class="text-center text-white">Список задач</h3>
                    <table class="table table-hover table-dark table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Название задачи</th>
                            <th>Количество баб</th>
                            <th>Процесс выполнения</th>
                            <th>Количество постов</th>
                            <th>Удалить</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>
                                    @if($task->progress == 100)
                                        <a href="{{route('task.show', $task->id)}}">{{$task->title}}</a>
                                    @else
                                        {{$task->title}}
                                    @endif
                                </td>
                                <td>
                                    @if (empty($task->number_girls))
                                        В процессе
                                    @else
                                    {{$task->number_girls}}
                                        @endif
                                </td>
                                <td>
                                    @if ($task->progress == 100)
                                        Завершено
                                    @else
                                        <div class="task-progress">
                                            <div class="progress">
                                                <div class="number-post"></div>
                                                <div class="progress-bar" role="progressbar" style="width: {{$task->progress}}%" aria-valuenow="47" aria-valuemin="0" aria-valuemax="100">50%</div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    {{$task->number_posts}}
                                </td>
                                <td class="align-middle">
                                    <form style="margin: 0" method="post" action="{{route('task.destroy', $task->id)}}">
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
    @endguest

@endsection

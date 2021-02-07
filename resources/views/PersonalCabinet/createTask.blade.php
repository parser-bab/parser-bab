@extends('layouts.app')

@section('content')
    <form method='POST' action="{{route('PersonalCabinetStoreTask')}}">
        @csrf
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title"></div>
                            <br>
                            <div class="tab-content">
                                <div class="tab-pane active" id="maindata" role="tabpanel">
{{--                                    <div class="form-group">--}}
{{--                                        <label for="title">Название</label>--}}
{{--                                        <input name="title"--}}
{{--                                               id="title"--}}
{{--                                               type="text"--}}
{{--                                               class="form-control"--}}
{{--                                               minlength="3"--}}
{{--                                               required>--}}
{{--                                    </div>--}}

                                    <div class="form-group">
                                        <label for="url_group">Ссылка на группу</label>
                                        <input name="url_group"
                                               id="url_group"
                                               type="text"
                                               class="form-control"
                                               minlength="3"
                                               required>
                                    </div>

                                    <div id="message" class=""></div>


                                    <div class="form-group">
                                        <label for="number_posts">Количество постов</label>
                                        <input name="number_posts"
                                               id="number_posts"
                                               type="text"
                                               class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="vk_token">Приложение</label>
                                        <select name="vk_token"
                                                id="vk_token"
                                                class="form-control"
                                                required>
                                            @foreach($applications as $application)
                                                <option value="{{$application->id}}"
                                                        @if($application->count == 5000 || !$application->access_token || $application->worked) disabled @endif>Приложение #{{$loop->iteration}}. [{{$application->count}}/5000]
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Запустить</button>
                                    <a href="{{route('PersonalCabinet')}}" class="btn btn-primary">Назад</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(function () {
            $('#url_group').change(function () {
                let data = {}
                axios.post('/check-task', {
                    url: $(this).val()
                }).then((response) => {
                    this.data = response.data
                    if (this.data.length !== 0) {
                        // $('#message').classList.remove('alert alert-success')
                        $("#message").removeClass("alert alert-success").addClass("alert alert-danger");
                        $('#message').html('Группа уже существует!')
                    }
                    else {
                        $("#message").removeClass("alert alert-danger").addClass("alert alert-success");
                        // $('#message').classList.remove('alert alert-danger')
                        $('#message').html('Можно парсить!')
                        // <div class="alert alert-success" role="alert">
                        //     Можно парсить!
                        // </div>
                    }
                    console.log($(this).val())
                    console.log(this.data)
                })
            })
        })
    </script>
@endsection

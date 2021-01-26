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
                                    <div class="form-group">
                                        <label for="title">Название</label>
                                        <input name="title"
                                               id="title"
                                               type="text"
                                               class="form-control"
                                               minlength="3"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="url_group">Ссылка на группу</label>
                                        <input name="url_group"
                                               id="url_group"
                                               type="text"
                                               class="form-control"
                                               minlength="3"
                                               required>
                                    </div>


                                    <div class="form-group">
                                        <label for="number_posts">Количество постов</label>
                                        <input name="number_posts"
                                               id="number_posts"
                                               type="text"
                                               class="form-control">
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
@endsection

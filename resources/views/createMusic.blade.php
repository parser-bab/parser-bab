@extends('layouts.app')

@section('content')
    <form method='POST' action="{{route('PersonalCabinetStoreMusic')}}">
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
                                        <label for="title">Название группы/трека</label>
                                        <input name="title"
                                               id="title"
                                               type="text"
                                               class="form-control"
                                               minlength="3"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="girl_id">Айди баб</label>
                                        <textarea class="form-control rounded-0" name="girl_id" id="girl_id" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Добавить</button>
                                    <a href="{{route('music')}}" class="btn btn-primary">Назад</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

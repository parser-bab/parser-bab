@extends('layouts.app')

@section('content')
    <form method='POST' action="{{route('application.store')}}">
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
                                        <label for="client_id">Client ID</label>
                                        <input name="client_id"
                                               id="client_id"
                                               type="text"
                                               class="form-control"
                                               minlength="3"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label for="client_secret">Client Secret</label>
                                        <input name="client_secret"
                                               id="client_secret"
                                               type="text"
                                               class="form-control"
                                               minlength="3"
                                               required>
                                    </div>


                                    <div class="form-group">
                                        <label for="redirect_uri">Redirect URI</label>
                                        <input name="redirect_uri"
                                               id="redirect_uri"
                                               type="text"
                                               class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Добавить</button>
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

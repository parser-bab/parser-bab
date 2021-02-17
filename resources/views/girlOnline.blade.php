@extends('layouts.app')

@section('content')
    {{--    <form method='GET' action="{{route('girl.update.online')}}">--}}
    @csrf
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Всего {{$girl_count}} баб</h3>
                <h3 id="checked"></h3>
                <a href="{{route('girl.update.online')}}" class="btn btn-primary">Обновить</a>
            </div>
        </div>
    </div>
    {{--    </form>--}}
@endsection

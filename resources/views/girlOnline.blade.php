@extends('layouts.app')

@section('content')
{{--    <form method='GET' action="{{route('girl.update.online')}}">--}}
        @csrf
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
{{--                    @if($update_online->work === 1)--}}
{{--                        <h3>Всего {{$girl_count}}</h3>--}}
{{--                        <h3 id="count">Обработано {{$update_online->count}}</h3>--}}
{{--                    @endif--}}
                    <a href="{{route('girl.update.online')}}" class="btn btn-primary">Обновить</a>
                </div>
            </div>
        </div>
{{--    </form>--}}
@endsection

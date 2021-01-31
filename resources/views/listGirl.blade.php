@extends('layouts.app')

@section('content')

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<div class="container">
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="mytable" class="table table-hover table-dark table-hover">
                <thead>
                <th>Фото</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Посты</th>
                <th>Писал</th>
                <th>Писал</th>
                </thead>
                <tbody class="">
                <form method="POST" action="{{route('girl.update',$girl->id)}}">
                <tr>
                        <td class="align-middle">
                            <a href="{{$girl->url}}" target="_blank">
                                <img src="{{$girl->photo}}" class="img-fluid rounded-circle" width="80" height="80">
                            </a>
                        </td>
                        <td class="align-middle">
                            {{$girl->first_name}}
                        </td>
                        <td class="align-middle">
                            {{$girl->last_name}}
                        </td>
                        <td class="align-middle">
                            @foreach($girl->posts as $post)
                                <a href="{{$post->url}}">Пост #{{$loop->iteration}}|</a>
                            @endforeach
                        </td>

                        <td class="align-middle">
                            <div class="form-check">
                                <input name="is_pisal"
                                       type="hidden"
                                       value="0">

                                <input name="is_pisal"
                                       type="checkbox"
                                       class="form-check-input"
                                       value="1"
                                       @if($girl->is_pisal)
                                       checked="checked"
                                        @endif
                                >
                                <label class="form-check-label" for="is_published">Писал</label>
                            </div>
                        </td>

                    <td>

                            @method('PATCH')
                            @csrf
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                    </td>

                    </tr>
                </form>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@endsection


<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">


        <div class="col-md-12">
            <div class="table-responsive">
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                    <th>№</th>
                    <th>Фото</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Дата</th>
                    <th>Группа</th>
                    <th>Удалить</th>
                    </thead>
                    <tbody class="">
                    @foreach($lists as $list)


                        <tr>
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
</div>

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                    <th>Id</th>
                    <th>Connection</th>
                    <th>Queue</th>
                    <th>Exception</th>
                    </thead>
                    <tbody class="">
                    <tr>
                        @foreach($data as $item)
                            <td class="align-middle">
                                {{$item->id}}
                            </td>
                            <td class="align-middle">
                                $item->connection
                            </td>
                            <td class="align-middle">
                                {{$item->queue}}
                            </td>
                            <td class="align-middle">
                                {{$item->exception}}
                            </td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

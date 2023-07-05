@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Список региональных центров</div>
                    <a href="{{ route('admin.regional_centers.create') }}" class="btn btn-primary btn-sm">Новый региональный центр</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Город</th>
                            <th>Регион</th>                            
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($regionalCenters AS $center)
                            <tr>
                                <td>{{ $center->id }}</td>
                                <td>{{ $center->city }}</td>
                                <td>{{ $center->region }}</td>                                
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.regional_centers.edit', $center) }}" class="btn btn-success">Изменить</a>
                                        <button type="button" data-action="{{ route('admin.regional_centers.destroy', $center) }}" class="btn btn-danger js-delete">Удалить</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

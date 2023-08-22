@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Список рекламных баннеров</div>
                    <a href="{{ route('admin.ad_banners.create') }}" class="btn btn-primary btn-sm">Новый баннер</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Наименование</th>                            
                            <th>Действия</th>                      
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($adBanners AS $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td>{{ $banner->name }}</td>                                
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.ad_banners.edit', $banner) }}" class="btn btn-success">Изменить</a>
                                        <button type="button" data-action="{{ route('admin.ad_banners.destroy', $banner) }}" class="btn btn-danger js-delete">Удалить</button>
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

@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <div class="h4 p-0 m-0">Список шаблонов сообщений</div>
                    <a href="{{ route('admin.bot_message_templates.create') }}" class="btn btn-primary btn-sm">Новый шаблон</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Наименование</th>
                            <th>Активно</th>
                            <th>Действия</th>                      
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($botMessageTemplates AS $template)
                            <tr class="{{$template->is_active === true ? '' : 'table-active'}}">
                                <td>{{ $template->id }}</td>
                                <td>{{ $template->name }}</td>
                                <td>{{ $template->is_active === true ? 'Да' : 'Нет'}}</td>                          
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.bot_message_templates.edit', $template) }}" class="btn btn-success">Изменить</a>
                                        <button type="button" data-action="{{ route('admin.bot_message_templates.destroy', $template) }}" class="btn btn-danger js-delete">Удалить</button>
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

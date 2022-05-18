@extends('layouts.admin')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список бронирований</div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>#</th>
              <th>Имя</th>
              <th>Телефон</th>
              <th>Отель</th>
              <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($bookings as $booking)
              <tr>
                <td><a href="{{ route('admin.bookings.show', $booking->id) }}">
                    {{ $booking->book_number }}
                  </a></td>
                <td>{{ $booking->client_fio }}</td>
                <td>{{ $booking->client_phone }}</td>
                <td>{{ $booking->room ? $booking->room->hotel->name : '' }}</td>
                <td>{{ $booking->on_show ? 'Просмотрена' : 'Новое' }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@stop
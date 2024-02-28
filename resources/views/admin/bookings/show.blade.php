@extends('layouts.admin')

@section('content')
  <div class="container-fluid">
    <div class="h2 text-center">Бронь: {{ $booking->book_number }}</div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title font-weight-bold">Инофрмация об пользователе</h5>

            <p>Имя пользователя: <b>{{ $booking->client_fio }}</b></p>
            <p>Телефон пользователя: <b>{{ $booking->client_phone }}</b></p>
            <p>Комментарий: <b>{{ $booking->book_comment }}</b></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title font-weight-bold">Данные отеля</h5>

            <p>Отель: <b>{{ $booking->room ? $booking->room->hotel->name : null }}</b></p>
            <p>Комната: <b>{{ $booking->room ? \Domain\Room\Actions\GetRoomFullNameAction::run($booking->room) : ''  }}</b></p>

            <p>Тип бронирования: <b>{{ $booking->type }}</b></p>
            @if($booking->book_type === 'hour')
              <p>Кол-во часов: <b>{{ $booking->hours_count }}</b></p>
              <p>Заезд: <b>{{ $booking['from-date']->format('d.m.Y H:i') }}</b></p>
            @endif
            @if($booking['to-date'] !== null)
              <p>Выезд: <b>{{ $booking['to-date']->format('d.m.Y H:i') }}</b></p>
            @endif
            <p>Статус: <b>{{ $booking->status ? \Domain\Room\Enums\BookingStatus::from($booking->status)->trans() : null }}</b></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title font-weight-bold">Данные отельера</h5>
            @if($booking->room)
              <p>Email: <b>{{ $booking->room->hotel->email }}</b></p>
              <p>Телефон: <b>{{ $booking->room->hotel->phone }}</b></p>
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>
@stop

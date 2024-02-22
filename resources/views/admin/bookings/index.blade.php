@extends('layouts.admin')

@section('content')
  <div class="px-4">
    <div class="card w-100">
      <div class="card-header">
        <div class="d-flex w-100 justify-content-between align-items-center">
          <div class="h4 p-0 m-0">Список бронирований</div>
        </div>
      </div>     
      <div class="card-body">
        <div class="mb-2">
          <form action="{{ route('admin.bookings.index') }}" method="get" class="w-100">
            <div class="row w-100">
              <div class="col-12 col-md-6 col-lg-3 form-group">
                <label>Дата создания</label>
                <input type="date" name="q_date" value="{{$q_date}}" class="form-control mb-2">
              </div>
              <div class="col-12 col-md-6 col-lg-3 form-group">
                <label>Номер бронирования</label>
                <input type="text" name="q_number" value="{{$q_number}}" class="form-control mb-2">
              </div>
              <div class="col-12 col-md-6 col-lg-3 form-group">
                <label>Имя</label>
                <input type="text" name="q_name" value="{{$q_name}}" class="form-control mb-2">
              </div>
              <div class="col-12 col-md-6 col-lg-3 form-group">
                <label>Телефон</label>
                <input type="text" name="q_phone" value="{{$q_phone}}" class="form-control mb-2">
              </div>
              <div class="col-12 col-md-6 col-lg-3 form-group">
                <label>Отель</label>
                <input type="text" name="q_hotel" value="{{$q_hotel}}" class="form-control mb-2">
              </div> 
              <div class="col-12 col-md-6 col-lg-3 form-group">
                <label>Дата заезда</label>
                <input type="date" name="q_date_from" value="{{$q_date_from}}" class="form-control mb-2">
              </div>
              <div class="col-12 col-md-6 col-lg-3 form-group">
                <label>Статус</label>
                <select name="q_status" data="booking-status-select" class="form-control font-weight-bold">
                  <option value="">
                    -
                  </option>
                  @foreach (\Domain\Room\Enums\BookingStatus::array() as $key => $value)                  
                  <option value="{{ $key }}"
                    @if ($key == $q_status)
                        selected="selected"
                    @endif
                    @switch($key)
                      @case('wait')
                        style="color: rgb(107 114 128);"
                        @break                      
                      @case('in')
                        style="color: rgb(37 99 235);"
                        @break
                      @case('out')
                        style="color: rgb(34 197 94);"
                        @break
                      @case('cc')
                        style="color: rgb(249 115 22);"
                        @break
                      @case('ch')
                        style="color: rgb(239 68 68);"
                        @break
                      @default
                      @break                           
                    @endswitch
                    class="font-weight-bold"
                  >
                    {{ $value }}
                  </option>
                  @endforeach
                </select>
              </div>                         
            </div>
            <div class="row w-100">
              <div class="col-auto ml-auto">
                <button type="submit" class="btn btn-primary">Найти</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-danger">Сброс</a>
              </div>
            </div>
          </form>          
        </div>        
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th>Дата создания</th>
              <th>Номер бронирования</th>
              <th>Название отеля</th>
              <th>Номер</th>
              <th>Период</th>
              <th>Заезд</th>
              <th>Выезд</th>
              <th>Имя</th>
              <th>Телефон</th>
              <th>Комментарий</th>             
              <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($bookings as $booking)
              <tr id="booking_{{$booking->id}}">
                <td>{{ $booking->created_at->format('d.m.Y - H:i') }}</td>
                <td>
                  <a href="{{ route('admin.bookings.show', $booking->id) }}">
                    {{ $booking->book_number }}
                  </a>
                </td>
                <td>
                  @if ($booking->room)
                    <a target="_blank" href="{{ route('hotels.show', $booking->room->hotel) }}">
                      {{ $booking->room->hotel->name }}
                    </a>
                  @endif                  
                </td>
                <td>{{ $booking->room ? \Domain\Room\Actions\GetRoomFullNameAction::run($booking->room) : '' }}</td>
                <td>{{ $booking->GetTypeAttribute() }}</td>
                <td>{{ $booking['from-date'] ? $booking['from-date']->format('d.m.Y - H:i') : ''}}</td>
                <td>{{ $booking['to-date'] ? $booking['to-date']->format('d.m.Y - H:i') : ''}}</td>
                <td>{{ $booking->client_fio }}</td>
                <td>{{ $booking->client_phone }}</td>
                <td>{{ $booking->book_comment }}</td>              
                <td>
                  <div class="d-flex">                   
                    <select name="status" data="booking-status-select" class="mr-2 form-control w-auto font-weight-bold">
                    @foreach (\Domain\Room\Enums\BookingStatus::array() as $key => $value)
                      <option value="{{ $key }}"
                        @if ($key == $booking->status)
                            selected="selected"
                        @endif
                        @switch($key)
                          @case('wait')
                            style="color: rgb(107 114 128);"
                            @break                      
                          @case('in')
                            style="color: rgb(37 99 235);"
                            @break
                          @case('out')
                            style="color: rgb(34 197 94);"
                            @break
                          @case('cc')
                            style="color: rgb(249 115 22);"
                            @break
                          @case('ch')
                            style="color: rgb(239 68 68);"
                            @break                            
                        @endswitch
                        class="font-weight-bold"
                      >
                        {{ $value }}
                      </option>
                    @endforeach
                    </select>
                    <button disabled data="booking-save" data-action-url="{{ route('admin.bookings.update', $booking) }}" class="btn btn-primary">Сохранить</button>
                  </div>                  
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row justify-content-center mt-2">
        <div class="col-auto">
          {{ $bookings->appends([
            'q_name' => $q_name,
            'q_phone' => $q_phone,
            'q_date' => $q_date,
            'q_number' => $q_number,
            'q_hotel' => $q_hotel,
            'q_date_from' => $q_date_from,
            'q_status' => $q_status
            ])->links()
          }}
        </div>
      </div>
    </div>
  </div>
  @section('js')
  <script>
    $(document).ready(function () {      
      
        $('[data="booking-status-select"]').each(function() {          
          $(this).attr("style", $(this).find(":selected").attr("style"));

          $(this).on("change", function() {           
            $(this).attr("style", $(this).find(":selected").attr("style"));
            $(this).parent().find('[data="booking-save"]').removeAttr("disabled");       
          });
        });

        $('[data="booking-save"]').each(function() {
          $(this).on("click", function() {
            if ($(this).attr("disabled")) return;

            let url = $(this).attr("data-action-url");
            let status = $(this).parent().find('[data="booking-status-select"]').val();
            $(this).attr("disabled", true);

            axios.put(url, { 
              status: status
            }, {             
              headers: {
                'Content-Type': 'application/json'
              }
            })
            .then(r => {             
              if (r?.data?.status == "success") {
              } else {
                $(this).removeAttr("disabled");
                alert("Ошибка при сохранении!");
              }
            })
            .catch(error => {
              $(this).removeAttr("disabled");
              alert("Ошибка при сохранении!");
            });
          });
        });
    })
  </script>
  @endsection
@stop
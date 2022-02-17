@if ($rooms)
  @foreach ($rooms as $room)
    @include('room._hot')
  @endforeach
@endif

@if ($hotels)
  @foreach ($hotels as $hotel)
    @include('hotel._popular')
  @endforeach
@endif
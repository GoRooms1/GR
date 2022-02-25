@if($moderate ?? false)
  @foreach ($hotels as $hotel)
    <div class="row row-sm position-relative">
      <div class="col-sm-6 col-lg-3 col-xxl-2" style="position: relative">
        <div class="position-sticky" style="top: 20px; margin-bottom: 20px;position: sticky;">
          @include('hotel._popular', ['moderate' => true])
        </div>
      </div>
      <div class="col-sm-6 col-lg-9 col-xxl-10">
        <div class="row">
          @foreach ($hotel->rooms()->where('moderate', true)->get() as $room)
            <div class="col-12">
              @include('room._hot')
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endforeach
@elseif ($rooms)
  @foreach ($rooms as $room)
    @include('room._hot')
  @endforeach
@elseif ($hotels)
  @foreach ($hotels as $hotel)
    @include('hotel._popular')
  @endforeach
@endif
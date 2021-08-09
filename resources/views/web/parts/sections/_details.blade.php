@php
    $is_room = !isset($hotel) && isset($room);
    $attrs = $is_room ? $room->attrs : $hotel->attrs;
@endphp

<section class="section section-light block-desktop">
    <div class="container">
        <div>
            <div class="h2 section-title section-title-mb-none">Детально об {{ $is_room ? 'номере' : 'отеле' }}
                <a href="#details-list-wrapper" class="details-list-btn" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="details-list-wrapper"></a>
            </div>
        </div>
        <div id="details-list-wrapper" class="catalog-filter collapse in" aria-expanded="true" role="tabpanel">
            <ul class="details-list">
                @foreach ($attrs as $attr)
                    <li>{{ $attr->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

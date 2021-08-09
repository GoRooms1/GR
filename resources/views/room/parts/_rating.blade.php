<div class="rating">
    <p class="rating-title"><span class="rating-title-text">Рейтинг</span> <span>{{ round($room->hotel->ratings()->avg
    ('value'), 1) }}</span> ({{ $room->hotel->reviews()->count() }})</p>
    <div class="rating-dropdown">
        <div class="rating-dropdown-in">
            <p class="rating-dropdown-header">{{ round($room->hotel->ratings()->avg('value'), 1) }} Превосходно <span>({{ $room->hotel->reviews()->count() }})</span></p>
            <ul class="rating-dropdown-content">
                @foreach(\App\Models\RatingCategory::orderBy('sort')->get() AS $category)
                    @php
                        $rating = $room->hotel->ratings()->where('category_id', $category->id)->avg('value');
                    @endphp
                    <li class="rating-dropdown-item">
                        <span>{{ round($rating, 1) }}</span> {{ $category->name }}
                    </li>
                @endforeach
                <li>
                    <a href="{{ $link ?? '' }}#reviews" data-toggle="tab">Читать отзывы</a>
                </li>
            </ul>
        </div>
    </div>
</div>

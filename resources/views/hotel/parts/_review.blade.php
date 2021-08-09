<div class="review">
    <div class="review-img-wrapper"></div>
    <div class="review-in">
        <div class="review-content">
            <p class="review-name">{{ $review->name }}@if($review->city), {{ $review->city }}@endif</p>
            <p class="review-date">{{ $review->created_at->format('d.m.Y') }}</p>
            <p class="review-text">{{ $review->text }}</p>
        </div>
        <div class="review-rating">
            <p class="review-rating-total">{{ round($review->ratings->avg('value'), 1) }}</p>
            <ul class="review-rating-list">
                @foreach($review->ratings->sortBy('category.sort') AS $rating)
                    <li class="rating-dropdown-item">
                        <span>{{ round($rating->value, 1) }}</span> {{ $rating->category->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
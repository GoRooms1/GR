<div class="form-group">
    <label for="name">Имя</label>
    <input type="text" class="form-control "
           value="{{ old('name') ?? optional(@$review)->name ?? '' }}" name="name" id="name"/>
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="city">Город</label>
    <input type="text" class="form-control "
           value="{{ old('city') ?? optional(@$review)->city ?? '' }}" name="city" id="city"/>
    @error('city')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="room">Номер</label>
    <input type="text" class="form-control "
           value="{{ old('room') ?? optional(@$review)->room ?? '' }}" name="room" id="room"/>
    @error('room')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <label for="text">Текст</label>
    <textarea class="form-control " name="text"
              id="text">{{ old('text') ?? optional(@$review)->text ?? '' }}</textarea>
    @error('text')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="dropdown-divider"></div>
<div class="h4">Рейтинг</div>
@foreach ($categories as $category)
    <div class="form-row">
        <div class="col-12">{{ $category->name }}</div>
        @php
        $rating_loop = $loop->index;
        @endphp
        @for ($i = 1; $i < 11; $i++)
            <div class="col-1">
                <div class="form-group text-center">
                    <label for="rating_{{$category->id}}_{{ $i }}" class="h3" style="cursor: pointer">{{ $i }}</label>
                    <input id="rating_{{$category->id}}_{{ $i }}"
                           type="radio"
                           class="form-control"
                           style="cursor: pointer"
                           name="rating[{{ $rating_loop }}][value]"
                           value="{{ $i }}"
                           @if(isset($review) && $review && $review->ratings()->where('category_id', $category->id)->first()->value === $i)
                               checked
                           @endif
                    >
                    <input type="hidden" name="rating[{{ $rating_loop }}][category_id]" value="{{ $category->id }}">
                </div>
            </div>
        @endfor
    </div>
@endforeach

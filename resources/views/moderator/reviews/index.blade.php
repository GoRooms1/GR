@extends('moderator.layouts.app')

@section('content')
<div class="px-4 mt-4">
    <div class="table-responsive rounded-top shadow p-0">
        <table class="table table-hover">
        <thead class="row__head_blue text-light">
            <tr>
                <th width="80px">#</th>
                <th width="120px">Дата создания</th>
                <th width="120px">Номер бронирования</th>
                <th width="160px">Имя</th>
                <th width="280px">Комментарий</th>
                <th width="280px">Фото</th>
                <th width="200px">Рейтинг</th>
                <th width="120px">Действия</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($reviews as $review)
            <tr>
            <td>
                {{ $review->id }}
            </td>
            <td>
                {{ $review->created_at->format('d.m.Y - H:i') }}
            </td>
            <td>
                {{ $review->book_number }}
            </td>
            <td>
                {{ $review->name }}
            </td>
            <td>                    
                {{ $review->text }}
            </td>
            <td>
                <a target="_blank" href="{{$review->getFirstMedia("images")->getUrl()}}">                    
                    <img src="{{$review->getFirstMedia("images")->getUrl('card')}}" class="img-thumbnail" style="max-width: 280px; ">
                </a>                                                
            </td>
            <td>
                @foreach ($review->ratings as $rating)
                <div class="d-flex">
                    <span class="">{{ $rating->category->name }}</span>
                    <span class="ml-auto">{{ $rating->value }}</span>
                </div>
                <div class="w-100 bg-light overflow-hidden rounded mb-2" style="height: 4px;">
                    <div class="h-100 bg-primary" style="width: {{$rating->value*10}}%;"></div>
                </div>                    
                @endforeach                 
            </td>
            <td class="d-flex flex-column justify-content-center">
                <a href="{{route('moderator.reviews.edit', $review)}}" class="button w-100 mb-4">
                    <i class="fa fa-pencil text-light" aria-hidden="true"></i>
                </a>                
                <form 
                    action="{{route('moderator.reviews.delete', $review)}}" method="POST" class="d-flex w-100 p-0"
                    onSubmit="return confirm('Вы действительно хотите удалить запись?') "
                >
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-100">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>                                             
            </td>                  
            </tr>              
        @endforeach
        </tbody>
        </table>
    </div>
    <div class="row justify-content-center my-4">
      <div class="col-auto">
        {{ $reviews->links() }}
      </div>
    </div>
  </div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        
    })
</script>
@endsection
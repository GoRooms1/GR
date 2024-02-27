@extends('moderator.layouts.app')

@section('content')
<div class="px-2 mt-4">
  <div class="shadow shadow-complete mx-auto" style="max-width: 1280px;">
    <div class="row row__head row__head_blue rounded-top" style="display: flex;">
        <div class="col-1">
          <p class="head-text">#{{ $review->id }}</p>
        </div>
        <div class="col-4">
          <p class="head-text">{{ $review->created_at->format('d.m.Y - H:i') }}</p>
        </div>
        <div class="col-4 offset-sm-1">
          <p class="head-text head-text_bold">№{{ $review->book_number }}</p>
        </div>
        <form 
          action="{{route('moderator.reviews.delete', $review)}}" method="POST" class="d-flex col-1 text-right ml-auto"
          onSubmit="return confirm('Вы действительно хотите удалить запись?') "
        >
          @csrf
          @method('DELETE')
          <button class="quote__remove text-white">
            <i class="fa fa-trash"></i>
          </button>
        </form>              
    </div>
    <div>     
      @if( Session::has( 'message' ))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get( 'message' ) }}
      </div>               
      @endif      
      <form action="{{ route('moderator.reviews.update', $review) }}" method="POST" enctype="multipart/form-data" class="w-100 p-2">
        @csrf
        @method('PUT')
        <div class="form-row">          
          @foreach ($review->ratings as $rating)
          <div class="form-group col-12 col-lg-6">
            <div class="d-flex w-100">
              <label>{{$rating->category->name}}</label>
              <label data="range-value" class="ml-auto">{{$rating->value}}</label>
            </div>
            <input data="range-input" type="range" name="rating[{{$rating->category->id}}]" min=0 max=10 step="0.1" value="{{$rating->value}}" class="form-control-range" style="height: 10px ;">
          </div>
          @endforeach          
        </div>      
        <div class="form-row">          
          <div class="col-12 col-lg-6">          
            <div class="form-group">
              <div class="d-flex">
                <label>Имя</label>
                @error('name')
                  <div class="text-danger ml-2 d-block">{{ $message }}</div>
                @enderror               
              </div>              
              <input type="text" name="name" value="{{old('name', $review->name)}}" class="form-control mb-2 @error('name') is-invalid @enderror">              
            </div>                    
            <div class="form-group">
              <div class="d-flex">
                <label>Комментарий</label>
                @error('comment')
                <div class="text-danger ml-2 d-block">{{ $message }}</div>
                @enderror
              </div>         
              <textarea name="comment" class="form-control mb-2 @error('comment') is-invalid @enderror h-100" rows="7">{{old('comment',  $review->text)}}</textarea>                   
            </div>            
          </div>
          <div class="col-12 col-lg-6">
            <div class="form-group">
              <div class="d-flex">
                <label>Фото</label>
                @error('photo')
                <div class="text-danger ml-2 d-block">{{ $message }}</div>
                @enderror
              </div>
              <input
                    type="file"
                    class="d-none"                
                    name="photo"                
                    id="photo"
                    accept="image/*"
                    onchange="document.getElementById('photo-preview').style.backgroundImage = 'url(' + window.URL.createObjectURL(this.files[0]) + ')';"                   
              />             
              <label for="photo" class="p-0 m-0">
                <div class="uploud-photo p-0 m-0 rounded" id="photo-preview" 
                    style="background-image: url({{asset($review->getFirstMedia("images")?->getUrl() ?? '/img/lk.upload.png')}}); background-size: contain;"
                >                    
                </div>
              </label>                                     
            </div>
          </div>
        </div>        
        <div class="form-row">
          <div class="col d-flex">
            <button type="submit" class="button">Сохранить</button>
            <a href="{{route('moderator.reviews.index', $hotel->id)}}" class="btn btn-secondary ml-4">Назад</a>
          </div>              
        </div>      
      </form>
    </div>
</div>

@endsection
@section('js')
<script>

  $(document).ready(function () {
    $('[data="range-input"]').each(function() {
      $(this).on('input', function() {
          $(this).parent().find('[data="range-value"]').html($(this).val());
      });
    });
  })

</script>
@endsection
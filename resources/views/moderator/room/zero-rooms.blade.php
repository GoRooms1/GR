@extends('moderator.layouts.app')

@section('content')
  <input type="hidden" name="category.update" value="{{ route('moderator.category.update') }}">
  <input type="hidden" name="category.create" value="{{ route('moderator.category.create') }}">
  <input type="hidden" name="category.delete" value="{{ route('moderator.category.delete', '') }}">

  <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
  <section class="part">
    <div class="container">
      <div class="row text-center">
        <div class="col-12 mt-5">
          <h1 class="title">У отеля на данный момент нет номеров</h1>
        </div>
      </div>
    </div>
  </section>



@endsection

@section('header-js')

@endsection

@section('js')

@endsection
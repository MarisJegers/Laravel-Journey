@extends('layouts.app')
  
@section('content')
<div class="row">
    <div class="col-sm-10"><h2>Ieraksata izvērstais skats</h2></div>
    <div class="col-sm-2"><a class="btn btn-primary" href="{{ route('posts.index') }}"> Atpakaļ</a></div>
</div> 
   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nosaukums:</strong>
                {{ $post->title }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Raksts:</strong>
                {{ $post->description }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Autors:</strong>
                {{ $post->user->name }}
            </div>
        </div>
    </div>
@endsection
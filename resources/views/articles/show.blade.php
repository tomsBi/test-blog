@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('articles.index') }}" class="btn btn-primary btn-sm">
            Back
        </a>
<div>
    <p class="text-sm-left">{{ $article->id }}</p>
    <h1>{{$article->title}}</h1>
    <p>{{$article->content}}</p>
</div>
    </div>

@endsection

@extends('layouts.app')

@section('title-block', 'News')

@section('content')
    <h1>News</h1>
    @foreach($data as $el)
        <div class="alert alert-info">
            <h3>{{ $el->name }}</h3>
            <p><small>{{ $el->created_at }}</small></p>
            <p>{{ $el->message }}</p>
            <img src="{{ $el->image }}" alt="" class="img-fluid" style="max-height: 200px !important;">
        </div>
    @endforeach
@endsection

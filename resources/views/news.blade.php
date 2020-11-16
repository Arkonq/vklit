@extends('layouts.app')

@section('title-block', 'Contacts')

@section('content')
    <h1>New post</h1>

    <form action="{{ route('news-form') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control" placeholder="Enter message"></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="text" name="image" placeholder="Enter image link (jpeg, png)" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Publicate</button>
    </form>
@endsection

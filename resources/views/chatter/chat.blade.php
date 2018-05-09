@extends('layouts.app')

@section('content')
    <div class="chat">
        <chat-room :conversations="{{ $conversations }}" :current_user="{{auth()->user()}}"></chat-room>
    </div>
@endsection

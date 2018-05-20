@extends('layouts.app')

@section('content')

    <div class="chat">
        <div class="row chat-one">
            <conversations></conversations>
            <div class="col-sm-8">
                @if(isset($conversation_id))
                    <chat-messages :current_user="{{auth()->user()}}" :conversation_id="{{$conversation_id}}"></chat-messages>
                @else
                    <p class="text-center">Пожалуйста, выберите диалог или создайте новый</p>
                @endif
            </div>
        </div>
    </div>

@endsection

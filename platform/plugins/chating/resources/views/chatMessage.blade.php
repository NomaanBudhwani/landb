@extends('core/base::layouts.master')

@section('content')
    <div class="p-3 bg-white">
        <div class="clearfix"></div>
        <div id="main">

            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">Customers</div>
                            <div class="card-body">
                                @if (!count($customers))
                                    <p>No customers</p>
                                @else
                                    <ul class="list-group list-group-flush">
                                        @foreach ($customers as $customer)
                                            <a href="{{ route('chating.messages.chat', [ 'ids' => auth()->user()->id  . '-' . $customer->id ]) }}" class="list-group-item list-group-item-action">{{ $customer->name }}</a>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9" id="chat-main">
                        <chat-component :auth-user="{{ auth()->user() }}" :other-user="{{ $otherUser }}" :messages="{{$messages}}" :sid="{{$sid}}"></chat-component>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop


@section('javascript')
    <script src="https://media.twiliocdn.com/sdk/js/chat/v3.3/twilio-chat.min.js"></script>
    <script></script>
@endsection
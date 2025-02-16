@props(['messages'])

@empty($messages)

@else
    <ul class="get-alert">
        @foreach ((array) $messages as $message)
            <span class="text-danger"><li>{{ $message }}</li></span>
        @endforeach
    </ul>
@endempty

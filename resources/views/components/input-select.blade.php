@props(['options'=> [], 'selected' => 0, 'type' => 0, 'values' => []])
@if($type == 0)
    <select {!! $attributes->merge(['class'=>'form-control']) !!}>
        <option selected disabled>--Select--</option>
        @foreach ($options as $option)
            <option @if ($selected == $option->id) selected @endif value="{{ $option->id }}">{{ $option->name }}</option>
        @endforeach
    </select>
@else
    <select {!! $attributes->merge(['class'=>'form-control']) !!}>
        <option selected disabled>--Select--</option>
        @foreach ($options as $key => $option)
            <option @if ($selected == $values[$key]) selected @endif value="{{ $values[$key] }}">{{ $option }}</option>
        @endforeach
    </select>
@endif

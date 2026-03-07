@props(['label', 'name', 'id', 'value'=>'', 'required' => ''])

    <input
        type="date"
        class="form-control"
        id="{{$id}}"
        name="{{$name}}"
        value="{{$value}}"
        {{ $required }}
    />


<div class="form-group {{ $class }}">
    @if ($label)
        <label>{!! $label !!}</label><br />
    @endif
    <div class="input-group">
        @if ($prepend)
            <div class="input-group-prepend">
                <div class="input-group-text">{{ $prepend }}</div>
            </div>
        @endif
        <select

            class="form-control"

            wire:model{{ $wireModifier }}="{{ $model }}"

            @if($multiple)
                multiple
            @endif

            {{ $attributes }}

            >

            @if ($placeholder)
                <option value="" disabled selected hidden>
                    {{ $placeholder }}
                </option>
            @endif

            {{ $slot }}

            @foreach ($options as $key => $val)
                <option value="{{ $key }}">{{ $val }}</option>
            @endforeach

        </select>
    </div>
    @error($model)
        <div class="small text-danger">{!! $message !!}</div>
    @enderror
</div>

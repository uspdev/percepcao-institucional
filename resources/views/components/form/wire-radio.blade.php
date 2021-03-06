@foreach ($arrValue as $key => $value)
    <div class="form-check form-check-inline {{ $class }} @error($model) text-danger @enderror" {{ $attributes }}
    style="margin-top: 0px; margin-bottom: 20px;">
        @if ($arrText)
            <label class="form-check-label" for="{{ $model.$key }}" style="cursor: pointer;">
        @endif
        <input
            type="radio"
            class="form-check-input"
            wire:model{{$wireModifier}}="{{ $model }}"
            name="{{ $model }}"
            id="{{ $model.$key }}"
            value="{{ $value }}"
            style="cursor: pointer;"
            @if ($disabled) disabled @endif
            >
        @if ($arrText)
            {{ $arrText[$key] }}
            </label>
        @endif
    </div>
@endforeach

@if ($showError)
    @error($model)
        <div class="small alert alert-danger">
            {!! $message !!}
        </div>
    @enderror
@endif

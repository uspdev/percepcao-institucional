<div class="{{ $class }}">
    <div class="form-group form-check">
        @if ($prepend)
            <div class="input-group-prepend">
                <div class="input-group-text">{{ $prepend }}</div>
            </div>
        @endif
        <input

            id="{{ $id }}"

            class="form-check-input {{ $classInput }}"

            type="checkbox"

            wire:model{{ $wireModifier }}="{{ $model }}"

            {{ $attributes }} />
        @if ($label)
            <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
        @endif
    </div>    
    @error($model)
        <span class="small text-danger">{{ $message }}</span>
    @enderror
</div>

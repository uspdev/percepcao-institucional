<div class="custom-control custom-switch ml-2 mt-2 {{ $class }}">
  <input

        type="checkbox"

        class="custom-control-input"

        id="{{ $id }}"

        wire:model{{$wireModifier}}="{{ $model }}"

        {{ $attributes }}/>
    <label class="custom-control-label" for="{{ $id }}">{{ $label }}</label>
</div>

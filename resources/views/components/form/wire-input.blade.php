<div class="@if($type === 'hidden') d-none @else form-group @endif {{ $class }}">
  @if ($label)
    <label for="{{ $id }}">{{ $label }}</label>
  @endif
  <div class="input-group">
    @if ($prepend)
      <div class="input-group-prepend">
        <div class="input-group-text">{{ $prepend }}</div>
      </div>
    @endif
    <input

        id="{{ $id }}"

        class="form-control"

        type="{{ $type }}"

        wire:model{{ $wireModifier }}="{{ $model }}"

        {{ $attributes }} />
  </div>
  @error($model)
    <span class="small text-danger">{!! $message !!}</span>
  @enderror
</div>

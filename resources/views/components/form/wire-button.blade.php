<button

    type="button"

    class="{{ $class }}"

    @if($click)
      wire:click{{ $wireModifier }}="{{ $click }}"
    @endif

    {{ $attributes }}>
  {{ $label }}
</button>

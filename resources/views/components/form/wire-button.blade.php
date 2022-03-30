<button

    type="button"

    class="{{ $class }}"

    @if($click)
      wire:click{{ $wireModifier }}="{{ $click }}"
    @endif

    {{ $attributes }}>
    @if ($action === 'preview')
        <x-icon.preview />
    @endif
    @if ($action === 'update')
        <x-icon.update />
    @endif
    @if ($action === 'delete')
        <x-icon.delete />
    @endif
    {{ $label }}
</button>

<button

    type="button"

    class="{{ $class }}"

    @if($click)
      wire:click{{ $wireModifier }}="{{ $click }}"
    @endif

    {{ $attributes }}>
    @if ($action === 'question')
        <x-icon.question class="{{ $classIcon }}" />
    @endif
    @if ($action === 'preview')
        <x-icon.preview class="{{ $classIcon }}" />
    @endif
    @if ($action === 'update')
        <x-icon.update class="{{ $classIcon }}" />
    @endif
    @if ($action === 'delete')
        <x-icon.delete class="{{ $classIcon }}" />
    @endif
    @if ($action === 'add')
        <x-icon.add class="{{ $classIcon }}" />
    @endif
    @if ($action === 'save')
        <x-icon.save class="{{ $classIcon }}" />
    @endif
    {{ $label }}
</button>

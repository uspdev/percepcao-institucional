<div class="form-group {{ $class }}" @if($xData) x-data="{{ $xData }}" @endif @if($dataLimit) data-limit="{{ $dataLimit }}" @endif>
  @if ($label)
    <label for="{{ $id }}">{!! $label !!}</label><br />
  @endif
  <div class="input-group">
    @if ($prepend)
      <div class="input-group-prepend">
        <div class="input-group-text">{{ $prepend }}</div>
      </div>
    @endif
    <textarea

      class="form-control {{ $class }}"

      id="{{ $id }}"

      wire:model{{ $wireModifier }}="{{ $model }}"

      {{ $attributes }}
    ></textarea>
  </div>
  @if($append)
    {!! $append !!}
  @endif
  @if($showError)
    @error($model)
      <div class="small text-danger">{{ $message }}</div>
    @enderror
  @endif
</div>

<div class="form-group {{ $class }}">
    @if ($label)
        <label for="{{ $model }}">{{ $label }}</label>
    @endif
    <div class="input-group date" id="{{ $model }}" data-target-input="nearest">
        @if ($prepend)
            <div class="input-group-prepend">
                <div class="input-group-text">{{ $prepend }}</div>
            </div>
        @endif
        <input type="text" id="{{ $model }}" class="form-control datetimepicker-input" wire:model{{ $wireModifier }}="{{ $model }}" data-target="#{{ $model }}"
            {{ $attributes }} />
        <div class="input-group-append" data-target="#{{ $model }}" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
    @error($model)
        <div class="small text-danger">
            {{ $message }}
        </div>
    @enderror
</div>

@if($endDate)
<div class="form-group {{ $class }}">
    @if ($labelEndDate)
        <label for="{{ $modelEndDate }}">{{ $labelEndDate }}</label>
    @endif
    <div class="input-group date" id="{{ $modelEndDate }}" data-target-input="nearest">
        @if ($prependEndDate)
            <div class="input-group-prepend">
                <div class="input-group-text">{{ $prependEndDate }}</div>
            </div>
        @endif
        <input type="text" id="{{ $modelEndDate }}" class="form-control datetimepicker-input" wire:model{{ $wireModifier }}="{{ $modelEndDate }}" data-target="#{{ $modelEndDate }}"
            {{ $attributes }} />
        <div class="input-group-append" data-target="#{{ $modelEndDate }}" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>
    </div>
    @error($modelEndDate)
        <div class="small text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
@endif

<script>
    $(function () {
        $('#{{ $model }}').datetimepicker({
            locale: 'pt-br',
            format: '{{ $dateTimeFormat }}',
            sideBySide: true,
            useCurrent: false //Important! See issue #1075
        });
        @if($endDate)
            $('#{{ $modelEndDate }}').datetimepicker({
                locale: 'pt-br',
                format: '{{ $dateTimeFormat }}',
                sideBySide: true,
                useCurrent: false //Important! See issue #1075
            });
        @endif

        $('#{{ $model }}').on('hide.datetimepicker', function (e) {
            if(e.date != null) {
                @this.set('{{ $model }}', e.date.format('{{ $dateTimeFormat }}'));
                @if($endDate)
                    $('#{{ $modelEndDate }}').datetimepicker('minDate', e.date);
                @endif
            }
        });

        @if($endDate)
            $('#{{ $modelEndDate }}').on('hide.datetimepicker', function (e) {
                if(e.date != null) {
                    @this.set('{{ $modelEndDate }}', e.date.format('{{ $dateTimeFormat }}'));
                    $('#{{ $model }}').datetimepicker('maxDate', e.date);
                }
            })
        @endif
    });
</script>
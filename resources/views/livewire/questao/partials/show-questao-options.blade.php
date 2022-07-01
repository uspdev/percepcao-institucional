@if($questao->campo['options'] != "")
@foreach ($questao->campo['options'] as $key => $option)
    <div class="d-flex flex-row justify-content-start align-items-start">
        @isset($option['key'])
            <div class="pl-4">
                <label for="" class="bold">Chave(key):</label>
                {{ $option['key'] ?? '' }}
            </div>
        @endisset
        @isset($option['value'])
            <div class="pl-4">
                <label for="" class="bold">valor(value):</label>
                {{ $option['value'] ?? '' }}
            </div>
        @endisset
    </div>
@endforeach
@endif
<div
    x-data="{
        setDefault: function() {
            this.newValue = '{{ $value }}';
            this.edit = null;
            this.error = null;
        },
        focus: function() {
            const textInput = this.$refs.textInput;
            textInput.focus();
            textInput.select();
        }
    }"
    x-init="setDefault()"
    x-cloak
    >
    <span
        @click="
            newValue = $el.innerHTML.trim();
            edit = {{ $id }};
            $nextTick(() => focus())"
        x-show="edit !== {{ $id }}"
        >
        {{ $value }}
    </span>
    <div
        x-show="edit === {{ $id }}"
        x-transition:enter.duration.500ms
        >
        <input
            type="text"
            x-show="edit === {{ $id }}"
            x-ref="textInput"
            x-model="newValue"
            @click.away="setDefault();"
            @keydown.escape="setDefault();"
            @keydown.enter="
                if (newValue.length > 0) {
                    $wire.updateTexto({{ $id }}, $refs.textInput.value);
                    setDefault();
                } else {
                    error = {{ $id }};
                }"
            style="width: 100%"
            />
        <div
            class="small font-italic"
            x-transition:leave.duration.50ms
            >
            Pressione Enter para salvar ou Esc para cancelar
        </div>
    </div>
    <div
        class="small text-danger"
        x-show="error === {{ $id }}"
        x-transition
        >
        O campo não pode ser deixado em branco
    </div>
</div>
<div id="sortableAlpine" class="list-group nested-sortable"
    x-data="{}"
    x-init="Sortable.create($el, {
        group: 'nested',
        animation: 150,
        handle: '.handler',
        onSort: function (e) {
            function serialize(sortable) {
                var serialized = [];
                var children = [].slice.call(sortable.children);
                for (var i in children) {
                    var nested = children[i].querySelector('.nested-sortable');
                    var closest = children[i].closest('.list-group');
                    var parent_id = (closest.closest('.list-group-item') === null) ? null : closest.closest('.list-group-item').dataset['sortableId'];
                    serialized.push({
                        id: children[i].dataset['sortableId'],
                        parent: parent_id,
                        children: nested ? serialize(nested) : []
                    });
                }
                return serialized
            }
            const root = document.getElementById('sortableAlpine');
            @this.updateOrder(serialize(root));
        }
    })"
>
    @if (count($grupos) > 0)
        @foreach ($grupos as $grupo)
            <div data-sortable-id="{{ $grupo->id }}" id="grupo-{{ $grupo->id }}" class="list-group-item nested-1">
                <span>
                    <x-icon.menu class="w-4 h-4 opacity-50 cursor-move icon-sortable handler" />
                </span>
                <span class="texto-sortable">
                    <x-alpine.text-inline-edit :value="$grupo->texto" :id="$grupo->id" />
                </span>
                @if (!$grupo->grupos->count())
                    <span class="acoes-sortable">
                        <x-form.wire-button
                            class="btn btn-danger text-danger btn-icon"
                            click="getSelectedId({{ $grupo->id }}, 'delete')"
                            action="delete"
                            data-toggle="modal"
                            data-target="#excluirModal"
                            />
                    </span>
                @endif
                <div class="clear"></div>
                <x-subgrupo :childGrupos="$grupo" :principal="true" :subgrupo="1" />
            </div>
        @endforeach
    @endif
</div>
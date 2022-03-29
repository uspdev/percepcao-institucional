@if ($principal === false)
    <div data-sortable-id="{{ $childGrupos->id }}" class="list-group-item nested-{{ $subgrupo }}">
        <span class="texto-sortable">{{ $childGrupos->texto }}</span>
        @if (!$childGrupos->grupos->count())
            <span class="acoes-sortable">
                <x-form.wire-button
                    class="btn btn-danger text-danger btn-icon"
                    click="getSelectedId({{ $childGrupos->id }}, 'delete')"
                    action="delete"
                    data-toggle="modal"
                    data-target="#excluirModal"
                    />
            </span>
        @endif
        <div class="clear"></div>
@endif
    @if ($childGrupos->grupos)
        <div id="sortableAlpine" class="list-group nested-sortable"
            x-data="{}"
            x-init="Sortable.create($el, {
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65,
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
            @if (count($childGrupos->grupos) > 0)
                @php
                    $subgrupo++;
                @endphp
                @foreach ($childGrupos->grupos as $subGrupos)
                    <x-subgrupo :childGrupos="$subGrupos" :principal="false" :subgrupo="$subgrupo" />
                @endforeach
            @else
                @php
                    $subgrupo = 2;
                @endphp
            @endif
            </div>
        @endif
@if ($principal === false)
    </div>
@endif
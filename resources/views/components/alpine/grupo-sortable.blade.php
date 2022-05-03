<div id="sortableAlpine" class="list-group nested-sortable"
    @if ($canDelete)
        x-data="{}"
        x-init="Sortable.create($el, {
            group: 'nested',
            animation: 150,
            handle: '.handler',
            @if ($useFallback)
                fallbackOnBody: true,
                swapThreshold: 0.65,
            @endif
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
                @this.updateOrdem(serialize(root));
            }
        })"
    @endif
    >
    {{ $slot }}
</div>
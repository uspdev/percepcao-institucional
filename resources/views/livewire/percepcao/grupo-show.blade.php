@if (count($grupos) > 0)        
    @foreach ($grupos as $grupo)
        <div data-sortable-id="{{ $grupo->id }}" class="list-group-item nested-1">{{ $grupo->texto }}
            @if (count($grupo->grupos) > 0)                                                                                        
                @livewire('percepcao.grupo-sub-grupo-show', ['childGrupos' => $grupo, 'subgrupo' => 1, 'principal' => true], key($grupo->id . time()))                    
                
            @else
            <div class="list-group nested-sortable"></div>
            @endif                
        </div>
    @endforeach        
@endif

@once
    @section('javascripts_bottom')
    <script>
        $(function () {
            const nestedQuery = '.nested-sortable';
            const identifier = 'sortableId';
            const root = document.getElementById('nestedDemo');

            var nestedSortables = [].slice.call(document.querySelectorAll(nestedQuery));
            
            function sort(sortables) {
                // Loop through each nested sortable element
                for (var i = 0; i < sortables.length; i++) {
                    new Sortable(sortables[i], {
                        group: 'nested',
                        animation: 150,
                        fallbackOnBody: true,
                        swapThreshold: 0.65,
                        onSort: function (e) {
                            @this.updateOrder(serialize(root));
                        }
                    });
                }
            }

            sort(nestedSortables);
            
            function serialize(sortable) {
                var serialized = [];
                var children = [].slice.call(sortable.children);
                for (var i in children) {                    
                    var nested = children[i].querySelector(nestedQuery);
                    var closest = children[i].closest(".list-group");
                    var parent_id = (closest.closest(".list-group-item") === null) ? null : closest.closest(".list-group-item").dataset[identifier];
                    serialized.push({
                        id: children[i].dataset[identifier],
                        parent: parent_id,
                        children: nested ? serialize(nested) : []
                    });
                }
                return serialized
            }

            window.addEventListener('contentChanged', event => {
                var nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));
                sort(nestedSortables);
            });
        });
    </script>
    @endsection
@endonce
				
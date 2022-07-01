<div class="container" id="cadastro-questao">
    <h2 class="text-center font-weight-bold">Cadastro de questões</h2>
    <hr>
    <div>
        @include('livewire.questao.partials.create-form')
    </div>
    <div>
        @livewire('questao.show', key(time()))
    </div>

    @section('javascripts_bottom')
        @parent
        <script>
            function handler() {
                return {
                    openAddQuestao: false,
                    selectedField: @entangle('selectedField'),
                    fields: [],

                    addNewOption() {
                        this.fields.push({id: new Date().getTime() + this.fields.length});
                    },
                    removeOption(field) {
                        this.fields.splice(this.fields.indexOf(field, 1));
                    },
                }
            }

            Livewire.on('gotoUpdate', section => {
                var addTop;
                if (section == 'cadastro-questao') {
                    addTop = 0;
                } else {
                    addTop = 300;
                }
                $('html, body').animate({
                    scrollTop: $('#' + section).offset().top +addTop
                }, 500, 'swing');
            });
        </script>
    @endsection
</div>

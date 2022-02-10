<div class="container" style="max-width: 1000px">
  <h2 class="text-center font-weight-bold">Percepção Institucional - Avaliar</h2>
  <hr>
  @if($this->percepcao)
    @if(!$this->statusPercepcao)
      <div class="text-danger font-weight-bold">
        O presente questionário será utilizado na EEL-USP para melhoria da qualidade de ensino. As identidades serão preservadas com total sigilo.
      </div>
      <br />
      <div>
        <label class="font-weight-bold">Quem está fazendo: </label>
        <span>{{ Auth::user()->name }}</span>
      </div>
      <div>
        <label class="font-weight-bold">Ano: </label>
        <span>{{ $percepcao->ano }}</span>
      </div>
      <div>
        <label class="font-weight-bold">Semestre: </label>
        <span>{{ $percepcao->semestre }}</span>
      </div>
      <br />
      <p class="text-center">
        <label class="font-weight-bold">1. PERCEPÇÃO DO ALUNO EM CADA DISCIPLINA</label>
      </p>

      @foreach($avaliacaoQuesitos as $indexAvaliacaoQuesito => $valorAvaliacaoQuesito)
      <fieldset class="border p-3" id="{{ $valorAvaliacaoQuesito['codigoDaDisciplina'] }}-{{ $indexAvaliacaoQuesito }}">
        <legend  class="w-auto h6 text-info" data-toggle="collapse" data-target="#collapse-{{ $valorAvaliacaoQuesito['codigoDaDisciplina'] }}-{{ $indexAvaliacaoQuesito }}" aria-expanded="false" aria-controls="collapse-{{ $valorAvaliacaoQuesito['codigoDaDisciplina'] }}-{{ $indexAvaliacaoQuesito }}" style="cursor: pointer;">PERCEPÇÃO DO ALUNO NA DISCIPLINA {{ mb_strtoupper($valorAvaliacaoQuesito['nomeDaDisciplina']) }}({{ mb_strtoupper( $valorAvaliacaoQuesito['codigoDaDisciplina'] ) }})</legend>

        <div id="collapse-{{ $valorAvaliacaoQuesito['codigoDaDisciplina'] }}-{{ $indexAvaliacaoQuesito }}" class="collapse show form-group text-justify">
          <p>
            <div class="h6">Ministrante da disciplina: </div><span>{{ $pessoa::obterNome($valorAvaliacaoQuesito['ministranteDaDisciplina']) }}</span>
          </p>
          <p>
            <div class="h6">Código da disciplina: </div><span>{{ $valorAvaliacaoQuesito['codigoDaDisciplina'] }}</span>
          </p>
          <p>
            <div class="h6">Nome da disciplina: </div><span>{{ $valorAvaliacaoQuesito['nomeDaDisciplina'] }}</span>
          </p>
          <p>
            <div class="h6">Versão da disciplina: </div><span>{{ $valorAvaliacaoQuesito['versaoDaDisciplina'] }}</span>
          </p>
          <p>
            <div class="h6">Código da turma: </div><span>{{ $valorAvaliacaoQuesito['codigoDaTurma'] }}</span>
          </p>
          <p>
            <div class="h6">Tipo da turma: </div><span>{{ $valorAvaliacaoQuesito['tipoDaTurma'] }}</span>
          </p>
          @foreach($disciplinaQuesitos as $indexDisciplinaQuesito => $valorDisciplinaQuesito)
          <div>
            <span class="h6">{{ $disciplinaQuesitos[$indexDisciplinaQuesito] }}:</span>
          </div>
          <x-form.wire-radio
                  :model="'avaliacaoQuesitos.'.$indexAvaliacaoQuesito.'.'.$indexDisciplinaQuesito"
                  :arrValue="[1, 2, 3, 4, 5]"
                  :arrText="['Muito ruim', 'Ruim', 'Regular', 'Bom', 'Muito bom']"
                   style="margin-left: 40px; margin-top: 15px; margin-bottom: 15px;"
                />
          @endforeach
          <br /><br />
          <fieldset class="border p-3">
            <legend  class="w-auto h6 text-info">AUTO AVALIAÇÃO DO ALUNO NA DISCIPLINA {{ mb_strtoupper($valorAvaliacaoQuesito['nomeDaDisciplina']) }}({{ mb_strtoupper( $valorAvaliacaoQuesito['codigoDaDisciplina'] ) }})</legend>
            @foreach($alunoQuesitos as $indexAlunoQuesito => $valorAlunoQuesito)
            <div>
              <span class="h6">{{ $alunoQuesitos[$indexAlunoQuesito] }}:</span>
            </div>
            <x-form.wire-radio
                  model="avaliacaoQuesitos.{{ $indexAvaliacaoQuesito }}.{{ $indexAlunoQuesito }}"
                  :arrValue="[1, 2, 3, 4, 5]"
                  :arrText="['Muito ruim', 'Ruim', 'Regular', 'Bom', 'Muito bom']"
                   style="margin-left: 40px; margin-top: 15px; margin-bottom: 15px;"
                />
            @endforeach
          </fieldset>
          <br />
          <x-form.wire-textarea
                  model="avaliacaoQuesitos.{{ $indexAvaliacaoQuesito }}.comentariosESugestoesDoAluno"
                  label="<span class='h6'>COMENTÁRIOS E SUGESTÕES DO ALUNO NA DISCIPLINA<br /> {{ mb_strtoupper($valorAvaliacaoQuesito['nomeDaDisciplina']) }} ({{ mb_strtoupper($valorAvaliacaoQuesito['codigoDaDisciplina']) }}) <span class='text-danger'>(OPCIONAL)</span></span>"
                  wireModifier=".defer"
                  xData='{
                            content: "",
                            limit: $el.dataset.limit,
                            get remaining() {
                                return this.limit - this.content.length
                            }
                        }'
                  dataLimit="{{ $this->limiteComentariosDisciplina }}"
                  append="<p id='remaining'>
                              <span class='small'>Conteúdo limitado a <span x-text='limit'></span> caracteres, restando: <span class='font-weight-bold' x-text='remaining'></span><span>
                          </p>"
                  rows="5" maxlength="{{ $this->limiteComentariosDisciplina }}" id="content" x-model="content"
                />
        </div>
        <div id="collapse-{{ $valorAvaliacaoQuesito['codigoDaDisciplina'] }}-{{ $indexAvaliacaoQuesito }}" class="collapse form-group text-justify">
          Clique no título para exibir
        </div>
      </fieldset>
      <br />
      @endforeach
      <p class="text-center">
        <label class="font-weight-bold">2. COMENTÁRIOS E SUGESTÕES GERAIS</label>
      </p>
      <x-form.wire-textarea
              model="comentariosESugestoesGerais"
              label="<span class='h6'>COMENTÁRIOS E SUGESTÕES GERAIS</span>"
              wireModifier=".defer"
              xData='{
                        content: "",
                        limit: $el.dataset.limit,
                        get remaining() {
                            return this.limit - this.content.length
                        }
                    }'
              dataLimit="{{ $this->limiteComentarioGeral }}"
              append="<p id='remaining'>
                          <span class='small'>Conteúdo limitado a <span x-text='limit'></span> caracteres, restando: <span class='font-weight-bold' x-text='remaining'></span><span>
                      </p>"
              rows="5" maxlength="{{ $this->limiteComentarioGeral }}" id="content" x-model="content"
            />
      @if ($errors->any())
        @error('disciplina')
        <div class="alert alert-danger">
            <span>{{$message}}</span>
        </div>

        @enderror
      @endif
      <button wire:click.prevent='save' class="btn btn-primary">Enviar</button>
    @else
      <div class="font-weight-bold text-center mt-5">
        {!! $this->statusPercepcao !!}
      </div>
    @endif
  @else
    <div class="font-weight-bold text-center mt-5">
      Nenhuma Percepção Institucional foi encontrada para este ano/semestre.
    </div>
  @endif
</div>

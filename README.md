# Percepção institucional

Sistema que apresenta questionário para alunos de graduação que cursaram disciplinas em determinado semestre.

## Dependências
-   PHP 7.4
-   Credenciais para senha única
-   Acesso ao replicado

## Instalação e Configuração

Instalação padrão do Laravel

## Uso (gerente)

* Deve-se cadastrar uma nova percepção correspondente a um determinado semestre letivo.
* A percepção estará disponível no período indicado pelas datas de abertura e fechamento.
* Pode haver somente uma percepção ativa simultâneamente.
* Deve-se cadastrar os grupos que irão englobar as questões da percepção.
    Ex.: PERCEPÇÃO DO ALUNO EM CADA DISCIPLINA
* Deve-se cadastrar as questões que serão usadas na percepção.
    Ex.: Apresentação/Cumprimento do plano de ensino
* Deve-se associar os grupos e questões na(s) percepção(ões) que irá(ão) usá-las.


* Caso uma disciplina possua mais de um professor, o aluno avaliará cada um deles separadamente.
* Disciplinas tipo Estagio TCC não serão avaliadas.

* A edição das perguntas de uma percepção só é possivel antes do período de respostas.

## Permissões

* A pessoa do serviço de graduação que irá operar deverá ser gerente
* Deverão ser cadastrados os membros especiais
* A liberação de docentes é por meio da senha única
* A liberação de alunos é por meio da senha única
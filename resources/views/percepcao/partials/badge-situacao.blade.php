{!! $percepcao->isAberto() ? '<span class="badge badge-primary">Aberto</span>' : '' !!}
{!! $percepcao->isFinalizado() ? '<span class="badge badge-secondary">Finalizado</span>' : '' !!}
{!! $percepcao->isFuturo() ? '<span class="badge badge-success">Em elaboração</span>' : '' !!}
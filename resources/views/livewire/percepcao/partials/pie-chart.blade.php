<div class="chart-container pt-2">
  @if (isset($disciplina))
    <canvas
      id="myChart-{{ $percepcao->id }}-{{ $grupo['id'] }}-{{ $questao['id'] }}-disciplina-{{ $disciplina->id ?? '' }}"></canvas>
  @elseif (isset($coordenador))
    <canvas
      id="myChart-{{ $percepcao->id }}-{{ $grupo['id'] }}-{{ $questao['id'] }}-coordenador-{{ $coordenador->id ?? '' }}"></canvas>
  @else
    <canvas id="myChart"></canvas>
  @endif
</div>

<script>
  Chart.register(ChartDataLabels);

  const data = {
    labels: [
      @if (isset($disciplina))
        {!! $this->getRespostas($grupo['id'], $questao['id'], $percepcao->id, $disciplina->id)['textoRespostas'] !!}
      @else
        {!! $this->getRespostas($grupo['id'], $questao['id'], $percepcao->id, null, $coordenador->id)['textoRespostas'] !!}
      @endif
    ],
    datasets: [{
      data: [
        @if (isset($disciplina))
          {!! $this->getRespostas($grupo['id'], $questao['id'], $percepcao->id, $disciplina->id)['valorRespostas'] !!}
        @else
          {!! $this->getRespostas($grupo['id'], $questao['id'], $percepcao->id, null, $coordenador->id)['valorRespostas'] !!}
        @endif
      ],
      backgroundColor: [
        '#19263c',
        '#e6693e',
        '#8a0015',
        '#89c224',
        '#44abcc'
      ],
      borderColor: "#fff",
    }],
  };

  const options = {
    maintainAspectRatio: false,
    plugins: {
      datalabels: {
        anchor: 'center',
        labels: {
          value: {
            color: 'white',
            formatter: function(value, ctx) {
              if (value != 0) {
                return value + '%';
              } else {
                return '';
              }
            },
          },
        },
      },
      legend: {
        position: window.innerWidth > 768 ? 'right' : 'bottom',
        align: window.innerWidth > 768 ? 'center' : 'start',
        labels: {
          usePointStyle: true,
        },
        onHover: function handleHover(evt, item, legend) {
          legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
            colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
          });
          legend.chart.update();
        },
        onLeave: function handleLeave(evt, item, legend) {
          legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
            colors[index] = color.length === 9 ? color.slice(0, -2) : color;
          });
          legend.chart.update();
        }
      },
      tooltip: {
        callbacks: {
          label: tooltipItem => {
            if (data.datasets[0].data[tooltipItem.dataIndex] != 0) {
              return data.labels[tooltipItem.dataIndex];
            }
          },
        },
      },
    },
  }

  const config = {
    type: 'pie',
    data: data,
    options: options
  };

  var canvasId = 'myChart';

  @if (isset($disciplina))
    canvasId =
      'myChart-{{ $percepcao->id }}-{{ $grupo['id'] }}-{{ $questao['id'] }}-disciplina-{{ $disciplina->id ?? '' }}';
  @endif

  @if (isset($coordenador))
    canvasId =
      'myChart-{{ $percepcao->id }}-{{ $grupo['id'] }}-{{ $questao['id'] }}-coordenador-{{ $coordenador->id ?? '' }}';
  @endif

  const myChart = new Chart(
    document.getElementById(canvasId),
    config
  );
</script>

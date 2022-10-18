<?php

namespace App\Services;

use Amenadiel\JpGraph\Graph\Graph as JpGraph;
use Amenadiel\JpGraph\Plot;

class Grafico
{

    /**
     * Cria gráfico de barras simples com a contagem para cada valor
     * usando a biblioteca jpgraph.
     *
     * Cada option do array de options deve conter:
     *  [
     *    "value" => "Muito ruim",
     *    "contagem" => 1
     *  ]
     *
     * @param Array $option
     * @return String contendo o stream png
     */
    public static function barras($options)
    {
        $datay = array_column($options, 'contagem');
        $xLabels = array_column($options, 'value');

        $yLabelSize = 14;
        $yLabelFormat = '%d';
        $fillColor = 'orange';

        $height = 180;
        // a largura depende do número de options
        $width = count($datay) * $height / 2; //se houver 2 options, o resultado é uma imagem quadrada

        // Create the graph and setup the basic parameters
        $graph = new JpGraph($width, $height, 'auto');
        $graph->SetScale('textint');
        $graph->SetFrame(true); // show border around the graph
        $graph->SetBox(false); // remove a caixa ao redor do gráfico

        // Add some grace to the top so that the scale doesn't end exactly at the max value.
        // $graph->yaxis->scale->SetGrace(100);
        $graph->yaxis->Hide(); // sem o eixo Y

        // Setup X-axis labels
        $graph->xaxis->SetTickLabels($xLabels);
        $graph->xaxis->SetFont(FF_ARIAL);

        // Create a bar pot
        $bplot = new Plot\BarPlot($datay);
        $bplot->SetFillColor($fillColor);
        $bplot->SetWidth(0.8); // largura da barra. Se 1, uma barra encosta na outra
        $bplot->value->SetFont(FF_ARIAL, FS_BOLD, $yLabelSize); // Ajustando fonte, tamanho,
        $bplot->value->SetFormat($yLabelFormat); // formato de exibição
        $bplot->value->Show(); // Mostra os valores no topo de cada barra do gráfico
        $graph->Add($bplot);

        // Finally stroke the graph
        $img = $graph->Stroke(_IMG_HANDLER);
        ob_start(); // start buffering
        $graph->img->Stream(); // print data to buffer
        $image_data = ob_get_contents(); // retrieve buffer contents
        ob_end_clean();

        return $image_data;
    }
}

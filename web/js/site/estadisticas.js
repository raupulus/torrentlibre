/**
 * @author Raúl Caro Pastorino
 * @copyright Copyright © 2018 Raúl Caro Pastorino
 * @license https://www.gnu.org/licenses/gpl-3.0-standalone.html
 */


/************************************************************************
                            Plugin Highcharts
*************************************************************************/
$(document).ready(() => {
    chartCPU = new Highcharts.StockChart({
        chart: {
            renderTo: 'contenedor'
            //defaultSeriesType: 'spline'
        },
        rangeSelector : {
            enabled: false
        },
        title: {
            text: 'Gráfica'
        },
        xAxis: {
            type: 'datetime'
            //tickPixelInterval: 150,
            //maxZoom: 20 * 1000
        },
        yAxis: {
            minPadding: 0.2,
            maxPadding: 0.2,
            title: {
                text: 'Valores',
                margin: 10
            }
        },
        series: [{
            name: 'valor',
            data: datos

    }],
    credits: {
        enabled: false
    }
});
});


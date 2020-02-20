/* Start Chart for Product per month */
var ctxMonth = document.getElementById("monthProduct");


var monthChart = new Chart(ctxMonth, {
    type: 'bar',
    data: {
        labels: month,
        datasets: [{
            label: ' تعداد محصولات به فروش رسیده در ماه',
            data: countMonth,
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            labels: {
                fontSize: 20

            }
        }
    }

});

monthChart.options.scales.xAxes[0].ticks.fontSize = 15;
monthChart.update();
/* End Chart for Product per month */

/* Start Chart for Product per year */
var ctxYear = document.getElementById("yearProduct");


var yearChart = new Chart(ctxYear, {
    type: 'bar',
    data: {
        labels: year,
        datasets: [{
            label: ' تعداد محصولات به فروش رسیده در سال',
            data: countYear,
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            labels: {
                fontSize: 20

            }
        }
    }

});

yearChart.options.scales.xAxes[0].ticks.fontSize = 15;
yearChart.update();
/* End Chart for Product per year */

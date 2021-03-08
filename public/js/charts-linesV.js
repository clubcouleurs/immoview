/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const lineVConfig = {
  type: 'line',
  data: {
    labels: [dvpm1,dvpm2,dvpm3,dvpm4,dvpm5,dvpm6,dvpm7],
    datasets: [
      {
        label: 'Ventes',
        /**
         * These colors come from Tailwind CSS palette
         * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
         */
        backgroundColor: '#0694a2',
        borderColor: '#0694a2',
        data: [vvpm1, vvpm2, vvpm3, vvpm4, vvpm5, vvpm6, vvpm7],
        fill: false,
      },
    ],
  },
  options: {
    responsive: true,
    /**
     * Default legends are ugly and impossible to style.
     * See examples in charts.html to add your own legends
     *  */
    legend: {
      display: false,
    },
    tooltips: {
      mode: 'index',
      intersect: false,
    },
    hover: {
      mode: 'nearest',
      intersect: true,
    },
    scales: {
      x: {
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Month',
        },
      },
      y: {
        display: true,
        scaleLabel: {
          display: true,
          labelString: 'Value',
        },
      },
    },
  },
}

// change this to the id of your chart element in HMTL
const lineVCtx = document.getElementById('lineV')
window.myLineV = new Chart(lineVCtx, lineVConfig)

/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const polarConfig = {
  type: 'polarArea',
  data: {
    labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet'],
    datasets: [
      {
        label: 'Appartements',
        backgroundColor: '#0694a2',
        // borderColor: window.chartColors.red,
        borderWidth: 1,
        data: [3, 14, 52, 74, 33, 90, 70],
      },
      {
        label: 'Lots',
        backgroundColor: '#7e3af2',
        // borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [66, 33, 43, 12, 54, 62, 84],
      },
    ],
  },
  options: {
    responsive: true,
    legend: {
      display: false,
    },
  },
}

const polarsCtx = document.getElementById('polars')
window.myBar = new Chart(polarsCtx, polarConfig)

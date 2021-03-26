/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const pieConfigAppartement = {
  type: 'doughnut',
  data: {
    datasets: [
      {

        data: [appartementsStocked, appartementsBlocked, appartementsReserved],
        /**
         * These colors come from Tailwind CSS palette
         * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
         */
        backgroundColor: ['#0694a2', '#1c64f2', '#7e3af2'],
        label: 'Dataset 1',
      },
    ],
    labels: ['En Stock', 'Bloqué', 'Réservé'],
  },
  options: {
    responsive: true,
    cutoutPercentage: 50,
    /**
     * Default legends are ugly and impossible to style.
     * See examples in charts.html to add your own legends
     *  */
    legend: {
      display: false,
    },
  },
}

// change this to the id of your chart element in HMTL
const pieCtxAppartement = document.getElementById('pieAppartement')
window.myPie = new Chart(pieCtxAppartement, pieConfigAppartement)

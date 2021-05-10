/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const pieConfigSource = {
  type: 'doughnut',
  data: {
    datasets: [
      {

        data: [Site, Facebook, Instagram, Kakemonos, Bouche, Flyers],
        /**
         * These colors come from Tailwind CSS palette
         * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
         */
        backgroundColor: ['#FACC15', '#1E40AF', '#9D174D', '#A5B4FC' , '#C084FC', '#F87171'],
        label: 'Dataset 1',
      },
    ],
    labels: ['Site Web', 'Facebook', 'Instagram', 'Kakémonos', 'Bouche à oreille', 'Flyers & Dépliants'],
  },
  options: {
    responsive: true,
    cutoutPercentage: 0, 
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
const pieCtxSource = document.getElementById('pieSource')
window.myPie = new Chart(pieCtxSource, pieConfigSource)

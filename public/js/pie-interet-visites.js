/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const pieConfigInteret = {
  type: 'doughnut',
  data: {
    datasets: [
      {

        data: [lot, appartement, magasin, bureau, box],
        /**
         * These colors come from Tailwind CSS palette
         * https://tailwindcss.com/docs/customizing-colors/#default-color-palette
         */
        backgroundColor: ['#eb1629', '#004fa4', '#1fd5ed', '#ff85d8' , '#d8d4ea'],
        label: 'Dataset 1',
      },
    ],
    labels: ['Lots', 'Appartements', 'Magasins','Bureaux', 'Boxes'],
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
const pieCtxInteret = document.getElementById('pieInteret')
window.myPie = new Chart(pieCtxInteret, pieConfigInteret)

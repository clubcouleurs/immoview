/**
 * For usage, visit Chart.js docs https://www.chartjs.org/docs/latest/
 */
const barConfig = {
  type: 'bar',
  data: {
    labels: [da1, da2, da3, da4, da5, da6, da7],
    datasets: [
      {
        label: 'Appartements',
        backgroundColor: '#0694a2',
        // borderColor: window.chartColors.red,
        borderWidth: 1,
        data: [app1, app2, app3, app4, app5, app6, app7],
      },
      {
        label: 'Lots',
        backgroundColor: '#DC2626',
        // borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [lot1, lot2, lot3, lot4, lot5, lot6, lot7],
      },
      {
        label: 'Magasins',
        backgroundColor: '#7e3af2',
        // borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [mag1, mag2, mag3, mag4, mag5, mag6, mag7],
      },
      {
        label: 'Bureaux',
        backgroundColor: '#059669',
        // borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [bur1, bur2, bur3, bur4, bur5, bur6, bur7],
      },
      {
        label: 'Boxes',
        backgroundColor: '#D97706',
        // borderColor: window.chartColors.blue,
        borderWidth: 1,
        data: [box1, box2, box3, box4, box5, box6, box7],
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

const barsCtx = document.getElementById('bars')
window.myBar = new Chart(barsCtx, barConfig)

<x-master>
      

<body>
  <div style="width:75%;">
    <canvas id="canvas"></canvas>
  </div>
  <br>
  <br>


  <script>
    window.chartColors = {
      red: 'rgb(255, 99, 132)',
      orange: 'rgb(255, 159, 64)',
      yellow: 'rgb(255, 205, 86)',
      green: 'rgb(75, 192, 192)',
      blue: 'rgb(54, 162, 235)',
      purple: 'rgb(153, 102, 255)',
      grey: 'rgb(231,233,237)'
    };



    var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var config = {
      type: 'bar',
      data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: []
      },
  options: {
    responsive: true,
    legend: {
      display: false,
    },
  },
    };












    
    window.onload = function() {
var com = [] ;

      var ctx = document.getElementById("canvas").getContext("2d");
      window.myLine = getNewChart(ctx, config);

  @foreach ($commerciaux as $commercial) // = execution 8 times/commerciaux

    @foreach ($performanceCommercial as $performance) // = execution 4 times/mois
      nom = '{{$commercial}}' ;
      @php
      $commercial = str_replace(' ', '', $commercial) ;
      @endphp

    com.push({{$performance->$commercial}}) // = execution 8 times/commerciaux

  @endforeach
    push(com, nom) 

    com = [] ;


  var da{{$loop->iteration}}='{{ $mois[ ($performance->mois - 1) ] }}'
  {{$i = $loop->iteration}}

@endforeach

    };
    
        function getNewChart(canvas, config) {
            return new Chart(canvas, config);
        }
    

    var colorNames = Object.keys(window.chartColors);
    
    function push(com, nom) {
      size = {{sizeof($performanceCommercial)}} ;
      sizeA = {{sizeof($performanceCommercial)}} ;

      var colorName = colorNames[config.data.datasets.length % colorNames.length];
      var newColor = window.chartColors[colorName];
      var newDataset = {
        label: nom,
        backgroundColor: newColor,
        borderColor: newColor,
        data: [],
        fill: false
      };

      for (var index = 0; index < size ; ++index) {
        //alert(com) ;
          newDataset.data.push(com[index]);
      }
      config.data.datasets.push(newDataset);
      window.myLine.update();
    }

  </script>

</body>




    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
      defer
    >
    </script>


<script>





</script>



            
</x-master>

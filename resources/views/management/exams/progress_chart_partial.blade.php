<script src="{{ asset('js/Chart.min.js')  }}"></script>
<div class="container">
    <canvas id="all_progress"></canvas>
</div>
<script>
    (function() {
         var ctx = document.getElementById('all_progress').getContext('2d');
         var chart = {
            labels: {{ json_encode($ids) }},
            datasets: [
              @if(isset($passingGrade))
              {
                  data: Array.apply(null, new Array({{ sizeof($ids) }})).map(Number.prototype.valueOf, {{ round($passingGrade) }}),
                  fillColor: "rgba(220,220,220,0)",
                  radius: 0,
                  //backgroundColor: "rgba(0,0,0,0.1)",
                  showTooltips: true,
              },
              @endif
               {
                  data: Array.apply(null, new Array({{ sizeof($ids) }})).map(Number.prototype.valueOf, {{ round($progressAverage) }}),
                  fillColor: "rgba(220,220,220,0)",
                  radius: 0,
                  //backgroundColor: "rgba(0,0,0,0.1)",
                  showTooltips: false,
              },
              {
                data: {{ json_encode($progress) }},
                fillColor : "rgba(255,83,13,0.5)",
                strokeColor : "#E82C0C",
                pointColor : "#FF0000",
                showTooltips: true,
              }
          ]
         };
         var max =320;
         var steps = max/15;
         new Chart(ctx).Line(chart, {
           responsive: true,
           scaleOverride: true,
    scaleSteps: steps,
    scaleStepWidth: Math.ceil(max / steps),
    scaleStartValue: 0,
           options: {
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                },
                margin: {
                    left: 50,
                    top: 20,
                    right: 50,
                    bottom: 20
                }
                }
           },
           scales: {
        yAxes: [{id: 'y-axis-1', type: 'linear', position: 'left', ticks: {min: 0, max:100}}]
      }
         });
    })();
</script>

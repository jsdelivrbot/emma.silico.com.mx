<script src="{{ asset('js/Chart.min.js')  }}"></script>

<canvas id="all_grades"></canvas>
<script>
    (function() {
         var ctx = document.getElementById('all_grades').getContext('2d');
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
                  data: Array.apply(null, new Array({{ sizeof($ids) }})).map(Number.prototype.valueOf, {{ round($pointsAverage) }}),
                  fillColor: "rgba(220,220,220,0)",
                  radius: 0,
                  //backgroundColor: "rgba(0,0,0,0.1)",
                  showTooltips: true,
              },
              {
                data: {{ json_encode($points) }},
                fillColor : "rgba(220,220,220,255)",
                strokeColor : "#A37079",
                pointColor : "#BC808B",
                showTooltips: true,
              }
          ]
         };

         new Chart(ctx).Line(chart, {
           responsive: true,
           options: {
        layout: {
            padding: {
                left: 200,
                right: 0,
                top: 0,
                bottom: 0
            }
        }
    }
         });
    })();
</script>

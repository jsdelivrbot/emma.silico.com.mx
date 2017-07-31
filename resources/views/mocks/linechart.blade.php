<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<div class="container-fluid">
<p>
  <canvas id="line_{{ $chart_id }}"></canvas>
</p>
</div>
<script>
  var lineData = {
    labels : ["January","February","March","April","May","June"],
    datasets : [
    {
      fillColor : "rgba(172,194,132,0.4)",
      strokeColor : "#ACC26D",
      pointColor : "#fff",
      pointStrokeColor : "#9DB86D",
      data : [203,156,99,251,305,247]
    }
    ]
  }
  var line = document.getElementById('line_{{ $chart_id }}').getContext('2d');
  new Chart(line).Line(lineData);
</script>

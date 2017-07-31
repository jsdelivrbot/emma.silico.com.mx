<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<div class="container-fluid">
<p>
  <canvas id="pie_{{-- $chart_id --}}"></canvas>
</p>
</div>

<script>

  var pieData = [
  {
    value: 20,
    color:"#878BB6"
  },
  {
    value : 40,
    color : "#4ACAB4"
  },
  {
    value : 10,
    color : "#FF8153"
  },
  {
    value : 30,
    color : "#FFEA88"
  }
  ];
  var pie= document.getElementById("pie_{{--$chart_id --}}").getContext("2d");
  var pieOptions = {
    segmentShowStroke : false,
    animateScale : true
  }
  new Chart(pie).Pie(pieData, pieOptions);

</script>

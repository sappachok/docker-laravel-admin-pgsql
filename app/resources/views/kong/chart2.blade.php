<body>
    <canvas id="myChart2" height="100px"></canvas>
</body>

<script type="text/javascript">

      var labels2 =  {{ Js::from($labels22) }};
      var users2 =  {{ Js::from($data22) }};

      const data2 = {
        labels: labels2,
        datasets: [{
          label: 'Date Sessions',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: users2,
        }]
      };

      const config2 = {
        type: 'line',
        data: data2,
        options: {}
      };

      const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
      );
</script>
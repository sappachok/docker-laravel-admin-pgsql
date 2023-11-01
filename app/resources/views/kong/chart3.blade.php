<body>
    <canvas id="myChart3" height="100px"></canvas>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">

      var labels3 =  {{ Js::from($labels33) }};
      //var users3 =  {{ Js::from($data44) }};
      var users4 = {{ Js::from($user44) }};
      /*
      const data3 = {
        labels: labels3,
        datasets: [{
          label: 'Month Sessions',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: users3["testman"],
        },
        {
          label: 'Month Sessions',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: users3["uapp"],
        }
        ]
      };*/
      let i=0;
      let dataset = []
      Object.entries(users4).forEach(([key, value]) => {
        //console.log(key, value)
        //dataset[i] = value.data;
        dataset[i] = {
          label: value.data.label,
          backgroundColor: value.data.backgroundColor,
          borderColor: value.data.borderColor,
          data: value.data.data,
        }
        //console.log(value.data);
        i++;
      })

      const data3 = {
        labels: labels3,
        datasets : dataset
      }

      //console.log(labels3);
      //console.log(dataset);
      console.log(data3);

      const config3 = {
        type: 'line',
        data: data3,
        options: {}
      };

      const myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
      );
</script>
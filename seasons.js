
var canvas = document.getElementById('canvas_chart');
      var ctx = canvas.getContext('2d');

      canvas.width = 640;
      canvas.height = 480;

      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['2009', '2010', '2011', '2012', '2013', '2014',
            '2015', '2016', '2017', '2018', '2019', '2020'],
          datasets: [{
            label: 'Games count',
            data: [50, 58, 16, 1, 22, 28, 14, 44, 52, 46, 35, 5],
            backgroundColor: 'rgba(0, 0, 0, 0)',
            borderColor: 'darkgreen',
            borderWidth: 2
          }]
        },

        options: {
          responsive: false,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              ticks: {
                fontColor: "white",
              }
            }],
            yAxes: [{
              ticks: {
                fontColor: "white",
                beginAtZero: true
              }
            }]
          }
        }
      });


var canvas = document.getElementById('canvas_chart');
var ctx = canvas.getContext('2d');

canvas.width = 640;
canvas.height = 420;

var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: seasons_labels,
    datasets: [
      {
        data: seasons_data[0],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'purple',
        borderWidth: 2
      },
      {
        data: seasons_data[1],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'blue',
        borderWidth: 2
      },
      {
        data: seasons_data[2],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'red',
        borderWidth: 2
      },
      {
        data: seasons_data[3],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'orange',
        borderWidth: 2
      },
      {
        data: seasons_data[4],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'white',
        borderWidth: 2
      },
    ]
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

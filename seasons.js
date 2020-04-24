
var canvas = document.getElementById('canvas_chart');
var ctx = canvas.getContext('2d');

canvas.width = 640;
canvas.height = 480;

var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: seasons_labels,
    datasets: [{
      label: 'Games count',
      data: seasons_data,
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

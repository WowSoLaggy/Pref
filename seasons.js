
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

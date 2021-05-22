
var canvas = document.getElementById('canvas_chart');
var ctx = canvas.getContext('2d');

canvas.width = 700;
canvas.height = 500;

var myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: seasons_labels,
    datasets: [
      {
        label: seasons_players[0],
        data: seasons_data[0],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'purple',
        borderWidth: 2
      },
      {
        label: seasons_players[1],
        data: seasons_data[1],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'blue',
        borderWidth: 2
      },
      {
        label: seasons_players[2],
        data: seasons_data[2],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'red',
        borderWidth: 2
      },
      {
        label: seasons_players[3],
        data: seasons_data[3],
        backgroundColor: 'rgba(0, 0, 0, 0.0)',
        borderColor: 'orange',
        borderWidth: 2
      },
      {
        label: seasons_players[4],
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
      position: 'bottom',
      labels: {
        fontSize: 14,
        fontColor: "white",
      }
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: "white",
          fontSize: 14,
        }
      }],
      yAxes: [{
        ticks: {
          fontColor: "white",
          fontSize: 14,
          beginAtZero: true
        }
      }]
    }
  }
});

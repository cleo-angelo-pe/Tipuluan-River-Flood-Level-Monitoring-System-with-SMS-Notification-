const ctx = document.getElementById('myChart').getContext('2d');

const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Distance Data',
            data: [],
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: true,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                top: 20,   // Add padding to the top
                bottom: 20, // Add padding to the bottom
                left: 0,   // Add padding to the left
                right: 3   // Add padding to the right
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    color: 'orange'
                },
                ticks: {
                    color: 'orange'
                }
            },
            y: {
                beginAtZero: true,
                min: 0,
                max: 300,
                stepSize: 50,
                grid: {
                    color: 'rgba(255, 140, 0, 0.3)'
                },
                ticks: {
                    color: 'orange',
                     padding: 0, // Reduce padding to bring numbers closer to the edge
                    callback: function(value) {
                        return value + ' cm';
                    }
                },
                title: {
                    display: true,
                    color: 'orange',
                    font: {
                        size: 25
                    }
                }
            }
        }
    }
});


// Function to fetch data
async function fetchData() {
    try {
        const response = await fetch('../php/fetch_data.php');
        const data = await response.json();

        if (data.length === 0) return;

        const labels = data.map(item => item.data_time);
        const distances = data.map(item => item.distance);

        myChart.data.labels.push(...labels);
        myChart.data.datasets[0].data.push(...distances);

        if (myChart.data.labels.length > 10) {
            myChart.data.labels = myChart.data.labels.slice(-10);
            myChart.data.datasets[0].data = myChart.data.datasets[0].data.slice(-10);
        }

        myChart.update();
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

setInterval(fetchData, 1000);
fetchData();

let myChart = null;
async function fetchCategoryData(timeRange) {
    const response = await fetch(`usage_by_category.php?timeRange=${timeRange}`);
    const data = await response.json();
    return data;
}

function createChart(data) {
    const ctx = document.getElementById('categoryChart').getContext('2d');
    if (myChart) {
        myChart.destroy();
    }
    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(row => row.category),
            datasets: [{
                label: 'Number of Posts',
                data: data.map(row => row.post_count),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Force step size to be 1
                        stepSize: 1,
                        // Ensure that every tick is an integer
                        callback: function (value) {
                            if (value % 1 === 0) {
                                return value;
                            }
                        }
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Number of Posts by Category'

                }
            }
        }
    });
}

function generateChart(timeRange) {
    document.getElementById("chartContainer").style.display = "block";
    fetchCategoryData(timeRange).then(createChart).catch(error => console.error('Error:', error));
}

function hideChart() {
    document.getElementById("chartContainer").style.display = "none";
}
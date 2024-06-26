let myChart = null;
let popularityChart = null;
async function fetchCategoryData(timeRange) {
    const response = await fetch(`usage_by_category.php?timeRange=${timeRange}`);
    const data = await response.json();
    return data;
}
async function createPopularityChart(timeRange) {
    try {
        const response = await fetch(`upvotes_by_category.php?timeRange=${timeRange}`);
        const data = await response.json();
        console.log(data);

        const ctx = document.getElementById('popularityChart').getContext('2d');

        if (popularityChart) {
            popularityChart.destroy();
        }
        popularityChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.category),
                datasets: [{
                    label: 'Total Upvotes',
                    data: data.map(item => item.upvotes),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
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
                        text: 'Number of Upvotes by Category'

                    }
                }
            }
        });
    } catch (error) {
        console.error('Error fetching or parsing data:', error);
    }
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
    createPopularityChart(timeRange);
}

function hideChart() {
    document.getElementById("chartContainer").style.display = "none";
}
const legendColor = 'white';

const fontOptions = {
    size: 18,
    family: 'Arial',
};

const gridOptions = {
    color: 'rgba(206, 183, 255, 0.6)'
};

const popularPostsCtx = document.getElementById('popularPostsChart').getContext('2d');
const popularPostsChart = new Chart(popularPostsCtx, {
    type: 'bar',
    data: {
        labels: popularPostsLabels,
        datasets: [{
            label: 'Views',
            data: popularPostsData,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            },
            x: {
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: legendColor,
                    font: fontOptions
                }
            }
        }
    }
});

const commentsCtx = document.getElementById('commentsChart').getContext('2d');
const commentsChart = new Chart(commentsCtx, {
    type: 'bar',
    data: {
        labels: ['Most Liked Comment', 'Total Comments'],
        datasets: [{
            label: 'Likes',
            data: commentsDataLikes,
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        },
        {
            label: 'Comments',
            data: commentsDataComments,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            },
            x: {
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: legendColor,
                    font: fontOptions
                }
            }
        }
    }
});

const totalPostsCtx = document.getElementById('totalPostsChart').getContext('2d');
const totalPostsChart = new Chart(totalPostsCtx, {
    type: 'bar',
    data: {
        labels: ['Total Posts', 'Total Likes'],
        datasets: [{
            label: 'Posts',
            data: totalPostsDataPosts,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
        {
            label: 'Likes',
            data: totalPostsDataLikes,
            backgroundColor: 'rgba(255, 206, 86, 0.6)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            },
            x: {
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: legendColor,
                    font: fontOptions
                }
            }
        }
    }
});

const postsByTypeCtx = document.getElementById('postsByTypeChart').getContext('2d');
const postsByTypeChart = new Chart(postsByTypeCtx, {
    type: 'bar',
    data: {
        labels: ['Planets', 'Stars'],
        datasets: [{
            label: 'Planets',
            data: postsByTypeDataPlanets,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Stars',
            data: postsByTypeDataStars,
            backgroundColor: 'rgba(153, 102, 255, 0.6)',
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            },
            x: {
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: legendColor,
                    font: fontOptions
                }
            }
        }
    }
});

const userRolesCtx = document.getElementById('userRolesChart').getContext('2d');
const userRolesChart = new Chart(userRolesCtx, {
    type: 'bar',
    data: {
        labels: ['Admins', 'Users'],
        datasets: [{
            label: 'Admins',
            data: userRolesDataAdmins,
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        },
        {
            label: 'Users',
            data: userRolesDataUsers,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            },
            x: {
                ticks: {
                    color: 'white',
                    font: fontOptions
                },
                grid: gridOptions
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: legendColor,
                    font: fontOptions
                }
            }
        }
    }
});

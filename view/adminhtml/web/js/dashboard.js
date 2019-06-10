define(['chartjs'], function (module) {
    return function (config, element) {
        function transparentize(color, opacity) {
            var alpha = opacity === undefined ? 0.5 : 1 - opacity;
            return Color(color).alpha(alpha).rgbString();
        }

        new Chart('stats', {
            type: 'line',
            data: {
                labels: config.labels != null ? config.labels.split(',') : [],
                datasets: [
                    {
                        label: 'Master image accessed',
                        legend: 'bottom',
                        data: config.masterImageAccessed != null ? config.masterImageAccessed.split(',') : [],
                        backgroundColor: transparentize('#8854d0'),
                        borderColor: '#8854d0',
                        pointBackgroundColor: '#8854d0'
                    },
                    {
                        label: 'Mutated image accessed',
                        legend: 'bottom',
                        data: config.mutationAccessed != null ? config.mutationAccessed.split(',') : [],
                        backgroundColor: transparentize('#20bf6b'),
                        borderColor: '#20bf6b',
                        pointBackgroundColor: '#20bf6b'
                    }
                ]
            },
            options: {
                responsive: true,
                tooltips: {
                    mode: 'index',
                    callbacks: {
                        title: function () {
                            return '';
                        }
                    }
                },
                hover: {
                    mode: 'index'
                },
                legend: {
                    display: true,
                    position: 'bottom'
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            }
        });
    };
});

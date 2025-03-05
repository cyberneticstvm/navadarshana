

(function ($) {
	/* "use strict" */

	var dzChartlist = function () {

		var screenWidth = $(window).width();
		let draw = Chart.controllers.line.__super__.draw; //draw shadow


		var chartBarRunning = function () {            
            $.getJSON('/dashboard/student/comparison/', function (response) {
                var options = {
                    series: [
                        {
                            name: 'Offline',
                            data: [response[0]['offline'], response[1]['offline'], response[2]['offline'], response[3]['offline'], response[4]['offline'], response[5]['offline'], response[6]['offline'], response[7]['offline'], response[8]['offline'], response[9]['offline'], response[10]['offline'], response[11]['offline']]
                        },
                        {
                            name: 'Online',
                            data: [response[0]['online'], response[1]['online'], response[2]['online'], response[3]['online'], response[4]['online'], response[5]['online'], response[6]['online'], response[7]['online'], response[8]['online'], response[9]['online'], response[10]['online'], response[11]['online']]
                        },
    
                    ],
                    chart: {
                        type: 'bar',
                        height: 300,
    
    
                        toolbar: {
                            show: false,
                        },
    
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            endingShape: 'rounded',
                            columnWidth: '45%',
                            borderRadius: 3,
    
                        },
                    },
                    colors: ['#0074FF', '#77248B'],
                    dataLabels: {
                        enabled: false,
                    },
    
                    legend: {
                        show: true,
                        fontSize: '13px',
                        labels: {
                            colors: '#888888',
    
                        },
                        markers: {
                            width: 10,
                            height: 10,
                            strokeWidth: 0,
                            strokeColor: '#fff',
                            fillColors: ['var(--primary)', '#1c2430'],
                            radius: 30,
                        }
                    },
                    stroke: {
                        show: true,
                        width: 6,
                        colors: ['transparent']
                    },
                    grid: {
                        show: true,
                        borderColor: '#EEF0F7',
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                    },
                    xaxis: {
                        categories: [response[0]['month'], response[1]['month'], response[2]['month'], response[3]['month'], response[4]['month'], response[5]['month'], response[6]['month'], response[7]['month'], response[8]['month'], response[9]['month'], response[10]['month'], response[11]['month']],
                        labels: {
                            style: {
                                colors: ['#1C2430'],
                                fontSize: '13px',
                                fontFamily: 'poppins',
                                fontWeight: 100,
                                cssClass: 'apexcharts-xaxis-label',
                            },
                        },
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false,
                            borderType: 'solid',
                            color: '#1C2430',
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        },
                        crosshairs: {
                            show: true,
                        }
                    },
                    yaxis: {
                        labels: {
                            offsetX: -16,
                            style: {
                                colors: ['#1C2430'],
                                fontSize: '15px',
                                fontFamily: 'poppins',
                                fontWeight: 100,
                                cssClass: 'apexcharts-xaxis-label',
                            },
                        },
                    },
                    fill: {
                        opacity: 1,
                        colors: ['var(--primary)', '#1C2430'],
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "" + val + ""
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 575,
                        options: {
                            plotOptions: {
                                bar: {
                                    columnWidth: '1%',
                                    borderRadius: -1,
                                },
                            },
                            chart: {
                                height: 250,
                            },
                            series: [
                                {
                                    name: 'Projects',
                                    data: [31, 40, 28, 31, 40, 28, 31, 40]
                                },
                                {
                                    name: 'Projects',
                                    data: [11, 32, 45, 31, 40, 28, 31, 40]
                                },
    
                            ],
                        }
                    }]
                };
                if (jQuery("#chartBarRunning").length > 0) {

                    var chart = new ApexCharts(document.querySelector("#chartBarRunning"), options);
                    chart.render();
    
                    jQuery('#dzIncomeSeries').on('change', function () {
                        jQuery(this).toggleClass('disabled');
                        chart.toggleSeries('Income');
                    });
    
                    jQuery('#dzExpenseSeries').on('change', function () {
                        jQuery(this).toggleClass('disabled');
                        chart.toggleSeries('Expense');
                    });
    
                }
            });	

		}
        var redial = function () {
            $.getJSON('/dashboard/student/fee/percentage', function (response) {
                var options = {
                    series: [response['per']],
                    chart: {
                        type: 'radialBar',
                        offsetY: 0,
                        height: 160,
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -180,
                            endAngle: 180,
                            track: {
                                background: "#F1EAFF",
                                strokeWidth: '100%',
                                margin: 3,
                            },

                            hollow: {
                                margin: 20,
                                size: '60%',
                                background: 'transparent',
                                image: undefined,
                                imageOffsetX: 0,
                                imageOffsetY: 0,
                                position: 'front',
                            },

                            dataLabels: {
                                name: {
                                    show: false
                                },
                                value: {
                                    offsetY: 5,
                                    fontSize: '24px',
                                    color: '#000000',
                                    fontWeight: 600,
                                }
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 1600,
                        options: {
                            chart: {
                                height: 150
                            },
                        }
                    }

                    ],
                    grid: {
                        padding: {
                            top: -10
                        }
                    },
                    /* stroke: {
                    dashArray: 4,
                    colors:'#6EC51E'
                    }, */
                    fill: {
                        type: 'gradient',
                        colors: '#7A849B',
                        gradient: {
                            shade: 'black',
                            shadeIntensity: 0.15,
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [64, 43, 64, 0.5]
                        },
                    },
                    labels: ['Average Results'],
                };
                var chart = new ApexCharts(document.querySelector("#redial"), options);
                chart.render();
            });	
	    }

		/* Function ============ */
		return {
			init: function () {

			},
			load: function () {
				chartBarRunning();
                redial();
			},

			resize: function () {

			}
		}

	}();

	jQuery(window).on('load', function () {
		setTimeout(function () {
			dzChartlist.load();
		}, 1000);
	});
})(jQuery);


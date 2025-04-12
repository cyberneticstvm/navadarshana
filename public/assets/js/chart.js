

(function ($) {
	/* "use strict" */

    let type = 1;

	var dzChartlist = function () {

		var screenWidth = $(window).width();
		let draw = Chart.controllers.line.__super__.draw; //draw shadow


		var chartBarRunning = function () {            
            $.getJSON('/dashboard/student/comparison/'+type, function (response) { alert(type)
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
                    series: [parseFloat(response['per']).toFixed(2)],
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

        var chartBarRunning1 = function () {            
            $.getJSON('/dashboard/student/fee/collection', function (response) {
                var options = {
                    series: [
                        {
                            name: 'Admission',
                            data: [response[0]['admission'], response[1]['admission'], response[2]['admission'], response[3]['admission'], response[4]['admission'], response[5]['admission'], response[6]['admission'], response[7]['admission'], response[8]['admission'], response[9]['admission'], response[10]['admission'], response[11]['admission']]
                        },
                        {
                            name: 'Batch',
                            data: [response[0]['batch'], response[1]['batch'], response[2]['batch'], response[3]['batch'], response[4]['batch'], response[5]['batch'], response[6]['batch'], response[7]['batch'], response[8]['batch'], response[9]['batch'], response[10]['batch'], response[11]['batch']]
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
                if (jQuery("#chartBarRunning1").length > 0) {

                    var chart1 = new ApexCharts(document.querySelector("#chartBarRunning1"), options);
                    chart1.render();
    
                    jQuery('#dzIncomeSeries').on('change', function () {
                        jQuery(this).toggleClass('disabled');
                        chart1.toggleSeries('Income');
                    });
    
                    jQuery('#dzExpenseSeries').on('change', function () {
                        jQuery(this).toggleClass('disabled');
                        chart1.toggleSeries('Expense');
                    });
    
                }
            });	

		}

        var projectChart = function () {
            $.getJSON('/dashboard/finance/ie', function (response) {
			var options = {
				series: [response['income'], response['expense']],
				chart: {
					type: 'donut',
					width: 250,
				},
				plotOptions: {
					pie: {
						donut: {
							size: '90%',
							labels: {
								show: true,
								name: {
									show: true,
									offsetY: 12,
								},
								value: {
									show: true,
									fontSize: '24px',
									fontFamily: 'Arial',
									fontWeight: '500',
									offsetY: -17,
								},
								total: {
									show: true,
									fontSize: '11px',
									fontWeight: '500',
									fontFamily: 'Arial',
									label: 'Total',

									formatter: function (w) {
										return w.globals.seriesTotals.reduce((a, b) => {
											return a + b
										}, 0)
									}
								}
							}
						}
					}
				},
				legend: {
					show: false,
				},
				colors: ['#3AC977', '#FF5E5E'],
				labels: ["Income", "Expense"],
				dataLabels: {
					enabled: false,
				},
			};
			var chartBar1 = new ApexCharts(document.querySelector("#projectChart"), options);
			chartBar1.render();
        });

		}

        var cancellationChart = function () {
            $.getJSON('/dashboard/student/cancel', function (response) {
			var chartWidth = $("#cancellationChart").width();
			/* console.log(chartWidth); */

			var options = {
				series: [
					{
						name: 'Cancelled',
						data: [response[0]['cancelled'], response[1]['cancelled'], response[2]['cancelled'], response[3]['cancelled'], response[4]['cancelled'], response[5]['cancelled'], response[6]['cancelled'], response[7]['cancelled'], response[8]['cancelled'], response[9]['cancelled'], response[10]['cancelled'], response[11]['cancelled']],
						/* radius: 30,	 */
					},
				],
				chart: {
					type: 'area',
					height: 250,
					width: chartWidth + 30,
					toolbar: {
						show: false,
					},
					offsetX: -20,
					zoom: {
						enabled: false
					},
					/* sparkline: {
						enabled: true
					} */

				},

				colors: ['#38BDE7'],
				dataLabels: {
					enabled: false,
				},

				legend: {
					show: false,
				},
				stroke: {
					show: true,
					width: 2,
					curve: 'smooth',
					colors: ['#38BDE7'],
				},
				grid: {
					show: true,
					borderColor: '#eee',
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
				yaxis: {
					show: true,
					tickAmount: 6,
					min: 0,
					max: 25,
					labels: {
						offsetX: 0,
						colors: ['#6F767E'],
					}
				},
				xaxis: {
					categories: [response[0]['month'], response[1]['month'], response[2]['month'], response[3]['month'], response[4]['month'], response[5]['month'], response[6]['month'], response[7]['month'], response[8]['month'], response[9]['month'], response[10]['month'], response[11]['month']],
					overwriteCategories: undefined,
					axisBorder: {
						show: false,
					},
					axisTicks: {
						show: false
					},
					labels: {
						show: true,
						offsetX: 5,
						style: {
							fontSize: '12px',
							colors: ['#6F767E'],

						}
					},
				},
				fill: {
					opacity: 0.5,
					colors: '#38BDE7',
					type: 'gradient',
					gradient: {
						colorStops: [

							{
								offset: 0.6,
								color: '#38BDE7',
								opacity: .2
							},
							{
								offset: 0.6,
								color: '#38BDE7',
								opacity: .15
							},
							{
								offset: 100,
								color: 'white',
								opacity: 0
							}
						],

					}
				},
				tooltip: {
					enabled: true,
					style: {
						fontSize: '12px',
					},
					y: {
						formatter: function (val) {
							return "" + val + ""
						}
					}
				}
			};

			var chartBar1 = new ApexCharts(document.querySelector("#cancellationChart"), options);
			chartBar1.render();

			/*$(".earning-chart .nav-link").on('click', function () {
				var seriesType = $(this).attr('data-series');
				var columnData = [];
				switch (seriesType) {
					case "day":
						columnData = [700, 650, 680, 650, 700, 610, 710, 620];
						break;
					case "week":
						columnData = [700, 700, 680, 600, 700, 620, 710, 620];
						break;
					case "month":
						columnData = [700, 650, 690, 640, 700, 670, 710, 620];
						break;
					case "year":
						columnData = [700, 650, 590, 650, 700, 610, 710, 630];
						break;
					default:
						columnData = [700, 650, 680, 650, 700, 610, 710, 620];
				}
				chartBar1.updateSeries([
					{
						name: "Net Profit",
						data: columnData
					}
				]);
			});*/

        });

		}

		/* Function ============ */
		return {
			init: function () {

			},
			load: function () {
				if(document.querySelector("#chartBarRunning")) chartBarRunning();
				if(document.querySelector("#chartBarRunning1")) chartBarRunning1();
                if(document.querySelector("#redial")) redial();
                if(document.querySelector("#projectChart")) projectChart();
                if(document.querySelector("#cancellationChart")) cancellationChart();
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


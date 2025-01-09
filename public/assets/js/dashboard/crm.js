

(function ($) {
	/* "use strict" */

	var dzChartlist = function () {

		var screenWidth = $(window).width();
		let draw = Chart.controllers.line.__super__.draw; //draw shadow

		var NewCustomers = function () {
			var options = {
				series: [
					{
						name: 'Net Profit',
						data: [100, 300, 200, 250, 200, 240, 180, 230, 200, 250, 300],
						/* radius: 30,	 */
					},
				],
				chart: {
					type: 'area',
					height: 40,
					//width: 400,
					toolbar: {
						show: false,
					},
					zoom: {
						enabled: false
					},
					sparkline: {
						enabled: true
					}

				},

				colors: ['var(--primary)'],
				dataLabels: {
					enabled: false,
				},

				legend: {
					show: false,
				},
				stroke: {
					show: true,
					width: 2,
					curve: 'straight',
					colors: ['var(--primary)'],
				},

				grid: {
					show: false,
					borderColor: '#eee',
					padding: {
						top: 0,
						right: 0,
						bottom: 0,
						left: -1

					}
				},
				states: {
					normal: {
						filter: {
							type: 'none',
							value: 0
						}
					},
					hover: {
						filter: {
							type: 'none',
							value: 0
						}
					},
					active: {
						allowMultipleDataPointsSelection: false,
						filter: {
							type: 'none',
							value: 0
						}
					}
				},
				xaxis: {
					categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'June', 'July', 'August', 'Sept', 'Oct'],
					axisBorder: {
						show: false,
					},
					axisTicks: {
						show: false
					},
					labels: {
						show: false,
						style: {
							fontSize: '12px',

						}
					},
					crosshairs: {
						show: false,
						position: 'front',
						stroke: {
							width: 1,
							dashArray: 3
						}
					},
					tooltip: {
						enabled: true,
						formatter: undefined,
						offsetY: 0,
						style: {
							fontSize: '12px',
						}
					}
				},
				yaxis: {
					show: false,
				},
				fill: {
					opacity: 0.9,
					colors: 'var(--primary)',
					type: 'gradient',
					gradient: {
						colorStops: [

							{
								offset: 0,
								color: 'var(--primary)',
								opacity: .4
							},
							{
								offset: 0.6,
								color: 'var(--primary)',
								opacity: .4
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
					enabled: false,
					style: {
						fontSize: '12px',
					},
					y: {
						formatter: function (val) {
							return "$" + val + " thousands"
						}
					}
				}
			};

			var chartBar1 = new ApexCharts(document.querySelector("#NewCustomers"), options);
			chartBar1.render();

		}
		var AllProject = function () {
			var options = {
				series: [12, 30, 20],
				chart: {
					type: 'donut',
					width: 150,
				},
				plotOptions: {
					pie: {
						donut: {
							size: '80%',
							labels: {
								show: true,
								name: {
									show: true,
									offsetY: 12,
								},
								value: {
									show: true,
									fontSize: '22px',
									fontFamily: 'Arial',
									fontWeight: '500',
									offsetY: -17,
								},
								total: {
									show: true,
									fontSize: '11px',
									fontWeight: '500',
									fontFamily: 'Arial',
									label: 'Compete',

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
				colors: ['#3AC977', 'var(--primary)', 'var(--secondary)'],
				labels: ["Compete", "Pending", "Not Start"],
				dataLabels: {
					enabled: false,
				},
			};
			var chartBar1 = new ApexCharts(document.querySelector("#AllProject"), options);
			chartBar1.render();

		}
		var NewExperience = function () {
			var options = {
				series: [
					{
						name: 'Net Profit',
						data: [100, 300, 200, 250, 200, 240, 180, 230, 200, 250, 300],
						/* radius: 30,	 */
					},
				],
				chart: {
					type: 'area',
					height: 40,
					//width: 400,
					toolbar: {
						show: false,
					},
					zoom: {
						enabled: false
					},
					sparkline: {
						enabled: true
					}

				},

				colors: ['var(--primary)'],
				dataLabels: {
					enabled: false,
				},

				legend: {
					show: false,
				},
				stroke: {
					show: true,
					width: 2,
					curve: 'straight',
					colors: ['#FF5E5E'],
				},

				grid: {
					show: false,
					borderColor: '#eee',
					padding: {
						top: 0,
						right: 0,
						bottom: 0,
						left: -1

					}
				},
				states: {
					normal: {
						filter: {
							type: 'none',
							value: 0
						}
					},
					hover: {
						filter: {
							type: 'none',
							value: 0
						}
					},
					active: {
						allowMultipleDataPointsSelection: false,
						filter: {
							type: 'none',
							value: 0
						}
					}
				},
				xaxis: {
					categories: ['Jan', 'feb', 'Mar', 'Apr', 'May', 'June', 'July', 'August', 'Sept', 'Oct'],
					axisBorder: {
						show: false,
					},
					axisTicks: {
						show: false
					},
					labels: {
						show: false,
						style: {
							fontSize: '12px',
						}
					},
					crosshairs: {
						show: false,
						position: 'front',
						stroke: {
							width: 1,
							dashArray: 3
						}
					},
					tooltip: {
						enabled: true,
						formatter: undefined,
						offsetY: 0,
						style: {
							fontSize: '12px',
						}
					}
				},
				yaxis: {
					show: false,
				},
				fill: {
					opacity: 0.9,
					colors: '#FF5E5E',
					type: 'gradient',
					gradient: {
						colorStops: [

							{
								offset: 0,
								color: '#FF5E5E',
								opacity: .5
							},
							{
								offset: 0.6,
								color: '#FF5E5E',
								opacity: .5
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
					enabled: false,
					style: {
						fontSize: '12px',
					},
					y: {
						formatter: function (val) {
							return "$" + val + " thousands"
						}
					}
				}
			};

			var chartBar1 = new ApexCharts(document.querySelector("#NewExperience"), options);
			chartBar1.render();

		}
		var overiewChart = function () {
			var options = {
				series: [{
					name: 'Number of Projects',
					type: 'column',
					data: [75, 85, 72, 100, 50, 100, 80, 75, 95, 35, 75, 100]
				}, {
					name: 'Revenue',
					type: 'area',
					data: [44, 65, 55, 75, 45, 55, 40, 60, 75, 45, 50, 42]
				}, {
					name: 'Active Projects',
					type: 'line',
					data: [30, 25, 45, 30, 25, 35, 20, 45, 35, 20, 35, 20]
				}],
				chart: {
					height: 300,
					type: 'line',
					stacked: false,
					toolbar: {
						show: false,
					},
				},
				stroke: {
					width: [0, 1, 1],
					curve: 'straight',
					dashArray: [0, 0, 5]
				},
				legend: {
					fontSize: '13px',
					fontFamily: 'poppins',
					labels: {
						colors: '#888888',
					}
				},
				plotOptions: {
					bar: {
						columnWidth: '18%',
						borderRadius: 6,
					}
				},

				fill: {
					//opacity: [0.1, 0.1, 1],
					type: 'gradient',
					gradient: {
						inverseColors: false,
						shade: 'light',
						type: "vertical",
						/* opacityFrom: 0.85,
						opacityTo: 0.55, */
						colorStops: [
							[
								{
									offset: 0,
									color: 'var(--primary)',
									opacity: 1
								},
								{
									offset: 100,
									color: 'var(--primary)',
									opacity: 1
								}
							],
							[
								{
									offset: 0,
									color: '#3AC977',
									opacity: 1
								},
								{
									offset: 0.4,
									color: '#3AC977',
									opacity: .15
								},
								{
									offset: 100,
									color: '#3AC977',
									opacity: 0
								}
							],
							[
								{
									offset: 0,
									color: '#FF5E5E',
									opacity: 1
								},
								{
									offset: 100,
									color: '#FF5E5E',
									opacity: 1
								}
							],
						],
						stops: [0, 100, 100, 100]
					}
				},
				colors: ["var(--primary)", "#3AC977", "#FF5E5E"],
				labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul',
					'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
				],
				markers: {
					size: 0
				},
				xaxis: {
					type: 'month',
					labels: {
						style: {
							fontSize: '13px',
							colors: '#888888',
						},
					},
				},
				yaxis: {
					min: 0,
					tickAmount: 4,
					labels: {
						style: {
							fontSize: '13px',
							colors: '#888888',
						},
					},
				},
				tooltip: {
					shared: true,
					intersect: false,
					y: {
						formatter: function (y) {
							if (typeof y !== "undefined") {
								return y.toFixed(0) + " points";
							}
							return y;

						}
					}
				}
			};

			var chart = new ApexCharts(document.querySelector("#overiewChart"), options);
			chart.render();

			$(".mix-chart-tab .nav-link").on('click', function () {
				var seriesType = $(this).attr('data-series');
				var columnData = [];
				var areaData = [];
				var lineData = [];
				switch (seriesType) {
					case "week":
						columnData = [75, 85, 72, 100, 50, 100, 80, 75, 95, 35, 75, 100];
						areaData = [44, 65, 55, 75, 45, 55, 40, 60, 75, 45, 50, 42];
						lineData = [30, 25, 45, 30, 25, 35, 20, 45, 35, 20, 35, 20];
						break;
					case "month":
						columnData = [20, 50, 80, 52, 10, 80, 50, 30, 95, 10, 60, 85];
						areaData = [40, 25, 85, 45, 85, 25, 95, 65, 45, 45, 20, 12];
						lineData = [65, 45, 25, 65, 45, 25, 75, 35, 65, 75, 15, 65];

						break;
					case "year":
						columnData = [30, 20, 80, 52, 10, 90, 50, 30, 95, 20, 60, 85];
						areaData = [40, 25, 40, 45, 85, 25, 50, 65, 45, 60, 20, 12];
						lineData = [65, 45, 30, 65, 45, 25, 75, 40, 65, 50, 15, 65];
						break;
					case "all":
						columnData = [20, 50, 80, 60, 10, 80, 50, 40, 95, 20, 60, 85];
						areaData = [40, 25, 30, 45, 85, 25, 95, 65, 50, 45, 20, 12];
						lineData = [65, 45, 25, 65, 45, 25, 30, 35, 65, 75, 15, 65];
						break;
					default:
						columnData = [75, 80, 72, 100, 50, 100, 80, 30, 95, 35, 75, 100];
						areaData = [44, 65, 55, 75, 45, 55, 40, 60, 75, 45, 50, 42];
						lineData = [30, 25, 45, 30, 25, 35, 20, 45, 35, 30, 35, 20];
				}
				chart.updateSeries([
					{
						name: "Number of Projects",
						type: 'column',
						data: columnData
					}, {
						name: 'Revenue',
						type: 'area',
						data: areaData
					}, {
						name: 'Active Projects',
						type: 'line',
						data: lineData
					}
				]);
			})

		}
		var projectChart = function () {
			var options = {
				series: [30, 40, 20, 10],
				chart: {
					type: 'donut',
					width: 280,
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
									label: 'Total projects',

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
				colors: ['#FF9F00', 'var(--primary)', '#3AC977', '#FF5E5E'],
				labels: ["Compete", "Pending", "Not Start"],
				dataLabels: {
					enabled: false,
				},
			};
			var chartBar1 = new ApexCharts(document.querySelector("#projectChart"), options);
			chartBar1.render();

		}


		/* Function ============ */
		return {
			init: function () {

			},


			load: function () {
				NewCustomers();
				AllProject();
				NewExperience();
				overiewChart();
				projectChart();


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

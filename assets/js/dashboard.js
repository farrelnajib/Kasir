function number_format(number, decimals, dec_point, thousands_sep) {
	// *     example: number_format(1234.56, 2, ',', ' ');
	// *     return: '1 234,56'
	number = (number + '').replace(',', '').replace(' ', '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
		};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}

$(document).ready(function () {
	$.ajax({
		type: 'GET',
		url: APP_URL + "admin/dashboard/topSellings",
		dataType: 'json',
		success: function (response) {
			let labelArray = [];
			let dataArray = [];

			response.forEach(resp => {
				labelArray.push(resp.menu_name);
				dataArray.push(parseInt(resp.total));
			});

			let ctx = document.getElementById('topSales');
			let myChart = new Chart(ctx, {
				type: 'horizontalBar',
				data: {
					labels: labelArray,
					datasets: [{
						label: '# of sales',
						data: dataArray,
						backgroundColor: 'rgba(54, 162, 235, 0.2)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1
					}]
				},
				options: {
					layout: {
						padding: {
							left: 0,
							right: 0,
							top: 0,
							bottom: 0
						}
					},
					scales: {
						xAxes: [{
							ticks: {
								beginAtZero: true
							}
						}],
						yAxes: [{
							stacked: true
						}]
					}
				},
				legend: {
					display: false,
					hidden: true,
				},
			});
		}
	});

	$.ajax({
		type: 'GET',
		url: APP_URL + "admin/dashboard/salesPerMonth",
		dataType: 'json',
		success: (response) => {
			let labelArray = [];
			let dataArray = [];

			response.forEach(resp => {
				labelArray.push(resp.month);
				dataArray.push(resp.total);
			});

			let ctx = document.getElementById('monthlyEarnings');
			let monthly = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labelArray,
					datasets: [{
						label: 'Earnings',
						data: dataArray,
						backgroundColor: 'rgba(54, 162, 235, 0.2)',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1,
						fill: true,
					}]
				},
				options: {
					layout: {
						padding: {
							left: 0,
							right: 0,
							top: 0,
							bottom: 0
						}
					},
					scales: {
						yAxes: [{
							ticks: {
								beginAtZero: true,
								callback: function (value, index, values) {
									return 'Rp. ' + number_format(value);
								}
							}
						}],
					}
				},
				legend: {
					display: false
				},
			});
		}
	});
});

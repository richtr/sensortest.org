var Chart = function(container, title, credit, url, data) {

	var chartOptions = {
		chart: {
			renderTo: container,
			borderWidth: 1,
			borderColor: '#cccccc',
			type: 'heatmap'
		},
		title: {
			text: title
		},
		credits: {
			enabled: true,
			text: credit,
			href: url,
			style: {
				fontSize: '10px'
			}
		},
		xAxis: {
			min: data.xMin,
			max: data.xMax,
			title: {
				enabled: true,
				text: data.xLabel
			},
			id: 'x'
		},
		yAxis: {
			min: data.yMin,
			max: data.yMax,
			title: {
				enabled: true,
				text: data.yLabel
			},
			id: 'y'
		},
		colorAxis: {
			stops: [
				[0, '#3060cf'],
				[0.5, '#fffbbc'],
				[0.9, '#c4463a']
			],
			minColor: '#3060cf',
			maxColor: '#c4463a',
			min: data.zMin,
			max: data.zMax,
			labels: {
				format: '{value}'
			}
		},
		tooltip: {
			pointFormat: data.xLabel + ': {point.x}, ' + data.yLabel + ': {point.y}<br><b>' + data.zLabel + ': {point.value}</b>'
		},
		series: [data]
	};

	// Render and return new HighCharts object
	return new Highcharts.Chart(chartOptions);

}

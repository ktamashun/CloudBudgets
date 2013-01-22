<h2>Dashboard</h2>

<?php if(Yii::app()->user->hasFlash('dashboard')): ?>
	<div class="row-fluid">
		<div class="span12">
			<div class="alert alert-success">
				<a class="close" data-dismiss="alert">&times;</a>
				<h4>Congratulation!</h4>
				<br />
				<?php echo Yii::app()->user->getFlash('dashboard'); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<br />

<div class="row-fluid">
	<div class="span5" id="chartContainer" style="height: 300px; "></div>
	<div class="span1" >&nbsp;</div>
	<div class="span6" id="chartContainer2" style="height: 300px; "></div>
</div>

<?php

$actYear = date('Y')-1;
$actInterval = $actYear . date('/m');

$this->Widget('application.widgets.ReportPieChart', array(
    'options' => array(
        'chart' => array(
            'renderTo' => 'chartContainer',
        ),
        'title' => array('text' => $actInterval . ' expenses'),
        'series' => array(
            array(
                'name' => 'Dataset',
                'data' => Reporter::instance()->getCategoryReportData(array('interval' => $actInterval)),
            ),
        )
    )
));


$this->Widget('application.widgets.ReportColumnChart', array(
    'options' => array(
        'chart' => array(
            'renderTo' => 'chartContainer2',
        ),
        'title' => array('text' => $actYear . ' expense/income summary'),
        'series' => Reporter::instance()->getExpenseIncomeReportSeriesByMonth(array('interval' => $actYear)),
    )
));

?>


<?php /*
<script type="text/javascript">

(function($){ // encapsulate jQuery

var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'chartContainer',
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false
		},
		title: {
			text: 'Your expenses in April 2012',
			style: {
				fontSize: '14px'
			}
		},
		tooltip: {
			formatter: function() {
				return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
					enabled: false
				},
				showInLegend: true
			}
		},
		series: [{
			type: 'pie',
			name: 'Browser share',
			data: [
				['Home',   45.0],
				['Food',       33.7],
				['Clothing',       12.8],
				['Fitness',    8.5]
			]
		}]
	});
});

})(jQuery);
</script>


<script type="text/javascript">

(function($){ // encapsulate jQuery

var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'chartContainer2',
			type: 'column'
		},
		title: {
			text: 'Your total income and expense in the past 6 months',
			style: {
				fontSize: '14px'
			}
		},
		xAxis: {
			categories: ['November', 'December', 'January', 'February', 'March', 'April']
		},
		tooltip: {
			formatter: function() {
				return ''+
					this.series.name +': '+ this.y +'';
			}
		},
		credits: {
			enabled: false
		},
		series: [{
			name: 'Income',
			data: [3200, 2000, 1870, 2300, 2700, 1900],
			color: '#A2BE67'
		}, {
			name: 'Expense',
			data: [2820, 1880, 1950, 2130, 2600, 1910],
			color: '#C35F5C'
		}]
	});
});

})(jQuery);
</script>
*/
?>

<br />

<?php echo $this->renderPartial('application.views.transaction._table', array('transactions' => $transactions, 'pager' => $pager, 'balance' => $this->user->totalBalance)); ?>

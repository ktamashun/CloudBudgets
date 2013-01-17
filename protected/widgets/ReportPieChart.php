<?php

Yii::import('ext.yiiext.highcharts.PieWidget');

class ReportPieChart extends PieWidget
{
    public function getDefaultOptions()
    {
        $defaultOptions = array(
            'tooltip' => array(
                'formatter' => "js:function() { return '<b>'+ this.point.name +'</b>: '+ this.point.displayValue; }",
            ),
            'plotOptions' => array(
                'pie' => array(
                    'dataLabels' => array(
                        'enabled' => true,
                        'color' => '#000000',
                        'connectorColor' => '#000000',
                        //'formatter' => "js:function() { return '<b>' + this.point.name + '</b>'; }"
                        'formatter' => "js:function() { return this.point.name; }"
                        //'formatter' => "js:function() { return this.point.displayValue; }"
                        //'formatter' => "js:function() { return '<b>' + this.point.name + '</b>:' + this.point.displayValue; }"
                    ),
                    'point' => array(
                        'events' => array(
                            'select' => 'js:function() {
                                var drilldown = this.drilldown;

                                if (drilldown) {
                                    chart' . $this->getId() . '.series[0].remove();
                                    chart' . $this->getId() . '.addSeries({
                                        type: "pie",
                                        data: drilldown
                                    });
                                } else {
                                    window.location.href = "/categories/" + this.id;
                                }
                            }' ,
                        ),
                    ),
                    'showInLegend' => false,
                ),
            ),
        );

        $options = CMap::mergeArray(parent::getDefaultOptions(), $defaultOptions);
        return $options;
    }
}

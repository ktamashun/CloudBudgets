<?php

Yii::import('ext.yiiext.highcharts.ColumnWidget');

class ReportColumnChart extends ColumnWidget
{
    public function getDefaultOptions()
    {
        $defaultOptions = array(
            'chart' => array(
            ),
            'xAxis' => array(
                'categories' => Reporter::instance()->getMonthArray(),
                /*'labels' => array(
                    'rotation' => -45,
                    'align' => 'right',
                ),*/
            ),
            'tooltip' => array(
                'formatter' => "js:function() { console.log(this); return '<b>' + this.x + ' ' + this.series.name + '</b>: ' + this.series.options.displayValue[this.point.x]; }",
            ),
            /*'legend' => array(
                'layout' => 'horizontal',
                'backgroundColor' => '#FFFFFF',
                'align' => 'right',
                'verticalAlign' => 'top',
                'borderWidth' => 1,
                'floating' => true,
                'x' => 0,
                'y' => 35,
            ),*/
        );

        $options = CMap::mergeArray(parent::getDefaultOptions(), $defaultOptions);
        return $options;
    }
}

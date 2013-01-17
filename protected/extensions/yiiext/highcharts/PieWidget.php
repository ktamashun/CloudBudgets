<?php

Yii::import('ext.yiiext.highcharts.HighchartsWidget');

class PieWidget extends HighchartsWidget
{
    public function getDefaultOptions()
    {
        $defaultOptions = array(
            'chart' => array(
            ),
            'tooltip' => array(
                'formatter' => "js:function() { return '<b>'+ this.point.name +'</b>: '+ this.y; }",
            ),
            'plotOptions' => array(
                'pie' => array(
                    'allowPointSelect' => true,
                    'cursor' => 'pointer',
                    'dataLabels' => array(
                        'enabled' => false,
                        'color' => '#000000',
                        'connectorColor' => '#000000',
                        'formatter' => "js:function() { return '<b>' + this.point.name + '</b>:' + this.y; }"
                    ),
                    'showInLegend' => true,
                ),
            ),
        );

        $this->options['series'][0]['type'] = 'pie';

        $options = CMap::mergeArray(parent::getDefaultOptions(), $defaultOptions);
        return $options;
    }
}

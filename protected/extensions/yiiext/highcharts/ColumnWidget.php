<?php

Yii::import('ext.yiiext.highcharts.HighchartsWidget');

class ColumnWidget extends HighchartsWidget
{
    public function getDefaultOptions()
    {
        $defaultOptions = array(
            'chart' => array(
                'type' => 'column',
            ),
            'tooltip' => array(
                'formatter' => "js:function() { return '<b>'+ this.point.name +'</b>: '+ this.y; }",
            ),
            'yAxis' => array(
                'min' => 0,
                'title' => array('text' => 'Amount HUF'),
            ),
            /*'plotOptions' => array(
                'column' => array(
                    'pointPadding' => 0.2,
                    'borderWidth' => 1,
                ),
            ),*/
        );

        $options = CMap::mergeArray(parent::getDefaultOptions(), $defaultOptions);
        return $options;
    }
}

<?php

class Reporter extends CComponent
{
    const THIS_MONTH = 1;

    /**
     * @var User
     */
    public $user = null;


    /**
     * Reporter::getUser()
     *
     * @return User
     */
    public function getUser()
    {
        if (null === $this->user) {
            $this->user = User::getLoggedInUser();
        }

        return $this->user;
    }

    /**
     * Reporter::getDefaultOptions()
     *
     * @return array
     */
    public function getDefaultOptions()
    {
        return array(
            'categoryLevel' => 2,
            'transactionType' => Transaction::TYPE_EXPENSE,
            'interval' => '2012/3',
        );
    }

    /**
     * Reporter::getCategoryReportCriteria()
     *
     * @param mixed $dateFrom
     * @param mixed $dateTo
     * @return array
     */
    public function getCategoryReportData($options = array())
    {
        $user = $this->getUser();
        $iso_code = $user->defaultCurrency->iso_code;
        $options = CMap::mergeArray($this->getDefaultOptions(), $options);
        $intervalSql = $this->getIntervalSql($options['interval']);

        $sql = "
            SELECT
            	c1.id, c1.`name`, ABS(SUM(t.amount)) AS `transactionSum`
            FROM
            	`transaction` t
            JOIN
            	category c1 ON (
                    t.category_id = c1.id
                    AND c1.user_id = {$user->id}
                    AND c1.`level` = {$options['categoryLevel']}
                    AND t.transaction_type_id = {$options['transactionType']}
                    {$intervalSql}
                )
            JOIN
            	category c2 ON (c2.lft >= c1.lft AND c2.rgt <= c1.rgt)
            GROUP BY
            	c1.`name`
            ORDER BY
            	transactionSum DESC;
        ";
        //echo '<pre>' . $sql; die();
        $dataReader = Yii::app()->db->createCommand($sql)->query();
        $data = array();
        $maxValue = null;
        $othersData = null;

        foreach ($dataReader as $row) {
            if (null === $maxValue) {
                $maxValue = (double)$row['transactionSum'];
            }

            if ((double)$row['transactionSum'] > (($maxValue / 100) * 15)) {
                $data[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'y' => (double)$row['transactionSum'],
                    'displayValue' => number_format($row['transactionSum'], 2, '.', ',') . ' ' . $iso_code,
                );
            } else {
                if (null === $othersData) {
                    $othersData = array(
                        'name' => 'Others',
                        'y' => 0,
                        'displayValue' => '',
                        'drilldown' => array(),
                    );
                }

                $othersData['y'] += (double)$row['transactionSum'];
                $othersData['displayValue'] = number_format($othersData['y'], 2, '.', ',') . ' ' . $iso_code;

                $othersData['drilldown'][] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'y' => (double)$row['transactionSum'],
                    'displayValue' => number_format($row['transactionSum'], 2, '.', ',') . ' ' . $iso_code,
                );
            }
        }

        if (null !== $othersData) {
            $data[] = $othersData;
        }

		return $data;
    }

    public function getExpenseIncomeReportSeriesByMonth($options = array())
    {
        $user = $this->getUser();
        $iso_code = $user->defaultCurrency->iso_code;
        $options = CMap::mergeArray($this->getDefaultOptions(), $options);
        $intervalSql = $this->getIntervalSql($options['interval']);

        $sql = "
            SELECT
                MONTH(t.date) AS monthCode, t.transaction_type_id, ABS(SUM(t.amount)) AS `transactionSum`
            FROM
            	`transaction` t
            JOIN
                account a ON (a.id = t.account_id AND a.user_id = {$user->id})
            WHERE
                t.transaction_type_id <> " . Transaction::TYPE_TRANSFER . "
                {$intervalSql}
            GROUP BY
            	MONTH(t.date), t.transaction_type_id
            ORDER BY
            	monthCode ASC, t.transaction_type_id ASC;
        ";
        //echo '<pre>' . $sql; //die();
        $dataReader = Yii::app()->db->createCommand($sql)->query();
        $series = array(
            0 => array('name' => 'Expense', 'color' => $this->getColor('expense'), 'data' => array(), 'displayValue' => array()),
            1 => array('name' => 'Income', 'color' => $this->getColor('income'), 'data' => array(), 'displayValue' => array())
        );

        foreach ($this->getMonthArray() as $key => $value) {
            $series[0]['data'][$key] = 0;
            $series[1]['data'][$key] = 0;
            $series[0]['displayValue'][$key] = number_format(0, 2, '.', ',') . ' ' . $iso_code;
            $series[1]['displayValue'][$key] = number_format(0, 2, '.', ',') . ' ' . $iso_code;
        }

        foreach ($dataReader as $row) {
            $key = (int)$row['transaction_type_id'] - 1;
            $monthKey = (int)$row['monthCode'] - 1;

            $series[$key]['data'][$monthKey] = (int)$row['transactionSum'];
            $series[$key]['displayValue'][$monthKey] = number_format($row['transactionSum'], 2, '.', ',') . ' ' . $iso_code;
        }

        return array($series[1], $series[0]);
    }

    /**
     * Reporter::getIntervalSql()
     *
     * @param mixed $interval
     * @return string
     */
    public function getIntervalSql($interval)
    {
        $sql = '';

        if (is_string($interval)) {
            list($year, $month) = explode('/', $interval . '/');

            if (!empty($year)) {
                $sql = 'AND YEAR(t.date) = ' . $year;

                if (!empty($month)) {
                    $sql .= ' AND MONTH(t.date) = ' . (int)$month;
                }
            }
        } elseif (is_int($interval)) {
            if (self::THIS_MONTH === $interval) {
                $sql = 'AND YEAR(t.date) = ' . date('Y') . ' AND MONTH(t.date) = ' . (int)date('m');
            }
        }

        return $sql;
    }

    public function getMonthArray($shortNames = true)
    {
        if ($shortNames) {
            return array(
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            );
        } else {
            return array(
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            );
        }
    }

    public function getColor($type)
    {
        if ('income' === $type) {
            return '#A2BE67';
        }
        if ('expense' === $type) {
            return '#C35F5C';
        }
    }

    /**
     * Reporter::instance()
     *
     * @return Reporter
     */
    public static function instance()
    {
        return new Reporter();
    }
}

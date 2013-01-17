SELECT
	c1.`name`, ABS(SUM(t.amount)) AS `transactionSum`
	/*c1.`name`, c2.`name`, t.**/
FROM
	`transaction` t
JOIN
	category c1 ON (t.category_id = c1.id AND c1.user_id = 7 AND c1.`level` = 2 AND t.transaction_type_id = 1 AND YEAR(t.date) = 2011 AND MONTH(t.date) = 12)
JOIN
	category c2 ON (c2.lft >= c1.lft AND c2.rgt <= c1.rgt)

GROUP BY
	c1.`name`
ORDER BY
	transactionSum DESC;

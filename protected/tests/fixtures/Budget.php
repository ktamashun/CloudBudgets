<?php

return array(
    'ktamas_Food' => array(
        'id' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'user_id' => 1,
        'from_date' => date('Y-m-d'),
        'to_date' => null,
        'name' => 'Food',
        'category_id' => 4,
        'limit' => 100000,
        'active' => Budget::STATUS_ACTIVE
    ),
    'ktamas_ktamasRoot' => array(
        'id' => 2,
        'created_at' => date('Y-m-d H:i:s'),
        'user_id' => 1,
        'from_date' => '',
        'to_date' => null,
        'name' => 'ktamasRoot',
        'category_id' => 1,
        'limit' => 100000,
        'active' => Budget::STATUS_ACTIVE
    ),
);
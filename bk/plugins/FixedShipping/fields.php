<?php


return [
    [
        'name'      => 'type',
        'label_key' => 'common.type',
        'type'      => 'select',
        'options'   => [
            ['value' => 'fixed', 'label_key' => 'common.fixed'],
            ['value' => 'percent', 'label_key' => 'common.percent'],
        ],
        'required' => true,
        'rules'    => 'required',
    ],
    [
        'name'      => 'value',
        'label_key' => 'common.value',
        'type'      => 'string',
        'required'  => true,
        'rules'     => 'required',
    ],
];

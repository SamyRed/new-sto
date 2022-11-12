<?php
return array(
    'ajax' => 'ajax/makeAjax',
    'route' => 'route/makeRoute',
    'storage' => 'storage/view',
    'storage/([0-9]+)' => 'storage/view/$1',
    'order/list' => 'order/list',
    'order/([0-9]+)/material-list' => 'order/view/MaterialList/$1',
    'order/([0-9]+)/task-list' => 'order/view/TaskList/$1',
    'order/([0-9]+)/info' => 'order/view/Info/$1',
    'company/([0-9]+)/log' => 'company/view/Log/$1',
    'company/([0-9]+)/info' => 'company/view/Info/$1',
    'company/([0-9]+)/worker-list' => 'company/view/WorkerList/$1',
    'company/([0-9]+)/position-list' => 'company/view/PositionList/$1',
    '' => 'order/list'
);
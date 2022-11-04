<?php
return array(
    'ajax' => 'ajax/makeAjax',
    'route' => 'route/makeRoute',
    'order/list' => 'order/list',
    'storage' => 'storage/view',
    'storage/([0-9]+)' => 'storage/view/$1',
    'order/([0-9]+)/material-list' => 'order/view/MaterialList/$1',
    'order/([0-9]+)/task-list' => 'order/view/TaskList/$1',
    'order/([0-9]+)/info' => 'order/view/Info/$1',
    '' => 'order/list'
);
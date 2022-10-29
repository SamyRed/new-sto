<?php
return array(
    'ajax' => 'ajax/makeAjax',
    'order/list' => 'order/list',
    'storage/material-list' => 'storage/materialList',
    'order/([0-9]+)/material-list' => 'order/view/MaterialList/$1',
    'order/([0-9]+)/task-list' => 'order/view/TaskList/$1',
    'order/([0-9]+)/info' => 'order/view/Info/$1',
    '' => 'order/list'
);
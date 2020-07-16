<?php

// 创建内存表
$table = new Swoole\Table(1024);
// 内存中建一列
$table->column('id', Swoole\Table::TYPE_INT, 4);       //1,2,4,8
$table->column('name', Swoole\Table::TYPE_STRING, 64);
$table->column('num', Swoole\Table::TYPE_FLOAT);
$table->create();

$value = ['id' => 1, 'name' => 'xxm', 'num' => 25];
$table['xxm'] = $value;

// 加减删除操作
//$table->incr('xxm', 'num', 2);
//$table->decr('xxm', 'num', 2);
$table->del('xxm');
print_r($table['xxm']);

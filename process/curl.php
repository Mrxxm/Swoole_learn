<?php

use Swoole\Process;

$urls = [
    'http://baidu.com',
    'http://qq.com',
    'http://sina.com.cn',
    'http://baidu.com',
    'http://baidu.com',
    'http://baidu.com',
];

// 原始使用
//foreach ($urls as $url) {
//    $content[] = file_get_contents($url);
//}

for ($i = 0; $i < 6; $i++) {
    // 子进程
    $process = new Process(function (Process $process) {

    }, true);

    $pid = $process->start();
    $workers[$pid] = $process;
}
<?php

use Swoole\Process;

    $process = new Process(function (Process $process) {
        echo 'Child #' . getmypid() . " start " . PHP_EOL;
        // 执行一个外部程序
        $process->exec("/usr/local/Cellar/php/7.3.10/bin/php", [__DIR__ . '/../server/http-server.php']);
    });

    $process->start();
    // 回收结束的子进程
    Process::wait();
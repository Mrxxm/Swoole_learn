<?php

go(function () {
    sleep(1);
    echo "协程1" . PHP_EOL;
});

echo "swoole coroutine" . PHP_EOL;

Swoole\Coroutine::create(function () {
    echo "协程2" . PHP_EOL;
});
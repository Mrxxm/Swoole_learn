<?php

go(function () {
    echo "协程1" . PHP_EOL;
});

Swoole\Coroutine::create(function () {
    echo "协程2" . PHP_EOL;
});
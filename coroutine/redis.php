<?php

//高性能HTTP服务器
$http = new Swoole\Http\Server("127.0.0.1", 9501);

$http->on("request", function ($request, $response) {

    $redis = new Co\Redis;
    $redis->connect('127.0.0.1', 6379); // 若是本地UNIXSocket则host参数应以形如`unix://tmp/xxx.sock`的格式填写

    // 接收-设值
    $redis->set('Coroutine:xxm', $request->get['a']);
    $value = $redis->get('Coroutine:xxm');

    // 返回-传值
    $response->header('Content-Type', 'text/plain');
    $response->end($value);
});

$http->start();
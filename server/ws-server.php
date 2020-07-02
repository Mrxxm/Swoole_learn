<?php

//创建websocket服务器对象，监听0.0.0.0:9502端口
$ws = new Swoole\WebSocket\Server("0.0.0.0", 9502);

// 开启静态文件
$ws->set(
    [
        'enable_static_handler' => true,
        'document_root' => '/var/www/swoole/data',
    ]
);

//监听WebSocket连接打开事件
$ws->on('open', function ($ws, $request) {
    echo $request->fd . "\n";
//    var_dump($request->fd, $request->get, $request->server);
    $ws->push($request->fd, "server: hello, welcome\n");
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {
    echo "Message: {$frame->data}-{$frame->fd}\n";
//    $ws->push($frame->fd, "server: {$frame->data}");
    $ws->push($frame->fd, "server: i am server");
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();
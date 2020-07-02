<?php


class Ws
{
    CONST HOST = "0.0.0.0";
    CONST PORT = 8812;

    public $ws = null;

    public function __construct()
    {
        $this->ws = $ws = new Swoole\WebSocket\Server(self::HOST, self::PORT);

        $this->ws->set(
            [
                'enable_static_handler' => true,
                'document_root' => '/var/www/swoole/data',
                //设置异步任务的工作进程数量
                'task_worker_num' => 4
            ]
        );

        $this->ws->on("open", [$this, "onOpen"]);
        $this->ws->on("message", [$this, "onMessage"]);
        // task任务
        $this->ws->on("task", [$this, "onTask"]);
        $this->ws->on("finish", [$this, "onFinish"]);

        $this->ws->on("close", [$this, "onClose"]);

        $this->ws->start();
    }

    // 监听WebSocket连接打开事件
    public function onOpen($ws, $request)
    {
        echo $request->fd . "\n";
    }

    // 监听WebSocket消息事件
    public function onMessage($ws, $frame)
    {
        echo "Message: {$frame->data}-{$frame->fd}\n";
        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];
        $ws->task($data);
        $ws->push($frame->fd, "server: i am server" . date("Y-m-d H:i:s"));
    }

    // 处理异步任务-将异步任务参数记录，并执行(此回调函数在task进程中执行)
    public function onTask($ws, $task_id, $from_id, $data)
    {
        echo "New AsyncTask[id=$task_id]".PHP_EOL;
        sleep(5);
        //返回任务执行的结果
        print_r($data);
        $ws->finish("task -> OK");
    }

    // 处理异步任务的结果-返回结果(此回调函数在worker进程中执行)
    public function onFinish($ws, $task_id, $data)
    {
        echo "AsyncTask[$task_id] Finish: $data".PHP_EOL;
    }

    // 监听WebSocket连接关闭事件
    public function onClose($ws, $fd)
    {
        echo "client-{$fd} is closed\n";
    }

}

(new Ws());
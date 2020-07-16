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
$workers = [];

for ($i = 0; $i < 6; $i++) {
    // 子进程
    $process = new Process(function (Process $process) use($i, $urls) {
        // 请求url
        $content = curlData($urls[$i]);
        // 输出到管道
        echo $content . PHP_EOL;
    }, true);

    $pid = $process->start();
    $workers[$pid] = $process;
}

/*
 * 输出管道内容
 */
foreach ($workers as $pid => $process) {
    // 输出管道内容
    echo $process->read();
}

/**
 * 模拟请求URL的内容
 * @param $url
 * @return string
 */
function curlData($url)
{
    // curl file_get_contents
    sleep(2);

    return $url . "success" . PHP_EOL;
}
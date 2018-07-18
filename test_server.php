<?php
/**
 * User: jiaozi<jiaozi@iyenei.com>
 * Date: 2018/7/16
 * Time: 22:42
 */

use Workerman\Worker;

require_once __DIR__ . "/vendor/autoload.php";

$woker = new Worker("tcp://127.0.0.1:1000");
$woker->protocol = \pjs\protocols\JsonStreamProtocol::class;
$woker->onMessage = function(Workerman\Connection\ConnectionInterface $conn, $data){
    var_dump($data);
};

Worker::runAll();


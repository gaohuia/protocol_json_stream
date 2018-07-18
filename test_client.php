<?php
/**
 * User: jiaozi<jiaozi@iyenei.com>
 * Date: 2018/7/16
 * Time: 22:46
 */

require_once __DIR__ . "/vendor/autoload.php";


$client = new \pjs\ClientConnection("127.0.0.1:1000");
$client->connect();
$client->send(['hello' => 'hello']);

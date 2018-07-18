<?php

use pjs\protocols\JsonStreamProtocol;

/**
 * User: jiaozi<jiaozi@iyenei.com>
 * Date: 2018/7/18
 * Time: 7:21
 */

class JsonStreamProtocolTest extends \PHPUnit\Framework\TestCase
{
    public function testProtocol()
    {
        $buffer = "\x01\x00\x00\x00\x01\x00\x00\x00\x00";
        $this->assertEquals(5, JsonStreamProtocol::input($buffer));

        $buffer = "\x00";
        $this->assertEquals(0, JsonStreamProtocol::input($buffer));
    }

    public function testEncodeAndDecode()
    {
        $data = ['data' => 1];
        $buffer = JsonStreamProtocol::encode($data);
        $this->assertGreaterThan(0, JsonStreamProtocol::input($buffer));
        $message = JsonStreamProtocol::decode($buffer);
        $this->assertEquals($data, $message);
    }
}
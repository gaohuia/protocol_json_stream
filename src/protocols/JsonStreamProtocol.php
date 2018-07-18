<?php

namespace pjs\protocols;

use Workerman\Protocols\ProtocolInterface;

/**
 * User: jiaozi<jiaozi@iyenei.com>
 * Date: 2018/7/16
 * Time: 22:25
 */

class JsonStreamProtocol
{
    const LENGTH_BYTES = 4;
    const LENGTH_FORMAT = "L";

    /**
     * Check the integrity of the package.
     * Please return the length of package.
     * If length is unknow please return 0 that mean wating more data.
     * If the package has something wrong please return false the connection will be closed.
     *
     * @param string $buffer
     * @return int|false
     */
    public static function input($buffer)
    {
        $length = strlen($buffer);
        if ($length < self::LENGTH_BYTES) {
            return 0;
        }

        $unpacked = unpack(self::LENGTH_FORMAT, $buffer);
        $targetPackageLength = $unpacked[1] + self::LENGTH_BYTES;

        if ($length < $targetPackageLength) {
            return 0;
        }

        return $targetPackageLength;
    }

    /**
     * Decode package and emit onMessage($message) callback, $message is the result that decode returned.
     *
     * @param string $buffer
     * @return mixed
     */
    public static function decode($buffer)
    {
        return json_decode(substr($buffer, 4), true);
    }

    /**
     * Encode package brefore sending to client.
     *
     * @param mixed $data
     * @return string
     */
    public static function encode($data)
    {
        $data = json_encode($data);
        return pack(self::LENGTH_FORMAT, strlen($data)) . $data;
    }
}
<?php
/**
 * User: jiaozi<jiaozi@iyenei.com>
 * Date: 2018/7/16
 * Time: 22:54
 */

namespace pjs;


use pjs\protocols\JsonStreamProtocol;
use Workerman\Protocols\ProtocolInterface;

class ClientConnection
{
    protected $stream;
    protected $target;
    protected $buffer;

    /** @var ProtocolInterface */
    protected $protocol = JsonStreamProtocol::class;

    public function __construct($target)
    {
        $this->target = $target;
        $this->buffer = "";
    }

    public function connect()
    {
        $this->stream = stream_socket_client($this->target);
    }

    public function send($data)
    {
        $bytes = $this->protocol::encode($data, null);
        fwrite($this->stream, $bytes);
    }

    public function recv()
    {
        while(!feof($this->stream)) {
            $data = fread($this->stream, 1024);
            if ($data === false) {
                break;
            }

            $this->buffer .= $data;
            $packageSize = $this->protocol::input($this->buffer, null);

            if ($packageSize > 0) {
                $package = substr($this->buffer, 0, $packageSize);
                $this->buffer = substr($this->buffer, $packageSize);
                return $this->protocol::decode($package, null);
            } else if ($packageSize === false) {
                fclose($this->stream);
            }
        }

        return false;
    }
}
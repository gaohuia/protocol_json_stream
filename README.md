# protocol_json_stream
A protocol for json message transfer over stream. 

It's designed for working with workerman. The following piece of code shows you how to make a message server;

```php
<?php
use Workerman\Worker;

require_once __DIR__ . "/vendor/autoload.php";

$woker = new Worker("tcp://127.0.0.1:1000");
// all you need to do is setting the protocol
$woker->protocol = \pjs\protocols\JsonStreamProtocol::class;
$woker->onMessage = function(Workerman\Connection\ConnectionInterface $conn, $data){
    var_dump($data);
};

Worker::runAll();
```

Now we can test against the server with a simple client; Here is the code.

```php
<?php
require_once __DIR__ . "/vendor/autoload.php";

// This package contains a simple client for message transfer. 
$client = new \pjs\ClientConnection("127.0.0.1:1000");
$client->connect();
$client->send(['hello' => 'hello']);

```

Have fun!



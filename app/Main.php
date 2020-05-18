<?php

namespace App;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class Main
{
    private $logfile;
    private $ip;
    private $port;

    private $connection;
    private $channel;

    public function __construct($ip, $port)
    {
        set_time_limit(0); // disable timeout
        ob_implicit_flush(); // disable output caching

        $this->ip = $ip;
        $this->port = $port;
        $this->logfile = _RESULT_ . "/log.$port.csv";

        $this->connection = new AMQPStreamConnection(_RABBIT_HOST_, _RABBIT_PORT_, _RABBIT_USER_, _RABBIT_PASS_);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(_RABBIT_QUEUE_, false, false, false, false);
    }

    public function main(){
        $tcp_server = new TcpServer($this->ip, $this->port);
        $tcp_server->start();

        $logger = new Logger($this->logfile);
        while($tcp_server->status == 'running'){
            $data = $tcp_server->read();

            $message = new AMQPMessage(
                $data,
                [
                    'content_type' => 'text/plain',
                    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
                ]
            );
            $this->channel->basic_publish($message,_RABBIT_EXCHANGE_);

// Move to consumer-side
//            $parser = new Parser($data);
//            $time = microtime(true);
//            $parser->process();
//            $time = microtime(true) - $time;
//            $logger->log($parser->rendered_results());


            echo "Incoming data from \"$this->port\" Messaged Successfully.\n";
        }
        $this->channel->close();
        $this->connection->close();
    }
}
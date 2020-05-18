<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class Consumer
{
    private $logfile;
    private $logger;

    private $connection;
    private $channel;

    public function __construct()
    {
        set_time_limit(0); // disable timeout
        ob_implicit_flush(); // disable output caching

        $timestamp = date('Ymd-His', time());
        $this->logfile = _RESULT_ . "/log.$timestamp.csv";

        $this->connection = new AMQPStreamConnection(_RABBIT_HOST_, _RABBIT_PORT_, _RABBIT_USER_, _RABBIT_PASS_);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(_RABBIT_QUEUE_, false, false, false, false);
        $this->channel->exchange_declare(_RABBIT_EXCHANGE_, AMQPExchangeType::DIRECT, false, true, false);
        $this->channel->queue_bind(_RABBIT_QUEUE_, _RABBIT_EXCHANGE_);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function main()
    {
        $this->logger = new Logger($this->logfile);

        $this->channel->basic_consume(_RABBIT_QUEUE_, _RABBIT_CONSUMER_TAG_, false, false, false, false, '$this->process_message');

        while ($this->channel ->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function process_message($message){
        $parser = new Parser($message->body);
        $time = microtime(true);
        $parser->process();
        $time = microtime(true) - $time;
        $this->logger->log($parser->rendered_results());

        echo "Incoming data from \"$this->port\" Parsed & Logged Successfully.\n";
    }
}
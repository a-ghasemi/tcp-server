<?php

namespace App;

class Main
{
    private $logfile;
    private $ip;
    private $port;

    public function __construct($ip, $port)
    {
        set_time_limit(0); // disable timeout
        ob_implicit_flush(); // disable output caching

        $this->ip = $ip;
        $this->port = $port;
        $this->logfile = _RESULT_ . "/log.$port.csv";
    }

    public function main(){
        $tcp_server = new TcpServer($this->ip, $this->port);
        $tcp_server->start();

        $logger = new Logger($this->logfile);
        while($tcp_server->status == 'running'){
            $data = $tcp_server->read();
            $parser = new Parser($data);
            $time = microtime(true);
            $parser->process();
            $time = microtime(true) - $time;
            $logger->log($parser->rendered_results());
            echo "Incoming data from \"$this->port\" Extracted and Logged Successfully, in $time seconds.\n";
        }
    }
}
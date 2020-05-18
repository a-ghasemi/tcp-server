<?php

namespace App;

class TcpServer
{
    private $error_engine;

    private $ip;
    private $port;
    private $socket;
    private $spawn;

    public $status;

    public function __construct($ip, $port)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->status = 'stopped';

        $this->error_engine = new ErrorThrower();
    }

    public function start(){
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $this->error_engine->error(!$this->socket, "Could not create socket ".socket_strerror(socket_last_error()));

        $result = socket_bind($this->socket, $this->ip, $this->port);
        $this->error_engine->error(!$result, "Could not bind to socket ".socket_strerror(socket_last_error()));

        $this->status = 'running';
    }

    public function read(){
        if($this->status != 'running') return $this->error_engine->error('Server is not running!');

        $result = socket_listen($this->socket, 3);
        $this->error_engine->error(!$result, "Could not set up socket listener".socket_strerror(socket_last_error()));

        $this->spawn = socket_accept($this->socket);
        $this->error_engine->error(!$this->spawn,"Could not accept incoming connection".socket_strerror(socket_last_error()));

        $input = socket_read($this->spawn, 2048);
        $this->error_engine->error(!$input, "Could not read input".socket_strerror(socket_last_error()));

        return $input;
    }

    public function write($data){
        if($this->status != 'running') return $this->error_engine->error('Server is not running!');

        $result = socket_write($this->spawn, $data, strlen($data));
        if(!$result) return $this->error_engine->error("Could not write output".socket_strerror(socket_last_error()));
        return $result;
    }
}
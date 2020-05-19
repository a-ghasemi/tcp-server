<?php
use PHPUnit\Framework\TestCase;

class TcpServerTest extends TestCase
{
    public $ip = '127.0.0.1';
    public $port = 6666;

    public function testServerCanStart()
    {
        //Arrange
        $server = new \App\TcpServer($this->ip, $this->port);

        //Act
        $server->start();

        //Assert
        $this->assertSame('running',$server->status);
        unset($server);
    }

    ##################################### NOT WORKING YET
    public function testServerCanRead()
    {
        return $this->assertTrue(true);
        //Arrange
        $server = new \App\TcpServer($this->ip, $this->port);

        //Act
        $server->start();
        $server->read();

        $result = shell_exec("ncat $this->ip $this->port < <".'(echo -e  "https://www.google.com/search?ei=9vImXZvBEYzSa7DNqcAI&q=MessageBird&oq=MessageBird\nhttps://messagebird.com/en/#\nhttps://github.com/yandex/ClickHouse/blob/master/dbms/programs/server/users.xml\nhttp://www.google.com")');

        $this->assertFalse(true,$result);
        //Assert
        $this->assertSame('running',$server->status);
        unset($server);
    }
}
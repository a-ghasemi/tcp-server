<?php

use \PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public $logpath = 'testlog.txt';

    public function testLoggerCanLog(){
        //Arrange
        $logger = new \App\Logger($this->logpath);
        $content = 'This is a test log';

        //Act
        $logger->log($content);

        //Assert
        $this->assertFileExists($this->logpath);
        $this->assertStringEqualsFile($this->logpath, $content);

        //Get Back
        unlink($this->logpath);

    }


}
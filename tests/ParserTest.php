<?php

use \PHPUnit\Framework\TestCase;
use App\Parser;

class ParserTest extends TestCase
{
//    use InvokeMethods;
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testTrimIncomingData(){
        //Arrange
        $data = ' This is a test ';

        //Act
        $parser = new \App\Parser($data);

        //Assert
        $this->assertSame($parser->getDataAttribute(), trim($data));
    }

    public function testParseResult(){
        //Arrange
        $data = "This\nis\na\ntest";

        //Act
        $parser = new Parser($data);
        $this->invokeMethod($parser, 'parse',[]);

        //Assert
        $this->assertSame($parser->getDataAttribute(), explode("\n",$data));

    }

    public function testGetStatus200(){
        //Arrange
        $data = "http://www.google.com";

        //Act
        $parser = new Parser('');
        $code = $this->invokeMethod($parser, 'get_status',[$data]);

        //Assert
        $this->assertEquals($code, 200);

    }

    public function testGetStatus404(){
        //Arrange
        $data = "http://www.google.com/foo";

        //Act
        $parser = new Parser('');
        $code = $this->invokeMethod($parser, 'get_status',[$data]);

        //Assert
        $this->assertEquals($code, 404);

    }
}
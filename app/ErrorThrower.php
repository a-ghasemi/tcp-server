<?php

namespace App;


class ErrorThrower
{
    public function error($flag, $message){
        if($flag) throw new \Exception($message);
    }
}
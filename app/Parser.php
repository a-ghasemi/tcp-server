<?php

namespace App;


class Parser
{
    private $data;
    private $results;

    public function __construct($data){
        $this->data = trim($data);
    }

    public function getDataAttribute(){
        return $this->data;
    }

    public function process(){
        $this->parse();
        foreach($this->data as $url){
            $this->results[$url] = $this->get_status($url);
        }
    }

    private function parse(){
        $this->data = explode("\n", $this->data);
    }

    private function get_status($url){
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($handle);
        $http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        return $http_code;
    }

    public function rendered_results(){
        $ret = '';
        foreach($this->results as $url=>$http_code){
            $ret .= sprintf("%s,%s\n",$url,$http_code);
        }
        return $ret;
    }
}
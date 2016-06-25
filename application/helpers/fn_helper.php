<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function generateToken() {

  $token = md5(uniqid(microtime(), true));


  return $token;

}
function __ValueToDatabase($data, $prefix) {
  $arrayDara = [];
  foreach($data as $key => $val){
    if(strpos($key, $prefix) !== false) {
      $arrayDara[str_replace($prefix, '', $key)] = empty($val)?'NULL':$val;
    }

  }
  return $arrayDara;
}

function discount($quantity){
  if($quantity > 11){
    $number = 0.8;
  }else if($quantity >= 6){
    $number = 0.9;
  }else{
    $number = 1;
  }
  return $number;
}
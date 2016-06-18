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
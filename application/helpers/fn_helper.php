<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function generateToken() {

  $token = md5(uniqid(microtime(), true));


  return $token;

}

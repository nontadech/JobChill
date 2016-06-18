<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Member extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $data = [];
    $this->twig->display('/modules/Company/views/member', $data);
  }
}

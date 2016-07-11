<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_Home extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->twig->display('/modules/Main/views/home', []);
  }
}

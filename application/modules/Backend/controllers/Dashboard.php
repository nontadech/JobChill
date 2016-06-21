<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->twig->display('/modules/Backend/views/Dashboard',array('_page' => 'backend'));
  }
}

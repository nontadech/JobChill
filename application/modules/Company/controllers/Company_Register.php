<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Register extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $datasession = array(
      'nick' => 'Mike',
      'login_ok' => true
    );
    $this->session->set_userdata($datasession);
    $this->twig->addGlobal('session', $this->session);

    $this->twig->display('/modules/Company/views/register', []);
  }

}

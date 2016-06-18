<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Logout extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->company->logout();
    redirect(base_url("company/login"));
  }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Login extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if($this->company->is_login()){
      redirect(base_url("company/member"));
    }
  }

  public function index()
  {
    //print_r($this->session->all_userdata());
    //$this->session->sess_destroy();
    $token = $this->input->post('token');
    if(!empty($token))
      $this->validateForm();
    else{
      $this->buildForm();
    }
  }

  public function buildForm($data = array())
  {
    $data['token'] = $this->security->get_csrf_hash();
    $this->session->set_userdata('token', $data['token']);
    $this->twig->display('/modules/Company/views/login', $data);

  }
  public function validateForm()
  {
    $this->form_validation->set_rules('val_username', 'Username', 'required|min_length[5]|max_length[12]');
    $this->form_validation->set_rules('val_password', 'Password', 'trim|required|min_length[8]');
    if ($this->form_validation->run() == FALSE)
    {
      $data['val_username'] = set_value('val_username');
      $data['error_username'] = form_error('val_username','<p style="color:#a94442">','</p>');
      $data['error_password'] = form_error('val_password','<p style="color:#a94442">','</p>');
      logs_message(
        'frontend/form',
        'controllers.Company.Login',
        '[action][data:{'.json_encode($data).'}]',
        'login/form_validation',
        '.validateForm',
        'Login');
      $this->buildForm($data);
    }
    else
    {
      $this->submitForm();
    }
  }

  public function submitForm()
  {
    $data['ip'] = $this->input->ip_address();
    if($this->input->post('token') === $this->session->userdata('token')){
      $dataLogin = __ValueToDatabase($this->input->post(NULL, FALSE), 'val_');
      if($this->company->login($dataLogin)){
        redirect(base_url("company/member"));
      }else{
        $this->buildForm();
      }
      $this->session->unset_userdata('token');
    }else{
      logs_message(
        'frontend/form',
        'controllers.Company.Login',
        '[action][data:{'.$this->input->post('token').'}]',
        'login/valid_token',
        '.submitForm',
        'Login');
      $data['status_message'] = 'no valid token';
      $this->buildForm($data);
    }
  }
}

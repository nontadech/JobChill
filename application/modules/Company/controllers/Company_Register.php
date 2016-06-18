<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Register extends CI_Controller
{
  var $formName;
  public function __construct()
  {
    parent::__construct();
    $this->formName = 'register';

  }

  public function index(){
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
    $this->twig->display('/modules/Company/views/register', $data);

  }
  public function validateForm()
  {
    $this->form_validation->set_rules(
      'val_username', 'Username',
      'required|min_length[5]|max_length[12]',
      array(
        'required'      => 'You have not provided %s.',
        'is_unique'     => 'This %s already exists.'
      )
    );
    $this->form_validation->set_rules('val_password', 'Password', 'trim|required|min_length[8]');
    $this->form_validation->set_rules('val_confirm_password', 'Password Confirmation', 'trim|required|matches[val_password]');
    $this->form_validation->set_rules('val_email', 'Email', 'trim|required|valid_email');
    $this->form_validation->set_rules('val_confirm_email', 'Email', 'trim|required|valid_email|matches[val_email]');
    
    if ($this->form_validation->run() == FALSE)
    {
      $data['val_username'] = set_value('val_username');
      $data['val_email'] = set_value('val_email');
      $data['val_confirm_email'] = set_value('val_confirm_email');
      $data['error_username'] = form_error('val_username','<p style="color:#a94442">','</p>');
      $data['error_password'] = form_error('val_password','<p style="color:#a94442">','</p>');
      $data['error_confirm_password'] = form_error('val_confirm_password','<p style="color:#a94442">','</p>');
      $data['error_email'] = form_error('val_email','<p style="color:#a94442">','</p>');
      $data['error_confirm_email'] = form_error('val_confirm_email','<p style="color:#a94442">','</p>');
      logs_message(
        'frontend/form',
        'controllers.Company.Register',
        '[action][data:{'.json_encode($data).'}]',
        'register/form_validation',
        '.validateForm',
        'Register');
      $this->buildForm($data);
    }
    else
    {
      $this->submitForm();
    }
  }
  public function submitForm()
  {
    echo $_SERVER['SERVER_ADDR'];
    $data['ip'] = $this->input->ip_address();
    if($this->input->post('token') === $this->security->get_csrf_hash()){

    }else{
      logs_message(
        'frontend/form',
        'controllers.Company.Register',
        '[action][data:{'.$this->input->post('token').'}]',
        'register/valid_token',
        '.submitForm',
        'Register');
      $data['status_message'] = 'no valid token';
      $this->buildForm($data);
    }
  }
}

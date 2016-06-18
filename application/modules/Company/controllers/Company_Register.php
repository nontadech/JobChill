<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_Register extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if($this->company->is_login()){
      redirect(base_url("company/member"));
    }
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
    $this->session->set_userdata('token', $data['token']);
    $this->twig->display('/modules/Company/views/register', $data);

  }
  public function validateForm()
  {

    $this->form_validation->set_rules('val_username', 'Username', 'required|min_length[5]|max_length[12]|callback_username_check');
    $this->form_validation->set_rules('val_password', 'Password', 'trim|required|min_length[8]');
    $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[val_password]');
    $this->form_validation->set_rules('val_email', 'Email',
      'trim|required|valid_email|callback_email_check'
    );
    $this->form_validation->set_rules('confirm_email', 'Email', 'trim|required|valid_email|matches[val_email]');
    
    if ($this->form_validation->run() == FALSE)
    {
      $data['val_username'] = set_value('val_username');
      $data['val_email'] = set_value('val_email');
      $data['confirm_email'] = set_value('confirm_email');
      $data['error_username'] = form_error('val_username','<p style="color:#a94442">','</p>');
      $data['error_password'] = form_error('val_password','<p style="color:#a94442">','</p>');
      $data['error_confirm_password'] = form_error('confirm_password','<p style="color:#a94442">','</p>');
      $data['error_email'] = form_error('val_email','<p style="color:#a94442">','</p>');
      $data['error_confirm_email'] = form_error('confirm_email','<p style="color:#a94442">','</p>');
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
  public function username_check($username)
  {
    $this->form_validation->set_message('username_check', 'Field %s duplicate');
    return !$this->company->valid_username($username);
  }
  public function email_check($email)
  {
    $this->form_validation->set_message('email_check', 'Field %s duplicate');
    return !$this->company->valid_email($email);
  }
  public function submitForm()
  {
    $data['ip'] = $this->input->ip_address();
    if($this->input->post('token') === $this->session->userdata('token')){
      $dataInsert = __ValueToDatabase($this->input->post(NULL, FALSE), 'val_');
      $dataInsert['password'] = $this->company->_password_hash($dataInsert['password']);
      $this->company->create($dataInsert);
      $this->session->unset_userdata('token');
      $this->buildForm();
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

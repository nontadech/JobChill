<?php
class Company {

  protected $CI;

  public function __construct() {
    $this->CI =& get_instance();
    $this->CI->load->model('company_model');
  }

  public function create($dataInsert = array()){
    $this->CI->company_model->insert($dataInsert);
  }

  public function valid_username($username = NULL){
    if(!$username) return FALSE;
    return $this->CI->company_model->__valid(array('username' => $username));
  }

  public function valid_email($email = NULL){
    if(!$email) return FALSE;
    return $this->CI->company_model->__valid(array('email' => $email));
  }

  public function username_password($username = NULL) {
    if(!$username) return FALSE;
      return $this->CI->company_model->__username_password($username);
  }

  public function login($users = NULL){
    $hash = $this->username_password($users['username']);
    if($this->_password_verify($users['password'], $hash)){
      $this->load_company($this->valid_username($users['username']));
      return TRUE;
    }else
      return FALSE;
  }

  public function _password_hash($password = NULL){
    if(!$password) return FALSE;
    return password_hash($password, PASSWORD_DEFAULT);
  }

  public function _password_verify($password = NULL, $hash = NULL){
    if(!$password || !$hash) return FALSE;
    return password_verify($password, $hash);
  }

  public function load_company($id = NULL){
    if(!$id) return FALSE;
    $company['member'] = $this->CI->company_model->__load_company($id);
    $this->CI->session->set_userdata($company);
  }

  public function is_login(){
    $member = $this->CI->session->userdata('member');
    if(isset($member['id']) && !empty($member['id']))return TRUE;
    else return FALSE;
  }
  public function logout(){
    $this->CI->session->unset_userdata('member');
  }
}
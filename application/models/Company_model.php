<?php
class Company_model extends CI_Model {

  var $tableName;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();

    $this->tableName = 'company';

    if (!$this->db->table_exists($this->tableName))
    {
      exit;
    }

  }

  public function insert($dataInsert = array()){
    if(!$dataInsert) return FALSE;
    $this->db->insert($this->tableName, $dataInsert);
  }

  public function update($dataUpdate = FALSE,$dataWhere = FALSE){
    if(!$dataUpdate || !$dataWhere) return FALSE;
    $this->db->update($this->tableName, $dataUpdate, $dataWhere);
  }

  public function __username_password($username = FALSE){
    if(!$username) return FALSE;
    $this->db->cache_off();
    $this->db->select('password');
    $this->db->where('username',$username);
    $query = $this->db->get($this->tableName);
    $row = $query->row();
    return empty($row->password)?FALSE:$row->password;
  }
  public function __valid($data = FALSE){
    if(!$data) return FALSE;
    $this->db->cache_off();
    $this->db->select('id');
    $this->db->where($data);
    $query = $this->db->get($this->tableName);
    $row = $query->row();
    return empty($row->id)?FALSE:$row->id;
  }

  public function __load_company($id = FALSE){
    if(!$id) return FALSE;
    $this->db->cache_on();
    $this->db->select('id, username, email');
    $this->db->where('id', $id);
    $query = $this->db->get($this->tableName);
    $row = $query->row_array();
    return empty($row['id'])?FALSE:$row;
  }

}
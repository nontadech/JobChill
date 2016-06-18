<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Logger {

  protected $CI;
  protected $config;
  protected $_log_path;
  protected $_threshold = 1;
  protected $_date_fmt = 'Y-m-d H:i:s';
  protected $_enabled = TRUE;
  protected $_levels = array('ERROR' => '1', 'DEBUG' => '2', 'INFO' => '3', 'ALL' => '4');

  public function __construct() {
    $this->CI =& get_instance();
    $this->config =& get_config();

    if ($this->config['logs_status'] == FALSE && is_really_writable($this->_log_path)) {
      $this->_enabled = FALSE;
    }


    if (is_numeric($this->config['log_threshold'])) {
      $this->_threshold = $this->config['log_threshold'];
    }

    if ($this->config['log_date_format'] != '') {
      $this->_date_fmt = $this->config['log_date_format'];
    }
  }

  public function write_log($action = 'error', $msg, $path = false, $package = false, $php_error = FALSE) {


    $this->_log_path = ($this->config['log_path'] != '') ? $this->config['log_path'] : APPPATH . 'logs/';
    if ($this->_enabled === FALSE) {
      return FALSE;
    }
    if ($path != false) {
      $this->_log_path .= $path;
      if (!is_dir($this->_log_path)) {
        mkdir($this->_log_path, DIR_WRITE_MODE, TRUE);
      }
    }
    $action = strtoupper($action);

    $file_path = $this->_log_path . $package . '-' . date('Y-m-d') . '.log';
    $message = '';

    if (!file_exists($file_path)) {
      $message .= "start datetime : " . date('Y-m-d H:i:s') . "\n\n\n";
    }
    if (!$fp = @fopen($file_path, FOPEN_WRITE_CREATE)) {
      return FALSE;
    }

    $message .= '[' . date($this->_date_fmt) . '][' . $this->CI->input->ip_address() . ']  --> ' . '[' . $action . ']' . $msg . "\n";
    flock($fp, LOCK_EX);
    fwrite($fp, $message);
    flock($fp, LOCK_UN);
    fclose($fp);
    chmod($file_path, FILE_WRITE_MODE);
    //log_message('INFO', "[{$action}] {$msg}" );

    return TRUE;
  }

}

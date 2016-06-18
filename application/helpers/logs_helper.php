<?php
function logs_message($logRootPath, $logRootPackage, $msg, $path = false, $package = '', $level = 'info', $php_error = FALSE) {
  $CI = get_instance();
  $CI->load->library('logger');
  $path1 = $logRootPath . $path;
  $package1 = $logRootPackage . $package;
  $CI->logger->write_log($level, $msg, $path1, $package1, $php_error);
}
?>
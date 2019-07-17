<?php
// ****************************************************************************
// mailerproxy.php
// ****************************************************************************

header("Access-Control-Allow-Origin: *");  

define("EMAIL_SERVER_URL", "http://kkt.us11.list-manage.com/subscribe/post?u=e3f89ab8d64e8ad8c27e9c4e5&amp;id=cc8a151ee2");

$strEmail = "";
if (isset($_REQUEST['form-email'])) {
  $strEmail = $_REQUEST['form-email'];
}

function post($url, $data){
  $file = @file_get_contents($url, NULL, stream_context_create(array('http' => array('method' => 'POST', 'content' => http_build_query($data)))));
  return $file ? $file : "Error POSTing to $url";
}

echo post(EMAIL_SERVER_URL, array('EMAIL' => $strEmail));
?>
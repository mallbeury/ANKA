<?php
// ****************************************************************************
// mailerproxy.php
// ****************************************************************************

header("Access-Control-Allow-Origin: *");  

define("EMAIL_SERVER_URL", "https://ankaaa.us5.list-manage.com/subscribe/post?u=4cba3de9d0c3186e1e4c74cd9&amp;id=9ec1f9b522");

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
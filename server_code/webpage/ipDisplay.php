<?php

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$clientIP = getRealIpAddr();
$allowedSubnet1= "138.47.143.";
$allowedSubnet2= "138.47.148.";


if (substr($clientIP,0,11) == $allowedSubnet1 || substr($clientIP,0,11) == $allowedSubnet2) //"138.47.150.168")
{
  echo "Valid Team";
}
else
{
  echo "You are not authorized to view this webpage";
}
?>
<?php

$mypage = 'style_settings';

$error = '';

if ($error != '')
  $REX['ADDON']['installmsg'][$mypage] = $error;
else
  $REX['ADDON']['install'][$mypage] = true;
  
?>
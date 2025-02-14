<?php

session_start();
if(isset($_SESSION['nls_db_userid']))
{
  $_SESSION['nls_db_userid'] = NULL;
  unset($_SESSION['nls_db_userid']);
}
header("Location: login.php");
die;
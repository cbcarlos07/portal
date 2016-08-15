<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$user = $_GET['user'];
$par = $_GET['par'];
//echo $user;
header("Location:lista.php?user=$user&par=$par");

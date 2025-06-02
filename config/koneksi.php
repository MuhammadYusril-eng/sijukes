<?php

$host = 'localhost';
$nama = 'root';
$pass = 'root';
$db = 'sistem_jadwal';

$conn = new mysqli($host, $nama,$pass, $db);
if(!$conn){
  echo "tara takonek";
}


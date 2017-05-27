<?php
// Assuming you installed from Composer:
require "vendor/autoload.php";
use Slims\Persneling\Lelang\Controller\Grabber as LECGR;
/**
# if you want to get url of lpse from the inaproc list but sadly it is not updated
$daftar_lpse = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/getDaftarLpse.php';
$idlpse_json = file_get_contents($daftar_lpse);
$idlpse_array = json_decode($idlpse_json);
#LPSE Kemdikbud
$idlpse = '25';
$url = $idlpse_array->$idlpse->url;
$versi = 'eproc4';
**/
$url = 'http://lpse.kemdikbud.go.id';
$versi = 'eproc4';

$data = new LECGR;
echo '<pre>';
var_dump($data->getDaftarLelang($url, $versi));
echo '</pre>';

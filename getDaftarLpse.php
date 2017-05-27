<?php
// Assuming you installed from Composer:
require "vendor/autoload.php";

use Slims\Persneling\Lelang\Controller\Grabber as LECGR;

$data = new LECGR;
# url dari https://inaproc.lkpp.go.id/v3/daftar_lpse
$urlinfo = $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/daftar_lpse.html';

header("Content-type:application/json");
echo json_encode($data->getDaftarLpse($urlinfo), JSON_PRETTY_PRINT);

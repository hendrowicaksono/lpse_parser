<?php
namespace Slims\Persneling\Lelang\Controller;
use Slims\Persneling\Lelang\Model\Grabber as LEMGR;

class Grabber
{
  public function __construct()
  {
  }

  public function getDataLelang($kode_lelang, $url, $versi)
  {
    $grabber = new LEMGR;
    $arr_data = $grabber->getDataLelang($kode_lelang, $url, $versi);
    return $arr_data;
  }

  public function getDaftarLelang($url)
  {
    $grabber = new LEMGR;
    $arr_data = $grabber->getDaftarLelang($url);
    return $arr_data;
  }

  public function getDaftarLpse($url)
  {
    $grabber = new LEMGR;
    $arr_data = $grabber->getDaftarLpse($url);
    return $arr_data;
  }

}

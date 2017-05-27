<?php
namespace Slims\Persneling\Lelang\Model;
use PHPHtmlParser\Dom;

class Grabber
{

  public function __construct()
  {
  }

  public function getDataLelang($kode_lelang, $url, $versi='eproc4')
  {
    $res = array ();
    if ( ($versi === 'eproc4') OR ($versi === 'eproc') ) {
      $versi = $versi;
    } else {
      $versi = 'eproc4';
    }
    $url = $url.'/'.$versi.'/lelang/'.$kode_lelang.'/pengumumanlelang';
    $dom = new Dom;
    $dom->loadFromUrl($url);

    $keys = $dom->find('.content table tr th');
    $values = $dom->find('.content table tr td strong');

    foreach ($values as $_k => $_v) {
      if ($keys[$_k]->text === 'Kode Lelang') {
        $res['kode_lelang'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Nama Lelang') {
        $res['nama_lelang'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Kode RUP') {
         $res['kode_rup'] = $values[$_k]->text;
      }
     $res['lingkup_pekerjaan'] = $values[3]->text;
    }

    $values = $dom->find('.content table tr td');
    foreach ($values as $_k => $_v) {
      if ($keys[$_k]->text === 'Tanggal Pembuatan') {
        $res['tanggal_pembuatan'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Keterangan') {
        $res['keterangan'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Instansi') {
        $res['instansi'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Satuan Kerja') {
        $res['satuan_kerja'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Kategori') {
        $res['kategori'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Metode Pengadaan') {
        $res['metode_pengadaan'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Metode Kualifikasi') {
        $res['metode_kualifikasi'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Metode Dokumen') {
        $res['metode_dokumen'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Metode Evaluasi') {
        $res['metode_evaluasi'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Tahun Anggaran') {
        $res['tahun_anggaran'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Nilai Pagu Paket') {
        $res['nilai_pagu_paket'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Nilai HPS Paket') {
        $res['nilai_hps_paket'] = $values[$_k]->text;
      }
      if ($keys[$_k]->text === 'Jenis Kontrak') {
        if ($keys[$_k+1]->text === 'Cara Pembayaran') {
          $res['jenis_kontrak']['cara_pembayaran'] = $values[$_k]->text;
        }
      }
      if ($keys[$_k]->text === 'Pembebanan Tahun Anggaran') {
        $res['jenis_kontrak']['pembebanan_tahun_anggaran'] = $values[$_k-1]->text;
      }
      if ($keys[$_k]->text === 'Sumber Pendanaan') {
        $res['jenis_kontrak']['sumber_pendanaan'] = $values[$_k-1]->text;
      }
      if ($keys[$_k]->text === 'Kualifikasi Usaha') {
        $res['kualifikasi_usaha'] = $values[$_k-1]->text;
      }
      if ($keys[$_k]->text === 'Tahap Lelang Saat ini') {
        $urljadwal = 'http://lpse.kemdikbud.go.id'.$values[$_k]->find('a')->getAttribute('href');
        $domjadwal = new Dom;
        $domjadwal->loadFromUrl($urljadwal);
        $jadwalvalues = $domjadwal->find('table tr td strong');
        $an = count($jadwalvalues);
        $res['tahap_lelang_saat_ini'] = $values[$_k]->find('a')->getAttribute('href');
      }
      if ($keys[$_k]->text === 'Lokasi Pekerjaan') {
        $res['lokasi_pekerjaan'] = $values[$_k-1]->find('ul li')->text;
      }
    }
    return $res;
  }

  public function getDaftarLelang($url, $versi='eproc4')
  {
    $res = array();
    if ( ($versi === 'eproc4') OR ($versi === 'eproc') ) {
      $versi = $versi;
    } else {
      $versi = 'eproc4';
    }
    $url = $url.'/'.$versi.'/dt/lelang';
    $json_data = file_get_contents($url);
    $array_data = json_decode($json_data);
    $res['recordsTotal']= $array_data->recordsTotal;
    $res['recordsFiltered']= $array_data->recordsFiltered;
    foreach ($array_data->data as $k => $v) {
      $res['data'][$k]['kode_lelang'] = $array_data->data[$k][0];
      $res['data'][$k]['nama_lelang'] = $array_data->data[$k][1];
      $res['data'][$k]['instansi'] = $array_data->data[$k][2];
      $res['data'][$k]['tahap_lelang_saat_ini'] = $array_data->data[$k][3];
      $res['data'][$k]['hps'] = $array_data->data[$k][4];
      $res['data'][$k]['metode_kualifikasi_dan_dokumen'] = $array_data->data[$k][5];
      $res['data'][$k]['metode_pengadaan'] = $array_data->data[$k][6];
      $res['data'][$k]['metode_evaluasi'] = $array_data->data[$k][7];
      $res['data'][$k]['kategori_dan_tahun_anggaran'] = $array_data->data[$k][8];
      if ($array_data->data[$k][9] === '1') {
        $res['data'][$k]['versi'] = 'spse 3';
      } elseif ($array_data->data[$k][9] === '2') {
        $res['data'][$k]['versi'] = 'spse 4';
      } else {
        $res['data'][$k]['versi'] = 'spse 4';
      }
    }
    return $res;
  }

  public function getDaftarLpse($url)
  {
    $dom = new Dom;
    $res = array ();
    $dom->loadFromUrl($url);
    $ids = $dom->find('table tbody tr td');
    foreach ($ids as $_k => $_v) {
      if ($_k % 2 == 0) {
        $lpse_id = $ids[$_k]->text;
        $res[$lpse_id]['name'] = $ids[$_k+1]->find('a')->text;
        $res[$lpse_id]['url'] = $ids[$_k+1]->find('a')->getAttribute('href');
      }
    }
    return $res;
  }

}

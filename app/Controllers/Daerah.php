<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DaerahModel;

class Daerah extends BaseController
{
    public $db;
    public $daerahModel;

    public function __construct(){
        $this->db = db_connect();
        $this->daerahModel = new DaerahModel();
    }

    public function getProvinsi(){
        $kota = $this->daerahModel->groupby('provinsi')->find();
        return json_encode($kota);
    }

    public function getKota(){
        $kota = $this->daerahModel->groupby('kota_kabupaten')->find();
        return json_encode($kota);
    }

    public function getDaerah(){
        $tipe_daerah = $this->request->getPost('tipe_daerah');
        $group_daerah = $this->request->getPost('group_daerah');
        $nama_daerah = $this->request->getPost('nama_daerah');

        $kota = $this->daerahModel->where($tipe_daerah, $nama_daerah)->groupby($group_daerah)->find();
        return json_encode($kota);
    }

    public function search()
    {
        // $model = new AgentModel();
        $query = $this->request->getVar('q'); // Mengambil parameter pencarian dari query string
        $page = $this->request->getVar('page', FILTER_VALIDATE_INT) ?? 1; // Halaman pagination, default ke 1
        $pageSize = 10; // Ukuran halaman
        $offset = ($page - 1) * $pageSize; // Offset untuk query

        // Query pencarian
        $daerah = $this->daerahModel->like('kelurahan', $query)
                        // ->or_like('kecamatan', $query)
                        ->orderBy('name', 'ASC')
                        ->findAll($pageSize, $offset);

        // Hitung total hasil pencarian
        $total = $this->daerahModel->like('kelurahan', $query)
        // ->or_like('kecamatan', $query)
        ->countAllResults();

        // Format data untuk Select2
        $results = [
            "items" => $daerah,
            "totalCount" => $total,
            "pageSize" => $pageSize
        ];

        return $this->respond($results);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer';
    protected $primaryKey       = 'pk_id_customer';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_customer',
        'nama_customer',
        'no_wa',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota_kabupaten',
        'provinsi',
        'email',
        'fk_id_agent',
        'fk_id_leader_agent',
        'fk_id_produk',
        'jenis_produk',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_customer' => 'required',
        // 'no_wa' => 'required|numeric|is_unique[customer.no_wa]',
        'no_wa' => 'required|numeric',
        'email' => 'required|valid_email'
    ];

    protected $validationMessages   = [
        'nama_customer' => [
            'required' => 'Nama customer harus diisi.'
        ],
        'no_wa' => [
            'required' => 'No WA harus diisi.',
            'numeric' => 'No WA harus berupa angka.'
        ],
        'email' => [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Email tidak valid.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [
        "generateID",
        "getIdLeaderAgent"
    ];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function generateID($data){
        $db = db_connect();

        $lastId = $db->query("
            SELECT
                SUBSTRING(kode_customer, 7, 6) as last_id
            FROM customer
            ORDER BY SUBSTRING(kode_customer, 7, 6) desc
            LIMIT 1
        ")->getRowArray();

        $yearMonth = date('ym');
        if($lastId){
            $sequence = (int) $lastId['last_id'] + 1;
        } else {
            $sequence = 1;
        }
        $data['data']['kode_customer'] = sprintf('C-%s%05d', $yearMonth, $sequence);

        return $data;
    }

    public function getIdLeaderAgent($data){
        $db = db_connect();

        $pk_id_agent = $data['data']['fk_id_agent'];

        $agent = $db->query("
            SELECT
                *
            FROM agent
            WHERE pk_id_agent = $pk_id_agent
        ")->getRowArray();

        if($agent['tipe_agent'] == 'leader agent'){
            $data['data']['fk_id_agent'] = NULL;
            $data['data']['fk_id_leader_agent'] = $agent['pk_id_agent'];
        } else {
            $data['data']['fk_id_agent'] = $agent['pk_id_agent'];
            $data['data']['fk_id_leader_agent'] = $agent['fk_id_leader_agent'];
        }

        return $data;
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'produk';
    protected $primaryKey       = 'pk_id_produk';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'fk_id_travel',
        'nama_produk',
        'deskripsi',
        'jenis_produk',
        'link_lp',
        'page',
        'jenis_komisi',
        'harga_produk',
        'komisi_agent',
        'komisi_leader_agent',
        'passive_income_leader_agent',
        'json_lp',
        'is_active',
        'mailketing_list_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_produk' => 'required',
        'jenis_komisi' => 'required',
        'jenis_produk' => 'required',
        'page' => 'required',
        'harga_produk' => 'required|numeric',
        'komisi_agent' => 'required|numeric',
        'komisi_leader_agent' => 'required|numeric',
        'passive_income_leader_agent' => 'required|numeric'
    ];
    protected $validationMessages   = [
        'nama_produk' => [
            'required' => 'Nama produk harus diisi.'
        ],
        'jenis_komisi' => [
            'required' => 'Jenis komisi harus diisi.'
        ],
        'page' => [
            'required' => 'page harus diisi.'
        ],
        'jenis_produk' => [
            'required' => 'Jenis produk harus diisi.'
        ],
        'harga_produk' => [
            'required' => 'Harga produk harus diisi.',
            'numeric' => 'Harga produk harus berupa angka.'
        ],
        'komisi_agent' => [
            'required' => 'Komisi agent harus diisi.',
            'numeric' => 'Komisi agent harus berupa angka.'
        ],
        'komisi_leader_agent' => [
            'required' => 'Komisi leader agent harus diisi.',
            'numeric' => 'Komisi leader agent harus berupa angka.'
        ],
        'passive_income_leader_agent' => [
            'required' => 'Passive income leader agent harus diisi.',
            'numeric' => 'Passive income leader agent harus berupa angka.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}

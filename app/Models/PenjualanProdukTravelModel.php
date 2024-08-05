<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\ProdukTravelModel;
use App\Models\CustomerModel;
use App\Models\KomisiPenjualanProdukTravelModel;

class PenjualanProdukTravelModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'penjualan_produk_travel';
    protected $primaryKey       = 'pk_id_penjualan_produk_travel';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'fk_id_customer',
        'fk_id_produk_travel',
        'fk_id_agent_closing',
        'fk_id_agent',
        'fk_id_leader_agent',
        'harga_produk',
        'komisi_agent',
        'komisi_leader_agent',
        'passive_income_leader_agent',
        'tgl_closing',
        'fk_id_travel',
        'status',
        'paid_komisi_agent',
        'paid_komisi_leader_agent',
        'paid_passive_income_leader_agent'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'fk_id_agent_closing' => 'required',
        'fk_id_customer' => 'required',
        'fk_id_produk_travel' => 'required',
        'tgl_closing' => 'required'
    ];
    protected $validationMessages   = [
        'fk_id_agent_closing' => [
            'required' => 'Nama Agent harus diisi.'
        ],
        'fk_id_customer' => [
            'required' => 'Nama customer harus diisi.'
        ],
        'fk_id_produk_travel' => [
            'required' => 'Produk harus diisi.'
        ],
        'tgl_closing' => [
            'required' => 'Tgl closing harus diisi.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [
        'lengkapiData'
    ];
    protected $afterInsert    = [
        'insertDataKomisi'
    ];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function lengkapiData($data){
        $produkTravelModel = new ProdukTravelModel();
        $customerModel = new CustomerModel();
        $agentModel = new AgentModel();

        $produk = $produkTravelModel->find($data['data']['fk_id_produk_travel']);
        $customer = $customerModel->find($data['data']['fk_id_customer']);
        $agent = $agentModel->find($data['data']['fk_id_agent_closing']);

        $data['data']['nama_produk'] = $produk['nama_produk'];
        $data['data']['harga_produk'] = $produk['harga_produk'];
        
        if($agent['tipe_agent'] != 'leader agent' && $agent['fk_id_leader_agent'] != 'NULL'){
            $data['data']['fk_id_agent'] = $customer['fk_id_agent'];
            $data['data']['fk_id_leader_agent'] = $customer['fk_id_leader_agent'];
            $data['data']['komisi_agent'] = ($produk['jenis_komisi'] == 'fix') ? $produk['komisi_agent'] : $produk['harga_produk'] * $produk['komisi_agent'] / 100;
            $data['data']['komisi_leader_agent'] = 0;
            $data['data']['passive_income_leader_agent'] = ($produk['jenis_komisi'] == 'fix') ? $produk['passive_income_leader_agent'] : $produk['harga_produk'] * $produk['passive_income_leader_agent'] / 100;
        } else if($agent['tipe_agent'] != 'leader agent' && $agent['fk_id_leader_agent'] == 'NULL'){
            $data['data']['fk_id_agent'] = $customer['fk_id_agent'];
            $data['data']['fk_id_leader_agent'] = NULL;
            $data['data']['komisi_agent'] = ($produk['jenis_komisi'] == 'fix') ? $produk['komisi_agent'] : $produk['harga_produk'] * $produk['komisi_agent'] / 100;
            $data['data']['komisi_leader_agent'] = 0;
            $data['data']['passive_income_leader_agent'] = 0;
        } else if($agent['tipe_agent'] == 'leader agent'){
            $data['data']['fk_id_agent'] = NULL;
            $data['data']['fk_id_leader_agent'] = $customer['fk_id_leader_agent'];
            $data['data']['komisi_agent'] = 0;
            $data['data']['komisi_leader_agent'] = ($produk['jenis_komisi'] == 'fix') ? $produk['komisi_leader_agent'] : $produk['harga_produk'] * $produk['komisi_leader_agent'] / 100;
            $data['data']['passive_income_leader_agent'] = 0;
        }

        return $data;
    }

    public function insertDataKomisi($data){
        $komisiPenjualanProdukTravel = new KomisiPenjualanProdukTravelModel();
        $agentModel = new AgentModel();
        $produkTravelModel = new ProdukTravelModel();

        $produk = $produkTravelModel->find($data['data']['fk_id_produk_travel']);

        $pk_id_penjualan_produk_travel = ($data['id']) ? $data['id'] : $this->insertID;

        $agent = $agentModel->find($data['data']['fk_id_agent_closing']);

        $komisiPenjualanProdukTravel->where('fk_id_penjualan_produk_travel', $pk_id_penjualan_produk_travel)->delete();

        if($produk['jenis_komisi'] != 'tidak ada'){
            if($agent['tipe_agent'] == 'leader agent'){
                $dataKomisi = [
                    'fk_id_penjualan_produk_travel' => $pk_id_penjualan_produk_travel,
                    'fk_id_agent' => $data['data']['fk_id_agent_closing'],
                    'keterangan' => 'komisi leader agent'
                ];

                if($produk['jenis_komisi'] == 'fix'){
                    $data['nominal'] =  $data['data']['komisi_leader_agent'];
                } else if($produk['jenis_komisi'] == 'prosentase'){
                    $data['nominal'] =  $data['data']['komisi_leader_agent'] * $produk['harga_produk'] / 100;
                }

                $komisiPenjualanProdukTravel->save($dataKomisi);
            } else {
                $dataKomisi = [
                    'fk_id_penjualan_produk_travel' => $pk_id_penjualan_produk_travel,
                    'fk_id_agent' => $data['data']['fk_id_agent_closing'],
                    'keterangan' => 'komisi agent',
                ];

                if($produk['jenis_komisi'] == 'fix'){
                    $data['nominal'] =  $data['data']['komisi_agent'];
                } else if($produk['jenis_komisi'] == 'prosentase'){
                    $data['nominal'] =  $data['data']['komisi_agent'] * $produk['harga_produk'] / 100;
                }

                $komisiPenjualanProdukTravel->save($dataKomisi);

                $dataAgent = $agentModel->find($data['data']['fk_id_agent_closing']);

                if($agent['fk_id_leader_agent'] != NULL || $agent['fk_id_leader_agent'] != 0){
                    $dataKomisi = [
                        'fk_id_penjualan_produk_travel' => $pk_id_penjualan_produk_travel,
                        'fk_id_agent' => $data['data']['fk_id_leader_agent'],
                        'keterangan' => "Passive income leader agent"
                    ];

                    if($produk['jenis_komisi'] == 'fix'){
                        $data['nominal'] =  $data['data']['passive_income_leader_agent'];
                    } else if($produk['jenis_komisi'] == 'prosentase'){
                        $data['nominal'] =  $data['data']['passive_income_leader_agent'] * $produk['harga_produk'] / 100;
                    }

                    $komisiPenjualanProdukTravel->save($dataKomisi);
                }
            }
        }
    }
}

<?php

namespace App\Controllers;
use App\Models\CustomerModel;
use App\Models\AgentModel;
use App\Models\ProdukModel;
use App\Models\PenjualanProdukModel;
use App\Models\PenjualanProdukTravelModel;

class Registrasi extends BaseController
{
    public $customerModel;
    public $agentModel;
    public $produkModel;
    public $penjualanProdukModel;
    public $penjualanProdukTravelModel;
    public $db;

    public function __construct(){
        $this->customerModel = new CustomerModel();
        $this->agentModel = new AgentModel();
        $this->produkModel = new ProdukModel();
        $this->penjualanProdukModel = new PenjualanProdukModel();
        $this->penjualanProdukTravelModel = new PenjualanProdukTravelModel();
        $this->db = db_connect();
    }

    public function registrasi($username, $page){
        // Mendapatkan URL lengkap
        $currentUrl = current_url();
        
        // Mendapatkan hanya path dari URL
        $currentPath = $this->request->getPath();
        $produk = explode('/', $currentPath);
        $page = $produk[2];
        $username = $produk[1];

        $db = db_connect();

        $data['agent'] = $db->query("
            SELECT
                *
            FROM agent 
            WHERE username = '$username'
            AND (deleted_at = '0000-00-00 00:00:00' OR deleted_at IS NULL)
        ")->getRowArray();

        $pk_id_agent = $data['agent']['pk_id_agent'];

        $produk = $db->query("
            SELECT
                *
            FROM produk
            WHERE page = '$page'
        ")->getRowArray();

        if(!$produk){
            $produk = $db->query("
                SELECT
                    *
                FROM produk_travel
                WHERE page = '$page'
            ")->getRowArray();
        }

        if($data['agent']){
            $data['produk'] = $produk;
            $data['title'] = "Setor Data Peminat $produk[nama_produk]";

            $data['message'] = $data['produk']['message_after_input_agent'];

            $replace = [
                '$nama_agent$' => $data['agent']['nama_agent'],
                '$gender$' => ($data['agent']['gender'] == 'pria') ? 'Bapak' : 'Ibu'
            ];

            $data['message'] = str_replace(array_keys($replace), array_values($replace), $data['message']);

            if($produk['to_agent'] == 1){
                return view('form-agent', $data);
            } else {
                return view('form-registrasi', $data);
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function agent($username = null){
        $db = db_connect();
        
        // Mendapatkan URL lengkap
        $currentUrl = current_url();
        
        // Mendapatkan hanya path dari URL
        $currentPath = $this->request->getPath();
        $produk = explode('/', $currentPath);

        if($username == ''){
            $data['title'] = "Setor Data Peminat Agent";
    
            $data['message'] = $db->query("
                SELECT 
                    *
                FROM system_parameter
                WHERE setting_name = 'message_success_customer'
            ")->getRowArray();

            return view('form-agent', $data);
        } else {
            $username = $produk[2];
    
            $data['agent'] = $db->query("
                SELECT
                    *
                FROM agent 
                WHERE username = '$username'
                AND (deleted_at = '0000-00-00 00:00:00' OR deleted_at IS NULL)
            ")->getRowArray();
    
            $pk_id_agent = $data['agent']['pk_id_agent'];
    
            if($data['agent']){
                $data['title'] = "Setor Data Peminat Agent";
    
                $data['message'] = $db->query("
                    SELECT 
                        *
                    FROM system_parameter
                    WHERE setting_name = 'message_success_customer'
                ")->getRowArray();
    
                return view('form-agent', $data);
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        }
    }

    public function save()
    {
        // Start transaction
        $this->db->transBegin();
        $failed = false;

        $data = [
            'nama_customer' => $this->request->getPost('nama_customer'),
            'no_wa' => $this->request->getPost('no_wa'),
            // 'alamat' => $this->request->getPost('alamat'),
            // 'kelurahan' => $this->request->getPost('kelurahan'),
            // 'kecamatan' => $this->request->getPost('kecamatan'),
            'kota_kabupaten' => $this->request->getPost('kota_kabupaten'),
            // 'provinsi' => $this->request->getPost('provinsi'),
            'email' => $this->request->getPost('email'),
            'fk_id_agent' => $this->request->getPost('fk_id_agent'),
            'jenis_produk' => $this->request->getPost('jenis_produk'),
        ];

        if (isset($_POST['tipe_agent'])) {
            $tipe_agent = $this->request->getPost('tipe_agent');
            if ($tipe_agent == '') {
                $response['error']['tipe_agent'] = 'Paket harus diisi';
                
                $failed = true;
                return json_encode($response);
            }

            $dataProduk = $this->produkModel->where('tipe_agent', $tipe_agent)->first();
            $data['fk_id_produk'] = $dataProduk['pk_id_produk'];
        } else {
            $data['fk_id_produk'] = $this->request->getPost('fk_id_produk');
        }

        $is_send_wa = 0;
        $wa_message = '';

        if($this->customerModel->save($data) === true){
            $fk_id_customer = $this->customerModel->getInsertID();
            
            if($data['jenis_produk'] == 'produk'){
                $produk = $this->db->query("
                    SELECT
                        *
                    FROM produk
                    WHERE pk_id_produk = $data[fk_id_produk]
                ")->getRowArray();

                $dataPenjualan = [
                    'fk_id_customer' => $fk_id_customer,
                    'fk_id_produk' => $produk['pk_id_produk'],
                    'tgl_closing' => date('Y-m-d'),
                    'fk_id_travel' => $produk['fk_id_travel'],
                    'fk_id_agent_closing' => $data['fk_id_agent'],
                    'status' => 'pending'
                ];

                if ($this->penjualanProdukModel->save($dataPenjualan) !== true) {
                    $response = [
                        "error" => $this->penjualanProdukModel->errors()
                    ];

                    $failed = true;
                }

            } else {
                $produk = $this->db->query("
                    SELECT
                        *
                    FROM produk_travel
                    WHERE pk_id_produk_travel = $data[fk_id_produk]
                ")->getRowArray();

                $dataPenjualan = [
                    'fk_id_customer' => $fk_id_customer,
                    'fk_id_produk_travel' => $produk['pk_id_produk_travel'],
                    'tgl_closing' => date('Y-m-d'),
                    'fk_id_travel' => $produk['fk_id_travel'],
                    'fk_id_agent_closing' => $data['fk_id_agent'],
                    'status' => 'pending'
                ];

                if ($this->penjualanProdukTravelModel->save($dataPenjualan) !== true) {
                    $response = [
                        "error" => $this->penjualanProdukTravelModel->errors()
                    ];

                    $failed = true;
                }
            }

            $is_send_wa = $produk['send_wa_after_input_agent'];
            $wa_message = $produk['wa_message'];
        } else {
            $response = [
                "error" => $this->customerModel->errors()
            ];

            $failed = true;
        }

        if ($this->db->transStatus() === false || $failed) {
            $this->db->transRollback();

            if(!isset($response['error'])){
                $response = [
                    'status' => 'error',
                    'message' => 'Gagal menambahkan penjualan'
                ];
            }
        } else {
            $this->db->transCommit();

            if($is_send_wa){
                $messageData = $wa_message;
    
                $replace = [
                    '$nama_customer$' => $data['nama_customer']
                ];
    
                // Replace placeholders with actual values
                $message = str_replace(array_keys($replace), array_values($replace), $messageData);
    
                send_wa($data['no_wa'], $message);
            }

            $response = [
                'status' => 'success',
                'message' => 'Berhasil menambahkan penjualan'
            ];
        }

        return json_encode($response);
    }

    public function saveAgent(){
        $data = [
            'nama_agent' => $this->request->getPost('nama_agent'),
            'no_wa' => $this->request->getPost('no_wa'),
            'email' => $this->request->getPost('email'),
            'tipe_agent' => $this->request->getPost('tipe_agent'),
            'fk_id_leader_agent' => $this->request->getPost('pk_id_agent'),
            'tgl_bergabung' => date('Y-m-d')
        ];

        if($this->agentModel->save($data) === true){
            $response = [
                'status' => 'success',
                'message' => 'Berhasil mendaftarkan data Anda'
            ];

            $messageData = $this->db->query("
                SELECT 
                    *
                FROM system_parameter
                WHERE setting_name = 'wa_message_registrasi_agent'
            ")->getRowArray();

            $replace = [
                '$nama_agent$' => $this->request->getPost('nama_agent')
            ];

            // Replace placeholders with actual values
            $message = str_replace(array_keys($replace), array_values($replace), $messageData['setting_value']);

            send_wa($data['no_wa'], $message);
        } else {
            $response = [
                "error" => $this->agentModel->errors()
            ];
        }

        return json_encode($response);
    }
}

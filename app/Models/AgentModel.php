<?php

namespace App\Models;

use CodeIgniter\Model;

class AgentModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'agent';
    protected $primaryKey       = 'pk_id_agent';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_agent',
        'username',
        'password',
        'cookie',
        'nama_agent',
        'gender',
        't4_lahir',
        'tgl_lahir',
        'no_wa',
        'email',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota_kabupaten',
        'provinsi',
        'bank_rekening',
        'no_rekening',
        'tipe_agent',
        'fk_id_leader_agent',
        'tgl_bergabung',
        'confirmed_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_agent' => 'required|max_length[100]',
        'no_wa' => 'required|max_length[100]',
        'email' => 'required|max_length[100]',
        'tipe_agent' => 'required|max_length[100]',
    ];
    protected $validationMessages   = [
        'nama_agent' => [
            'required' => 'Nama Anda wajib diisi.',
            'max_length' => 'Nama Anda tidak boleh lebih dari 100 karakter.'
        ],
        'no_wa' => [
            'required' => 'Nomor WhatsApp wajib diisi.',
            'max_length' => 'Nomor WhatsApp tidak boleh lebih dari 15 karakter.',
            'numeric' => 'Nomor WhatsApp harus berupa angka.'
        ],
        'email' => [
            'required' => 'Email wajib diisi.',
            'valid_email' => 'Email tidak valid.'
        ],
        'tipe_agent' => [
            'required' => 'Pilihan paket wajib diisi.'
        ],
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

    protected function generateKodeAgent($data)
    {
        // Mendapatkan tahun dan bulan saat ini dalam format YYMM
        $currentDate = date('y');

        // Mencari urutan terakhir dengan tahun dan bulan yang sama
        $urutan_terakhir = $this->where("DATE_FORMAT(tgl_bergabung, '%y%') =", $currentDate)->orderBy("kode_agent", "DESC")->first();

        // Menentukan urutan baru
        if ($urutan_terakhir) {
            $lastUrutan = intval(substr($lastAgent['kode_agent'], -6));
            $newUrutan = $lastUrutan + 1;
        } else {
            $newUrutan = 1;
        }

        // Menyimpan urutan baru ke dalam data
        $data['data']['urutan'] = $newUrutan;

        // Membentuk kode agen
        $kodeAgent = date('ym') . '' . sprintf("06d", $newUrutan);

        // Menyimpan kode agen ke dalam data
        $data['data']['kode_agent'] = $kodeAgent;

        return $data;
    }
}

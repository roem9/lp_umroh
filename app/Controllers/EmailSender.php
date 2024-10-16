<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class EmailSender extends BaseController
{
    public $emailSender;
    public $db;


    public function __construct(){
        $this->emailSender = \Config\Services::email();
        
        $this->db = db_connect();
    }

    public function config(){

        $email = $this->db->query("
            SELECT
                *
            FROM system_parameter
            WHERE setting_name = 'email'
        ")->getRowArray();

        $email_password = $this->db->query("
            SELECT
                *
            FROM system_parameter
            WHERE setting_name = 'email_password'
        ")->getRowArray();
        
        $email_host = $this->db->query("
            SELECT
                *
            FROM system_parameter
            WHERE setting_name = 'email_host'
        ")->getRowArray();

        $config['protocol'] = 'smtp';
        $config['SMTPHost'] = "$email_host[setting_value]";
        $config['SMTPUser'] = "$email[setting_value]";
        $config['SMTPPass'] = "$email_password[setting_value]";

        $this->emailSender->initialize($config);
    }

    public function send($alamat_email, $subject, $isi_pesan){
        $this->config();

        $this->emailSender->setTo($alamat_email);
        
        $this->emailSender->setFrom($this->emailSender->SMTPUser);

        $this->emailSender->setSubject($subject);
        
        $this->emailSender->setMessage($isi_pesan);

        if($this->emailSender->send()){
            $data = [
                "alamat_email" => $alamat_email,
                "subject" => $subject,
                "message" => $isi_pesan,
                "status" => "success"
            ];

            $builder = $this->db->table('log_email');
            $builder->insert($data);
        } else {
            $data = [
                "alamat_email" => $alamat_email,
                "subject" => $subject,
                "message" => $isi_pesan,
                "status" => "failed",
                "error" => $this->emailSender->printDebugger(['headers', 'subject', 'body'])
            ];

            $builder = $this->db->table('log_email');
            $builder->insert($data);
        }
    }
}

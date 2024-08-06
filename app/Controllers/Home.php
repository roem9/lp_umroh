<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function landing_page($page)
    {
        $db = db_connect();

        // Mengambil host dari URL yang saat ini diakses
        $host = $_SERVER['HTTP_HOST'];

        // Memecah host berdasarkan titik (.)
        $parts = explode('.', $host);

        // Mengambil subdomain pertama
        $username = $parts[0];

        $data['agent'] = $db->query("
            SELECT
                *
            FROM agent 
            WHERE username = '$username'
            AND (deleted_at = '0000-00-00 00:00:00' OR deleted_at IS NULL)
        ")->getRowArray();

        if($data['agent']){

            $pk_id_agent = $data['agent']['pk_id_agent'];
    
            $produk = $db->query("
                SELECT
                    *
                FROM produk
                WHERE page = '$page'
            ")->getRowArray();
    
            if($produk){
                $data['pixel'] = $db->query("
                    SELECT
                        *
                    FROM pixel_produk
                    WHERE fk_id_produk = $produk[pk_id_produk]
                    AND fk_id_agent = $pk_id_agent
                    AND (deleted_at = '0000-00-00 00:00:00' OR deleted_at IS NULL)
                ")->getResultArray();
            } else {
                $produk = $db->query("
                    SELECT
                        *
                    FROM produk_travel
                    WHERE page = '$page'
                ")->getRowArray();
    
                $data['pixel'] = $db->query("
                    SELECT
                        *
                    FROM pixel_produk_travel
                    WHERE fk_id_produk_travel = $produk[pk_id_produk_travel]
                    AND fk_id_agent = $pk_id_agent
                    AND (deleted_at = '0000-00-00 00:00:00' OR deleted_at IS NULL)
                ")->getResultArray();
            }
    
            if($data['agent']){
                if($page == 'badal-haji'){
                    return view('landing_page/badal-haji', $data);
                } else if($page == 'kelas-gratis'){
                    return view('landing_page/kelas-gratis', $data);
                } else if($page == 'umroh-edukasi'){
                    return view('landing_page/umroh-edukasi', $data);
                } else if($page == 'umroh-tanur-2024'){
                    return view('landing_page/umroh-tanur-2024', $data);
                } else if($page == 'live-webinar'){
                    return view('landing_page/live-webinar', $data);
                } else {
                    throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
                }
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

    }

    public function registrasi($username, $page){
        // Mendapatkan URL lengkap
        $currentUrl = current_url();
        
        // Mendapatkan hanya path dari URL
        $currentPath = $this->request->getPath();

        echo "URL saat ini: " . $currentUrl;
        echo "<br>";
        echo "Path saat ini: " . $currentPath;

        // var_dump($parsed_url);
        // $db = db_connect();

        // $data['agent'] = $db->query("
        //     SELECT
        //         *
        //     FROM agent 
        //     WHERE username = '$username'
        //     AND (deleted_at = '0000-00-00 00:00:00' OR deleted_at IS NULL)
        // ")->getRowArray();

        // $pk_id_agent = $data['agent']['pk_id_agent'];

        // $produk = $db->query("
        //     SELECT
        //         *
        //     FROM produk
        //     WHERE page = '$page'
        // ")->getRowArray();

        // if($produk){
        //     $data['pixel'] = $db->query("
        //         SELECT
        //             *
        //         FROM pixel_produk
        //         WHERE fk_id_produk = $produk[pk_id_produk]
        //         AND fk_id_agent = $pk_id_agent
        //     ")->getResultArray();
        // } else {
        //     $produk = $db->query("
        //         SELECT
        //             *
        //         FROM produk_travel
        //         WHERE page = '$page'
        //     ")->getRowArray();

        //     $data['pixel'] = $db->query("
        //         SELECT
        //             *
        //         FROM pixel_produk_travel
        //         WHERE fk_id_produk_travel = $produk[pk_id_produk_travel]
        //         AND fk_id_agent = $pk_id_agent
        //     ")->getResultArray();
        // }

        // if($data['agent']){
        //     if($page == 'badal-umroh'){
        //         return view('landing_page/badal-umroh', $data);
        //     } else {
        //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        //     }
        // } else {
        //     throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        // }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_kerma extends CI_Controller {

    // Kunci rahasia statis. Samakan token ini di aplikasi PMB nanti.
    private $secret_token = 'ZBAcfcxkEcye95ESSzahXP1tg67ZzVyuIrRQGoK1xXcuY7WGe6ejUYgauxiIMkBd';

    public function __construct() {
        parent::__construct();
        // Load database Kerma (pastikan settingan di database.php sudah benar)
        $this->load->database();
    }

    public function get_mitra_sekolah() {
        // 1. Pengecekan Keamanan (Header Otorisasi)
        $headers = $this->input->request_headers();
        $auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';

        if ($auth_header !== 'Bearer ' . $this->secret_token) {
            return $this->output
                ->set_status_header(401) // Unauthorized
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Akses ditolak. Token tidak valid.']));
        }

        // 2. Eksekusi Query menggunakan Query Builder CI3
        $this->db->select('*');
        $this->db->from('kerma');
        
        // Parameter ketiga 'FALSE' mencegah CI3 menambahkan backticks (`) yang bisa merusak syntax REGEXP
        $this->db->where("mitra REGEXP '^(SMA|SMAN|SMK|MA|PONDOK PESANTREN)[[:space:]]'", NULL, FALSE);
        $this->db->where('tanggal_selesai >', date('Y-m-d'));
        $this->db->order_by('id', 'DESC');

        $query = $this->db->get();

        // 3. Format Output sebagai JSON
        if ($query->num_rows() > 0) {
            $response = [
                'status' => true,
                'jumlah_data' => $query->num_rows(),
                'data' => $query->result_array()
            ];
        } else {
            $response = [
                'status' => true, // Status tetap true (koneksi sukses), tapi data kosong
                'jumlah_data' => 0,
                'data' => [],
                'message' => 'Data tidak ditemukan'
            ];
        }

        // Kirim response
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siakad_model extends CI_Model
{
    private $db2;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->db2 = $this->load->database('siakad', TRUE);
    }
    public function get_jurusan()
    {
        $id_sp = 'b6723774-9022-45c8-a6b0-be0a4d7cb7e3';
        $this->db2->from('sms a');
        // $this->db2->join('jenjang_pendidikan b', 'a.id_jenj_didik=b.id_jenj_didik');
        $this->db2->where('id_sp', $id_sp);
        $this->db2->where("kode_prodi != ''");
        $this->db2->where("stat_prodi", "A");
        $this->db2->where("id_jns_sms", "3");
        return $this->db2->get();
    }
    // public function get_kelas()
    // {
    //     $this->db2->from('kelas_mhs');
    //     return $this->db2->get();
    // }
    // public function get_mahasiswa($id)
    // {
    //     $this->db2->select('a.id_pd, a.nipd, b.nm_pd, a.shift, b.jk, a.id_sms, b.email');
    //     $this->db2->from('reg_pd a');
    //     $this->db2->join('peserta_didik b', 'a.id_pd = b.id_pd');
    //     $this->db2->join('sms c', 'c.id_sms=a.id_sms');
    //     $this->db2->where('a.id_pd', $id);
    //     return $this->db2->get();
    // }
    public function getDataProdi()
    {
        $this->datatables->set_database('siakad');
        $this->datatables->select('id_sms, nm_lemb, id_jenj_didik');
        $this->datatables->from('sms');
        $id_sp = 'b6723774-9022-45c8-a6b0-be0a4d7cb7e3';
        $this->datatables->where('id_sp', $id_sp);
        $this->datatables->where("kode_prodi != ''");
        $this->datatables->where("stat_prodi", "A");
        $this->datatables->where("id_jns_sms", "3");
        return $this->datatables->generate();
    }
    public function get_prodi($id)
    {
        return $this->db2->get_where('sms', ['id_sms' => $id]);
    }
}

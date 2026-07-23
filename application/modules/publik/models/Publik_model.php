<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Publik_model extends CI_Model
{
    public function getPanduanData()
    {
        $this->datatables->select('id, judul, deskripsi, tanggal, dokumen');
        $this->datatables->from('kerma_panduan');
        return $this->datatables->generate();
    }
    public function get_Panduan($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        return $this->db->get('kerma_panduan');
    }
    private function rand_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
    public function get_chart()
    {
        $this->db->select('id, nm_unit, (SELECT COUNT(id) FROM kerma WHERE kerma_unit.id=kerma.unit_id) as jumlah');
        $this->db->from('kerma_unit');
        $data = $this->db->get()->result();
        $trow = [];
        foreach ($data as $row) {
            $trow[] = array(
                'prodi' => $row->nm_unit,
                'value' => $row->jumlah,
                'color' => $this->rand_color()
            );
        }
        return $trow;
    }
    // ======== KERMA ================
    public function getDataKerma()
    {
        $this->datatables->select('a.id, referensi, judul, mitra, jenis_id, unit_id, tanggal_mulai, tanggal_selesai, dokumen, nm_unit');
        $this->datatables->from('kerma a');
        $this->datatables->join('kerma_unit b', 'a.unit_id=b.id', 'left');
        return $this->datatables->generate();
    }
    // ======== KERMA ================
    // ======== LAPORAN ================
    public function getDataPenerapan()
    {
        $this->datatables->select('a.id, judul, unit_id, tanggal, dokumen, nm_unit');
        $this->datatables->from('kerma_penerapan a');
        $this->datatables->join('kerma_unit b', 'a.unit_id=b.id', 'left');
        return $this->datatables->generate();
    }
    // ======== LAPORAN ================
    // ======== Kuisioner ================
    public function get_survey($token)
    {
        return $this->db->get_where('kerma_survey', ['token' => $token])->row();
    }
    public function get_pertanyaan($id)
    {
        $this->db->order_by('order_by', $id);
        return $this->db->get_where('kerma_pertanyaan', ['survey_id' => $id])->result();
    }
    // ======== Kuisioner ================
}

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
    private function rand_color($index = 0)
    {
        $palette = [
            '#4f46e5', '#06b6d4', '#10b981', '#f59e0b', '#8b5cf6',
            '#ec4899', '#3b82f6', '#14b8a6', '#84cc16', '#eab308',
            '#f97316', '#ef4444', '#6366f1', '#0284c7', '#059669'
        ];
        if (isset($palette[$index])) {
            return $palette[$index];
        }
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
    public function get_chart()
    {
        $this->db->select('id, nm_unit, (SELECT COUNT(id) FROM kerma WHERE kerma_unit.id=kerma.unit_id) as jumlah');
        $this->db->from('kerma_unit');
        $data = $this->db->get()->result();
        $trow = [];
        $i = 0;
        foreach ($data as $row) {
            if ($row->jumlah > 0) {
                $trow[] = array(
                    'prodi' => $row->nm_unit,
                    'value' => (int)$row->jumlah,
                    'color' => $this->rand_color($i++)
                );
            }
        }
        return $trow;
    }

    public function get_summary_tipe()
    {
        $this->db->select('t.id, t.nama_tipe, t.slug, 
            COUNT(k.id) as total,
            SUM(CASE WHEN k.tanggal_selesai >= CURDATE() THEN 1 ELSE 0 END) as total_aktif,
            SUM(CASE WHEN k.tanggal_selesai < CURDATE() THEN 1 ELSE 0 END) as total_expired');
        $this->db->from('kerma_tipe t');
        $this->db->join('kerma k', 't.id = k.tipe_id', 'left');
        $this->db->group_by('t.id, t.nama_tipe, t.slug');
        $this->db->order_by('t.id', 'ASC');
        return $this->db->get()->result();
    }

    public function get_total_stats()
    {
        $total_kerma = $this->db->count_all('kerma');

        $this->db->where('tanggal_selesai >=', date('Y-m-d'));
        $total_aktif = $this->db->count_all_results('kerma');

        $this->db->where('tanggal_selesai <', date('Y-m-d'));
        $total_expired = $this->db->count_all_results('kerma');

        $total_unit = $this->db->count_all('kerma_unit');
        $total_tipe = $this->db->count_all('kerma_tipe');

        return (object)[
            'total_kerma'   => $total_kerma,
            'total_aktif'   => $total_aktif,
            'total_expired' => $total_expired,
            'total_unit'    => $total_unit,
            'total_tipe'    => $total_tipe,
        ];
    }
    // ======== KERMA ================
    public function getDataKerma()
    {
        $this->datatables->select('a.id, referensi, judul, mitra, jenis_id, unit_id, tanggal_mulai, tanggal_selesai, dokumen, nm_unit, c.nama_tipe');
        $this->datatables->from('kerma a');
        $this->datatables->join('kerma_unit b', 'a.unit_id=b.id', 'left');
        $this->datatables->join('kerma_tipe c', 'a.tipe_id=c.id', 'left');

        if ($this->input->post('filter_unit')) {
            $this->datatables->where('b.id', $this->input->post('filter_unit'));
        }
        if ($this->input->post('filter_tipe')) {
            $this->datatables->where('a.tipe_id', $this->input->post('filter_tipe'));
        }
        if ($this->input->post('filter_kategori')) {
            $this->datatables->where('a.kategori_id', $this->input->post('filter_kategori'));
        }

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

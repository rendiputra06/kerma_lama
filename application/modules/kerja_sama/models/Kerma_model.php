<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kerma_model extends CI_Model
{
    public function getDataKerma($id = null)
    {
        $this->datatables->select('a.id, judul, mitra, jenis_id, unit_id, tanggal_mulai, tanggal_selesai, dokumen, nm_unit, status_kerma, a.create_at, c.nama_tipe');
        $this->datatables->from('kerma a');
        $this->datatables->join('kerma_unit b', 'a.unit_id=b.id', 'left');
        $this->datatables->join('kerma_tipe c', 'a.tipe_id=c.id', 'left');
        if ($id !== null) {
            $this->datatables->where('b.id', $id);
        }
        if ($this->input->post('filter_unit')) {
            $this->datatables->where('b.id', $this->input->post('filter_unit'));
        }
        if ($this->input->post('filter_jenis')) {
            $this->datatables->where('a.jenis_id', $this->input->post('filter_jenis'));
        }
        if ($this->input->post('filter_tipe')) {
            $this->datatables->where('a.tipe_id', $this->input->post('filter_tipe'));
        }
        if ($this->input->post('filter_status_kerma')) {
            $this->datatables->where('a.status_kerma', $this->input->post('filter_status_kerma'));
        }
        $filter_status = $this->input->post('filter_status');
        $today = date('Y-m-d');
        // Mengubah logika filter berdasarkan status
        if ($filter_status == '0') { // Aktif
            $this->datatables->where('tanggal_selesai >=', $today);
            // Pastikan tidak ada entri yang akan berakhir dalam waktu dekat
            $this->datatables->where('tanggal_selesai >', date('Y-m-d', strtotime('+5 months', strtotime($today))));
        } elseif ($filter_status == '1') { // Akan Berakhir
            $this->datatables->where('tanggal_selesai >', $today); // Hanya ambil yang akan berakhir setelah hari ini
            $this->datatables->where('tanggal_selesai <=', date('Y-m-d', strtotime('+5 months', strtotime($today)))); // Dalam 5 bulan ke depan
        } elseif ($filter_status == '2') { // Selesai
            $this->datatables->where('tanggal_selesai <', $today); // Hanya ambil yang sudah selesai
        }
        return $this->datatables->generate();
    }
    public function get_unit_select2()
    {
        $this->db->like('nm_unit', $this->input->get('searchTerm'));
        $this->db->from('kerma_unit');
        return $this->db->get()->result();
    }
    public function get_jenis_select2()
    {
        $this->db->like('nama', $this->input->get('searchTerm'));
        $this->db->from('kerma_jenis');
        return $this->db->get()->result();
    }
    public function get_kategori_select2()
    {
        $this->db->like('nama', $this->input->get('searchTerm'));
        $this->db->from('kerma_kategori');
        $this->db->order_by('id', 'DESC'); // urut berdasarkan nama A-Z
        return $this->db->get()->result();
    }
    public function get_bentuk_select2()
    {
        $this->db->like('nama', $this->input->get('searchTerm'));
        $this->db->from('kerma_bentuk');
        return $this->db->get()->result();
    }
    public function get_tipe_select2()
    {
        $this->db->like('nama_tipe', $this->input->get('searchTerm'));
        $this->db->from('kerma_tipe');
        return $this->db->get()->result();
    }
    public function get_kerma($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        return $this->db->get('kerma');
    }
    public function editAjax()
    {
        $id = $this->input->post('id');
        $data = $this->db->get_where('kerma', ['id' => $id])->row();
        return ['status' => TRUE, 'data' => $data];
    }
    public function insert_data($dokumen)
    {
        $this->db
            ->insert('kerma', [
                'referensi'       => $this->input->post('referensi'),
                'judul'           => $this->input->post('judul'),
                'mitra'           => $this->input->post('mitra'),
                'unit_id'         => $this->input->post('unit_id'),
                'jenis_id'        => $this->input->post('jenis_id'),
                'kategori_id'     => $this->input->post('kategori_id'),
                'bentuk_id'       => $this->input->post('bentuk_id'),
                'status_kerma'    => $this->input->post('status_kerma'),
                'tipe_id'         => $this->input->post('tipe_id'),
                'tanggal_mulai'   => $this->input->post('tanggal_mulai'),
                'tanggal_selesai' => $this->input->post('tanggal_selesai'),
                'dokumen'         => $dokumen,
            ]);
        return ['status' => TRUE];
    }
    public function update_data($dokumen)
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db
            ->update('kerma', [
                'referensi'       => $this->input->post('referensi'),
                'judul'           => $this->input->post('judul'),
                'mitra'           => $this->input->post('mitra'),
                'unit_id'         => $this->input->post('unit_id'),
                'jenis_id'        => $this->input->post('jenis_id'),
                'kategori_id'     => $this->input->post('kategori_id'),
                'bentuk_id'       => $this->input->post('bentuk_id'),
                'status_kerma'    => $this->input->post('status_kerma'),
                'tipe_id'         => $this->input->post('tipe_id'),
                'tanggal_mulai'   => $this->input->post('tanggal_mulai'),
                'tanggal_selesai' => $this->input->post('tanggal_selesai'),
                'dokumen'         => $dokumen,
            ]);
        return ['status' => TRUE];
    }
    public function get_user_prodi($id)
    {
        $this->db->where('a.id', $id);
        $this->db->from('kerma_tendik a');
        $this->db->join('kerma_unit b', 'a.unit_id=b.id');
        return $this->db->get()->row();
    }
    public function export()
    {
        // Ambil filter dari GET
        $jenis  = $this->input->get('jenis');
        $unit   = $this->input->get('unit');
        $tipe   = $this->input->get('tipe');
        $status_kerma = $this->input->get('status_kerma');
        $filter_status = $this->input->get('filter_status');
    
        $today = date('Y-m-d');
    
        $this->db->select('a.*, b.nm_unit, c.nama_tipe, d.slug, d.nama AS nama_jenis, e.nama AS kategori');
        $this->db->from('kerma a');
        $this->db->join('kerma_unit b', 'a.unit_id=b.id');
        $this->db->join('kerma_tipe c', 'a.tipe_id=c.id', 'left');
        $this->db->join('kerma_jenis d', 'a.jenis_id=d.id');
        $this->db->join('kerma_kategori e', 'a.kategori_id=e.id');
        
        // Terapkan filter jika ada
        if (!empty($unit)) {
            $this->db->where('a.unit_id', $unit);
        }
        if (!empty($jenis)) {
            $this->db->where('a.jenis_id', $jenis);
        }
        if (!empty($tipe)) {
            $this->db->where('a.tipe_id', $tipe);
        }
        if (!empty($status_kerma)) {
            $this->db->where('a.status_kerma', $status_kerma);
        }
    
        // Filter status aktif, akan berakhir, selesai
        if ($filter_status === '0') { // Aktif
            $this->db->where('tanggal_selesai >=', $today);
            $this->db->where('tanggal_selesai >', date('Y-m-d', strtotime('+5 months', strtotime($today))));
        } elseif ($filter_status === '1') { // Akan Berakhir
            $this->db->where('tanggal_selesai >', $today);
            $this->db->where('tanggal_selesai <=', date('Y-m-d', strtotime('+5 months', strtotime($today))));
        } elseif ($filter_status === '2') { // Selesai
            $this->db->where('tanggal_selesai <', $today);
        }
    
        // Grouping untuk penggabungan tipe (jika ada MoU+MoA)
        $this->db->group_by('a.id');
    
        return $this->db->get()->result();
    }
}

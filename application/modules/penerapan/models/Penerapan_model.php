<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penerapan_model extends CI_Model
{
    public function getDataPenerapan($id = null)
    {
        $this->datatables->select('a.id, judul, unit_id, tanggal, dokumen, nm_unit');
        $this->datatables->from('kerma_penerapan a');
        $this->datatables->join('kerma_unit b', 'a.unit_id=b.id', 'left');
        if ($id !== null) {
            $this->datatables->where('b.id', $id);
        }
        return $this->datatables->generate();
    }
    public function get_penerapan($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        return $this->db->get('kerma_penerapan');
    }
    public function editAjax()
    {
        $id = $this->input->post('id');
        $data = $this->db->get_where('kerma_penerapan', ['id' => $id])->row();
        return ['status' => TRUE, 'data' => $data];
    }
    public function insert_data($dokumen)
    {
        $this->db
            ->insert('kerma_penerapan', [
                'judul'   => $this->input->post('judul'),
                'unit_id' => $this->input->post('unit_id'),
                'tanggal' => $this->input->post('tanggal'),
                'dokumen' => $dokumen,
            ]);
        return ['status' => TRUE];
    }
    public function update_data($dokumen)
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db
            ->update('kerma_penerapan', [
                'judul'   => $this->input->post('judul'),
                'unit_id' => $this->input->post('unit_id'),
                'tanggal' => $this->input->post('tanggal'),
                'dokumen' => $dokumen,
            ]);
        return ['status' => TRUE];
    }
    public function get_unit_select2()
    {
        $this->db->like('nm_unit', $this->input->get('searchTerm'));
        $this->db->from('kerma_unit');
        return $this->db->get()->result();
    }
    public function get_user_prodi($id)
    {
        $this->db->where('a.id', $id);
        $this->db->from('kerma_tendik a');
        $this->db->join('kerma_unit b', 'a.unit_id=b.id');
        return $this->db->get()->row();
    }
}

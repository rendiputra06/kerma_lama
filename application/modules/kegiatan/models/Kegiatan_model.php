<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kegiatan_model extends CI_Model
{
    public function insert_data($cover, $id)
    {
        $this->db->insert('kerma_kegiatan', [
            'judul'     => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tanggal'   => $this->input->post('tanggal'),
            'author'    => $id,
            'cover'     => $cover,
        ]);

        return ['status' => TRUE];
    }
    public function update_data($cover)
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('kerma_kegiatan', [
            'judul'     => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tanggal'   => $this->input->post('tanggal'),
            'cover'     => $cover,
        ]);
        return ['status' => TRUE];
    }
    public function getDatakegiatan($id = null)
    {
        $this->datatables->select("a.id, judul, deskripsi, a.tanggal, cover, CONCAT(first_name, ' ', last_name) AS full_name");
        $this->datatables->from('kerma_kegiatan a');
        $this->datatables->join('users b', 'a.author=b.id');
        if ($id != null) {
            $this->datatables->where('b.id', $id);
        }
        return $this->datatables->generate();
    }
    public function get_kegiatan_grid($id = null)
    {
        if ($id != null) {
            $this->db->where('author', $id);
        }
        return $this->db->get('kerma_kegiatan');
    }
    public function get_kegiatan($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        return $this->db->get('kerma_kegiatan');
    }
}

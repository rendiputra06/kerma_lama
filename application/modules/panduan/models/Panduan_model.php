<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Panduan_model extends CI_Model
{
    public function insert_data($files)
    {
        $post = array(
            'judul' => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tanggal' => $this->input->post('tanggal'),
        );

        $this->db->insert('kerma_panduan', array_merge($post, $files));

        return ['status' => TRUE];
    }
    public function update_data($files)
    {
        $post = array(
            'judul' => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tanggal' => $this->input->post('tanggal'),
        );
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('kerma_panduan', array_merge($post, $files));
        return ['status' => TRUE];
    }
    public function getDataPanduan()
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
}

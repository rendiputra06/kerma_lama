<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Survey_model extends CI_Model
{
    public function get_data()
    {
        $this->datatables->select('id, judul, kode, deskripsi, tanggal_mulai, tanggal_selesai');
        $this->datatables->from('kerma_survey');
        return $this->datatables->generate();
    }
    public function get_survey($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        $this->db->from('kerma_survey');
        return $this->db->get();
    }
    private function _gen_token()
    {
        $r = '';
        $i = 0;
        while ($i == 0) {
            $k = substr(str_shuffle(str_repeat($x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5 / strlen($x)))), 1, 5);
            $cek = $this->db->get_where('kerma_survey', ['token' => $k])->num_rows();
            if ($cek == 0) {
                $i = 1;
            }
            $r = $k;
        }
        return $r;
    }
    public function insert_survey()
    {
        $token = $this->_gen_token();
        $this->db->insert('kerma_survey', [
            'token'            => $this->_gen_token(),
            'kode'            => $this->input->post('kode'),
            'judul'           => $this->input->post('judul'),
            'deskripsi'       => $this->input->post('deskripsi'),
            'tanggal_mulai'   => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $this->input->post('tanggal_selesai'),
        ]);
        return ['status' => TRUE];
    }
    public function update_survey()
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('kerma_survey', [
            'kode'            => $this->input->post('kode'),
            'judul'           => $this->input->post('judul'),
            'deskripsi'       => $this->input->post('deskripsi'),
            'tanggal_mulai'   => $this->input->post('tanggal_mulai'),
            'tanggal_selesai' => $this->input->post('tanggal_selesai'),
        ]);
        return ['status' => TRUE];
    }
    public function get_order($survey_id)
    {
        $cek = $this->db->get_where('kerma_pertanyaan', ['survey_id' => $survey_id]);
        // $order = 1;
        // if($cek){
        //     $order = $cek->num_rows() + $order;
        // }
        // return $order
        return $cek ? $cek->num_rows() + 1 : 1;
    }
    public function get_pertanyaan($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        return $this->db->get('kerma_pertanyaan');
    }
    public function get_pertanyaan_sid($id)
    {
        $this->db->order_by('order_by');
        return $this->db->get_where('kerma_pertanyaan', ['survey_id' => $id]);
    }
    public function insert_pertanyaan($insert)
    {
        $this->db->insert('kerma_pertanyaan', $insert);
        return ['status' => TRUE];
    }
    public function update_pertanyaan($update)
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('kerma_pertanyaan', $update);
        return ['status' => TRUE];
    }
    public function data_tanggapan($token)
    {
        // $this->datatables->select('a.id, a.user_id, a.komen, a.create_at, b.img_name, b.first_name, b.last_name, c.full_name');
        $this->datatables->select('a.id, a.token, b.user_id, b.nama, b.email, b.create_at');
        $this->datatables->from('kerma_survey a');
        $this->datatables->join('kerma_tanggapan b', 'a.id=b.survey_id');
        // $this->datatables->join('users b', 'b.id=a.user_id');
        // $this->datatables->join('srt_detail c', 'c.id=b.save_id');
        $this->datatables->where('a.token', $token);
        return $this->datatables->generate();
    }
    public function get_jawaban($survey_id)
    {
        $this->db->from('kerma_pertanyaan a');
        $this->db->join('kerma_isi_tanggapan b', 'a.id=b.pertanyaan_id');
        $this->db->where('a.survey_id', $survey_id);
        // $this->db->where('a.type <>', 'desc');
        $tanggapan = $this->db->get()->result_array();
        $ans = array();
        foreach ($tanggapan as $row) {
            if ($row['type'] == 'radio_opt') {
                $ans[$row['pertanyaan_id']][$row['jawaban']][] = 1;
            }
            if ($row['type'] == 'level_s') {
                $ans[$row['pertanyaan_id']][$row['jawaban']][] = 1;
            }
            if ($row['type'] == 'check_opt') {
                foreach (explode(",", str_replace(array("[", "]"), '', $row['jawaban'])) as $v) {
                    $ans[$row['pertanyaan_id']][$v][] = 1;
                }
            }
            if ($row['type'] == 'textfield_s') {
                $ans[$row['pertanyaan_id']][] = $row['jawaban'];
            }
        }
        return $ans;
    }
}

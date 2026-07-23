<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_model extends CI_Model
{
    public function getDataJenis()
    {
        $this->datatables->select('id, nama');
        $this->datatables->from('kerma_jenis');
        return $this->datatables->generate();
    }
    public function insert_jenis()
    {
        // buat slug 
        $nama = $this->input->post('nama');
        $slug = make_slug($nama);
        $this->db->insert('kerma_jenis', ['slug' => $slug, 'nama' => $nama]);
        return ['status' => TRUE];
    }
    public function update_jenis()
    {
        $nama = $this->input->post('nama');
        $slug = make_slug($nama);
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('kerma_jenis', ['slug' => $slug, 'nama' => $nama]);
        return ['status' => TRUE];
    }
    public function getDataUnit()
    {
        $this->datatables->select('id, id_sms, nm_unit');
        $this->datatables->from('kerma_unit');
        return $this->datatables->generate();
    }
    public function insert_unit()
    {
        // buat slug 
        $nm_unit = $this->input->post('nm_unit');
        $sms = make_sms(date('Y-m-d H:i:s'));
        $this->db->insert('kerma_unit', ['id_sms' => $sms, 'nm_unit' => $nm_unit]);
        return ['status' => TRUE];
    }
    public function update_unit()
    {
        $nm_unit = $this->input->post('nm_unit');
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('kerma_unit', ['nm_unit' => $nm_unit]);
        return ['status' => TRUE];
    }
    public function get_id_unit()
    {
        $this->db->select('id_sms');
        $this->db->from('kerma_unit');
        return $this->db->get();
    }
    public function get_data_tendik()
    {
        $this->datatables->select('a.id, a.nama, a.email, b.nm_unit');
        $this->datatables->from('kerma_tendik a');
        $this->datatables->join('kerma_unit b', 'a.unit_id=b.id');
        return $this->datatables->generate();
    }
    public function getEmailTendik($id)
    {
        $this->db->select('b.email');
        $this->db->where('a.id', $id);
        $this->db->from('kerma_tendik a');
        $this->db->join('users b', 'a.id=b.id_tendik');
        return $this->db->get();
    }
    public function insert_tendik()
    {
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');

        $this->db->insert('kerma_tendik', [
            'nama' => $nama,
            'email' => $email,
            'unit_id' => $this->input->post('unit_id'),
        ]);
        $id_tendik = $this->db->insert_id();
        $username = $nama;
        $password = 'Abdurrab_051';
        $nama_2       = explode(' ', $nama);
        $first_name = $nama_2[0];
        $last_name  = isset($nama_2[1]) ? $nama_2[1] : '';
        $data = array(
            'id_tendik'  => $id_tendik,
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'company'    => 'Universitas Abdurrab',
            'phone'      => '--',
            'img_name'   => 'default.png'
        );
        $data['username'] = $this->generate_unique_username($nama);
        $this->ion_auth->register($username, $password, $email, $data, [4]);
        return ['status' => TRUE];
    }
    function generate_unique_username($string_name = "Mike Tyson", $rand_no = 200)
    {
        while (true) {
            $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
            $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

            $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, 8) : ""; //cut first name to 8 letters
            $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, 5) : ""; //cut second name to 5 letters
            $part3 = ($rand_no) ? rand(0, $rand_no) : "";

            $username = $part1 . str_shuffle($part2) . $part3; //str_shuffle to randomly shuffle all characters 

            $username_exist_in_db = $this->username_exist_in_database($username); //check username in database
            if (!$username_exist_in_db) {
                return $username;
            }
        }
    }
    private function username_exist_in_database($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }
    public function update_tendik()
    {
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->update('kerma_tendik', [
            'nama' => $nama,
            'email' => $email,
            'unit_id' => $this->input->post('unit_id'),
        ]);

        $nama_2       = explode(' ', $nama);
        $first_name = $nama_2[0];
        $last_name  = isset($nama_2[1]) ? $nama_2[1] : '';
        $users = $this->db->get_where('users', ['id_tendik' => $id])->row();
        $this->ion_auth->update($users->id, [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email' => $email,
        ]);
        return ['status' => TRUE];
    }
}

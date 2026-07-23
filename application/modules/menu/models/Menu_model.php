<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public $table = 'menu';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    public function get_menu($id = null)
    {
        if ($id != null) {
            $this->db->where('id', $id);
        }
        // $this->db->select('users.*, (SELECT GROUP_CONCAT(users_groups.group_id SEPARATOR ":") FROM users_groups WHERE users_groups.user_id = users.id) as level');
        $this->db->select('navi.*, (SELECT GROUP_CONCAT(navi_groups.group_id SEPARATOR ":") FROM navi_groups WHERE navi_groups.navi_id = navi.id) as level');
        return $this->db->get('navi');
    }

    public function get_id_menu_type_by_flag($flag = '')
    {
        $flag = str_replace('-', ' ', $flag);

        $query = $this->db->get_where('menu_type', ['name' => $flag]);

        if ($query->row()) {
            return $query->row()->id;
        }

        return 0;
    }
    public function get_parent()
    {
        $this->db->like('label', $this->input->get('searchTerm'));
        $this->db->from('navi');
        return $this->db->get()->result();
    }
    public function get_menu_type()
    {
        $this->db->like('name', $this->input->get('searchTerm'));
        $this->db->from('menu_type');
        return $this->db->get()->result();
    }
    public function get_user_group()
    {
        $this->db->like('name', $this->input->get('searchTerm'));
        $this->db->or_like('description', $this->input->get('searchTerm'));
        $this->db->from('groups');
        return $this->db->get()->result();
    }
    public function addMenu()
    {
        $sort = $this->db->select_max('sort')->get('navi')->row();
        $this->db
            ->insert('navi', [
                'label'         => $this->input->post('label'),
                'type'          => $this->input->post('type_menu'),
                'link'          => $this->input->post('link'),
                'sort'          => $sort->sort + 1,
                'parent'        => $this->input->post('parent'),
                'icon'          => $this->input->post('icon'),
                'group_id'      => 1,
                'menu_type_id'  => $this->input->post('menu_type_id'),
                'active'        => 1,
            ]);
        $id = $this->db->insert_id();
        $id_group = $this->input->post('group');
        $result = array();
        foreach ($id_group as $val) {
            $result[] = array(
                'navi_id'    => $id,
                'group_id'       => $val
            );
        }
        $this->db->insert_batch('navi_groups', $result);
        return ['status' => TRUE];
    }
    public function editMenu()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db
            ->update('navi', [
                'label'         => $this->input->post('label'),
                'type'          => $this->input->post('type_menu'),
                'link'          => $this->input->post('link'),
                'parent'        => $this->input->post('parent'),
                'icon'          => $this->input->post('icon'),
                'group_id'      => 1,
            ]);
        // ambil group yang baru
        $id_group = $this->input->post('group');
        // ambil group yang lama
        $navi_group = $this->group_array($id);
        // banding kan setiap id apakah sudah ada di data sebelumnya
        $data_lama = array_diff($navi_group, $id_group);
        $data_baru = array_diff($id_group, $navi_group);
        // hapus data lama
        if (count($data_lama) > 0) {
            foreach ($data_lama as $dl) {
                $this->db->where(array('navi_id' => $id, 'group_id' => $dl));
                $this->db->delete('navi_groups');
            }
        }
        if (count($data_baru) > 0) {
            $result = array();
            // tambahkan data dosen yang baru
            foreach ($data_baru as $db) {
                $result[] = array(
                    'navi_id'  => $id,
                    'group_id' => $db,
                );
            }
            $this->db->insert_batch('navi_groups', $result);
        }
        return ['status' => TRUE, 'data_lama' => $data_lama, 'data_baru' => $data_baru];
    }
    private function group_array($id)
    {
        $this->db->select('id, group_id');
        $this->db->from('navi_groups');
        $this->db->where('navi_id', $id);
        $data = $this->db->get()->result();
        $send = array();
        foreach ($data as $row) {
            $send[] = $row->group_id;
        }
        return $send;
    }
}

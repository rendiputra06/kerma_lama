<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model
{
    public function getDatausers($id = null)
    {
        // $this->datatables->select('users.id, username, first_name, last_name, email, FROM_UNIXTIME(created_on) as created_on, last_login, active, groups.name as level');
        // $this->datatables->from('users_groups');
        // $this->datatables->join('users', 'users_groups.user_id=users.id');
        // $this->datatables->join('groups', 'users_groups.group_id=groups.id');
        $this->datatables->select('users.id, username, first_name, last_name, email, FROM_UNIXTIME(created_on) as created_on, last_login, active, 
        (SELECT CONVERT (GROUP_CONCAT(groups.name SEPARATOR ",") USING utf8)
            FROM users_groups LEFT JOIN groups on users_groups.group_id = groups.id
            WHERE users_groups.user_id = users.id) as level');
        $this->datatables->from('users');
        if ($id !== null) {
            $this->datatables->where('users.id !=', $id);
        }
        return $this->datatables->generate();
    }

    public function get_user($id = null)
    {
        if ($id != null) {
            $this->db->where('users.id', $id);
        }
        // $this->db->select('a.*, b.id as id_user_group, b.group_id');
        $this->db->select('users.*, (SELECT GROUP_CONCAT(users_groups.group_id SEPARATOR ":") FROM users_groups WHERE users_groups.user_id = users.id) as level');
        $this->db->from('users');
        // $this->db->join('users_groups b', 'a.id=b.user_id');
        return $this->db->get();
    }
    public function get_level_type()
    {
        $this->db->like('name', $this->input->get('searchTerm'));
        $this->db->from('groups');
        return $this->db->get()->result();
    }
    public function getDataGroups()
    {
        $this->datatables->from('groups');
        return $this->datatables->generate();
    }
    public function addGroup()
    {
        $this->db
            ->insert('groups', [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            ]);
        return ['status' => TRUE];
    }
    public function get_group($id = null)
    {
        $this->db->from('groups');
        if ($id != null) {
            $this->db->where('id', $id);
        }
        return $this->db->get();
    }
    public function editGroup()
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db
            ->update('groups', [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            ]);
        return ['status' => TRUE];
    }
}

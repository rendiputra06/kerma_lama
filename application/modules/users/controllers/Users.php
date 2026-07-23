<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->user = $this->ion_auth->user()->row();
        $this->tables = $this->config->item('tables', 'ion_auth');
        $this->identity_column = $this->config->item('username', 'ion_auth');
        $this->load->model('Users_model', 'users');
        $this->load->library('datatables'); // Load Library Ignited-Datatables
    }
    public function is_admin()
    {
        if (!$this->ion_auth->is_admin()) {
            show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
        }
    }
    public function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }
    public function data($id = null)
    {
        $this->is_admin();
        $this->output_json($this->users->getDataUsers($id), false);
    }

    public function index()
    {
        $this->is_allowed('admin');
        $this->table_assets(true);
        $data['user'] = $this->user;
        $this->breadcrumbs->push('Users', '/users');
        $this->template->title = 'User Management';
        $this->template->javascript->add('partial/js/halaman/users.js');
        $this->template->content->view('index', $data);
        $this->template->publish();
    }
    public function cari_level_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->users->get_level_type();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->name];
            }
            echo json_encode($json);
        }
    }
    public function edit()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $result = $this->users->get_user($id)->row();
            $this->output_json(['status' => TRUE, 'result' => $result]);
        }
    }
    public function save()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $mode = $this->input->post('mode', true);
            $this->_rules($mode);
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'username'  => form_error('username'),
                    'full_name' => form_error('full_name'),
                    'email'     => form_error('email'),
                    'level[]'   => form_error('level[]'),
                );
                $data       = ['status' => FALSE, 'errors' => $errors];
            } else {
                $username   = $this->input->post('username');
                $password   = $this->input->post('username');
                $nama       = explode(' ', $this->input->post('full_name'));
                $first_name = $nama[0];
                // $last_name  = end($nama);
                $last_name  = isset($nama[1]) ? $nama[1] : '';

                $email      = $this->input->post('email');
                $group      = $this->input->post('level');

                $data = array(
                    'username'   => $username,
                    'first_name' => $first_name,
                    'last_name'  => $last_name,
                    'company'    => 'Universitas Abdurrab',
                    'phone'      => '--',
                    'img_name'   => 'default.png'
                );
                if ($mode == 'add') {
                    $this->ion_auth->register($username, $password, $email, $data, $group);
                } else {
                    $id = $this->input->post('id');
                    $data['email'] = $email;
                    $data['active'] = $this->input->post('status');
                    unset($data['company']);
                    unset($data['phone']);
                    if (isset($group) && !empty($group)) {
                        $this->ion_auth->remove_from_group('', $id);
                        foreach ($group as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                    $this->ion_auth->update($id, $data);
                }
                $data = ['status' => TRUE];
            }
            $this->output->set_content_type('application/json')
                ->set_output(json_encode(array_merge($this->send_json, $data)));
        }
    }
    public function delete($id)
    {
        $this->is_admin();
        $data['status'] = $this->ion_auth->delete_user($id) ? true : false;
        $this->output_json($data);
    }
    public function _rules($mode)
    {
        $email_unique = '';
        $username_unique = '';
        if ($mode == 'add') {
            $email_unique = '|is_unique[' . $this->tables['users'] . '.email]';
            $username_unique = '|is_unique[' . $this->tables['users'] . '.username]';
        } else {
            // $getData = $this->admin->get_users($this->input->post('id'))->row();
            $getData = $this->db->get_where('users', array('id' => $this->input->post('id')))->row();
            if ($this->input->post('email') != $getData->email) {
                $email_unique = '|is_unique[' . $this->tables['users'] . '.email]';
            }
            if ($this->input->post('username') != $getData->username) {
                $username_unique = '|is_unique[' . $this->tables['users'] . '.username]';
            }
        }
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]' . $username_unique);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $email_unique);
        $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
        $this->form_validation->set_rules('level[]', 'Level', 'required');

        $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
        $this->form_validation->set_message('min_length', '{field} minimal 5 karakter');
        $this->form_validation->set_message('is_unique', '{field} ini sudah dipakai, silahkan ganti');
        $this->form_validation->set_message('valid_email', '{field} tidak valid');
    }
    public function username_check()
    {
        $post = $this->input->post(null, TRUE);
        $query = $this->db->query("SELECT * FROM users WHERE username = '$post[username]' ");
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('username_check', '{field} ini sudah dipakai, silahkan ganti');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    private function table_assets($button = false)
    {
        $this->template->stylesheet->add('partial/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css');
        $this->template->stylesheet->add('partial/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css');
        $this->template->stylesheet->add('partial/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css');
        $this->template->javascript->add('partial/libs/datatables.net/js/jquery.dataTables.min.js');
        $this->template->javascript->add('partial/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js');
        if ($button) {
            // button
            $this->template->javascript->add('partial/libs/datatables.net-buttons/js/dataTables.buttons.min.js');
            $this->template->javascript->add('partial/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js');
            $this->template->javascript->add('partial/libs/jszip/jszip.min.js');
            $this->template->javascript->add('partial/libs/pdfmake/build/pdfmake.min.js');
            $this->template->javascript->add('partial/libs/pdfmake/build/vfs_fonts.js');
            $this->template->javascript->add('partial/libs/datatables.net-buttons/js/buttons.html5.min.js');
            $this->template->javascript->add('partial/libs/datatables.net-buttons/js/buttons.print.min.js');
            $this->template->javascript->add('partial/libs/datatables.net-buttons/js/buttons.colVis.min.js');
        }

        $this->template->stylesheet->add('partial/libs/select2/css/select2.min.css');
        $this->template->javascript->add('partial/libs/select2/js/select2.full.min.js');
    }
    // ======== Group Management ================
    public function group()
    {
        $this->is_allowed('admin');
        $this->table_assets();
        $data['user'] = $this->user;
        $this->breadcrumbs->push('Users', '/users');
        $this->breadcrumbs->push('Groups', '/users/group');

        $this->template->title = 'Group Management';
        $this->template->javascript->add('partial/js/halaman/group.js');
        $this->template->content->view('group', $data);
        $this->template->publish();
    }
    public function data_group($id = null)
    {
        $this->is_admin();
        $this->output_json($this->users->getDataGroups($id), false);
    }
    public function save_group()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $mode = $this->input->post('mode', true);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
            $this->form_validation->set_rules('description', 'description', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'name'  => form_error('name'),
                    'description' => form_error('description'),
                );
                $data = ['status' => FALSE, 'errors' => $errors];
            } else {

                if ($mode == 'add') {
                    $data = $this->users->addGroup();
                } else {
                    $data = $this->users->editGroup();
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
    public function edit_group()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $result = $this->users->get_group($id)->row();
            $this->output_json(['status' => TRUE, 'result' => $result]);
        }
    }
    public function delete_group($id)
    {
        $this->is_admin();
        if ($this->input->is_ajax_request()) {
            $data['status'] = $this->db->delete('groups', ['id' => $id]) ? true : false;
            $this->output_json($data);
        }
    }
}

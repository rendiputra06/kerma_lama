<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->user = $this->ion_auth->user()->row();
        $this->load->model('Setting_model', 'setting');
    }

    public function index()
    {
        $this->is_allowed('admin');
        $this->template->title = 'Settings';
        $this->breadcrumbs->push('Settings', '/settings');
        $this->template->stylesheet->add('partial/libs/dropify/css/dropify.min.css');
        $this->template->javascript->add('partial/libs/dropify/js/dropify.min.js');
        $this->template->javascript->add('partial/js/halaman/setting.js');
        $data['general'] = convert_setting_data($this->db->get('setting')->result());
        $this->template->content->view('index', $data);
        $this->template->publish();
    }

    public function save()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $this->_rules();
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'system_name'  => form_error('system_name'),
                    'system_title' => form_error('system_title'),
                    'system_email' => form_error('system_email'),
                    'address'      => form_error('address'),
                );
                $data       = ['status' => FALSE, 'errors' => $errors];
            } else {
                $this->setting->update_setting();
                $data = ['status' => TRUE, 'cek' => $_POST];
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
    public function _rules()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('system_name', 'Nama Sistem', 'trim|required');
        $this->form_validation->set_rules('system_title', 'Title Sistem', 'trim|required');
        $this->form_validation->set_rules('system_email', 'Default Email', 'trim|required');
        $this->form_validation->set_rules('address', 'Alamat', 'trim|required');

        $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
    }

    public function save_logo()
    {
        $file_name = $this->_do_upload();
        $this->setting->logo_change($file_name);
        $data = ['status' => TRUE];
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    private function _do_upload()
    {
        $config['upload_path'] = 'partial/images/logo'; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|svg'; //type yang dapat diakses bisa anda sesuaikan
        $config['max_size']      = 1000;
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('filefoto')) //upload and validate
        {
            $hasil['status'] = false;
            $hasil['pesan'] = $this->upload->display_errors();
            echo json_encode($hasil);
            exit();
        }
        return $this->upload->data('file_name');
    }
}

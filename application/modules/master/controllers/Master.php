<?php defined('BASEPATH') or exit('No direct script access allowed');

class Master extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user = $this->ion_auth->user()->row();
        $this->form_validation->CI = &$this;
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->load->model('Master_model', 'master');
        $this->load->library('datatables'); // Load Library Ignited-Datatables
        $this->tables = $this->config->item('tables', 'ion_auth');
    }
    public function index()
    {
        redirect('master/jenis_kerma');
    }
    public function jenis_kerma()
    {
        $this->is_allowed();
        $this->_assets_table();
        $this->template->title = 'Jenis Mitra';
        $this->breadcrumbs->push('Jenis', '/master/jenis_kerma');
        $this->template->javascript->add('partial/js/kerma/master/jenis.js');
        $this->template->content->view('index');
        $this->template->publish();
    }
    public function data_jenis_kerma($id = null)
    {
        $this->_json($this->master->getDataJenis($id), false);
    }
    public function save_jenis()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $mode = $this->input->post('mode', true);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
            $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'nama'     => form_error('nama'),
                );
                $data = ['status' => FALSE, 'errors' => $errors];
            } else {
                if ($mode == 'add') {
                    $data = $this->master->insert_jenis();
                } else {
                    $data = $this->master->update_jenis();
                }
                // $data = ['status' => TRUE, 'slug' => $slug];
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
    public function edit_jenis()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $data = $this->db->get_where('kerma_jenis', ['id' => $id])->row();
            $this->_json(['status' => TRUE, 'data' => $data], TRUE);
        }
    }
    public function delete_jenis()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $this->db->delete('kerma_jenis', ['id' => $id]);
            $this->_json(['status' => TRUE], TRUE);
        }
    }
    // Data Master Unit
    public function unit()
    {
        $this->is_allowed();
        $this->_assets_table();
        $this->template->title = 'Data Master Unit';
        $this->breadcrumbs->push('Unit', '/master/unit');
        $this->template->javascript->add('partial/js/kerma/master/unit.js');
        $this->template->content->view('unit');
        $this->template->publish();
    }
    public function data_unit()
    {
        if ($this->input->is_ajax_request()) {
            $this->_json($this->master->getDataUnit(), false);
        }
    }
    public function save_unit()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $mode = $this->input->post('mode', true);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('nm_unit', 'Nama Unit', 'trim|required');
            $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'nm_unit'     => form_error('nm_unit'),
                );
                $data = ['status' => FALSE, 'errors' => $errors];
            } else {
                if ($mode == 'add') {
                    $data = $this->master->insert_unit();
                } else {
                    $data = $this->master->update_unit();
                }
                // $data = ['status' => TRUE, 'slug' => $slug];
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
    public function edit_unit()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $data = $this->db->get_where('kerma_unit', ['id' => $id])->row();
            $this->_json(['status' => TRUE, 'data' => $data], TRUE);
        }
    }
    public function delete_unit()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $this->db->delete('kerma_unit', ['id' => $id]);
            $this->_json(['status' => TRUE], TRUE);
        }
    }
    public function get_unit_siakad()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Siakad_model', 'siakad');
            $prodi = $this->siakad->get_jurusan()->result();
            $this->_json(['status' => TRUE, 'prodi' => $prodi], TRUE);
        }
    }
    public function data_siakad()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Siakad_model', 'siakad');
            $this->_json($this->siakad->getDataProdi(), false);
        }
    }
    public function data_prodi()
    {
        if ($this->input->is_ajax_request()) {
            $prodi = $this->master->get_id_unit()->result_array();
            $this->_json(['prodi' => $prodi]);
        }
    }
    public function ajaxImport()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('Siakad_model', 'siakad');
            $id = $this->input->post('id');
            $data = $this->siakad->get_prodi($id)->row();
            $insert = array(
                'id_sms' => $data->id_sms,
                'nm_unit' => $data->nm_lemb,
                'id_jenj_didik' => $data->id_jenj_didik,
            );
            $this->db->insert('kerma_unit', $insert);
            $this->_json(['status' => TRUE, 'data' => $data]);
        }
    }
    //  data untuk pengguna
    public function tendik()
    {
        $this->is_allowed();
        $this->_assets_table();
        $this->template->title = 'Data Tendik';
        $this->breadcrumbs->push('Tendik', '/master/tendik');
        $this->template->javascript->add('partial/js/kerma/master/tendik.js');
        $this->template->content->view('tendik');
        $this->template->publish();
    }
    public function get_data_tendik()
    {
        $this->ajax_only();
        $this->_json($this->master->get_data_tendik(), false);
    }
    public function save_tendik()
    {
        $this->ajax_only();
        $email_unique = '';
        $mode = $this->input->post('mode', true);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        if ($mode == 'add') {
            $email_unique = '|is_unique[' . $this->tables['users'] . '.email]';
        } else {
            $getData = $this->master->getEmailTendik($this->input->post('id'))->row();
            if ($this->input->post('email') != $getData->email) {
                $email_unique = '|is_unique[' . $this->tables['users'] . '.email]';
            }
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $email_unique);
        $this->form_validation->set_rules('unit_id', 'Unit Pelaksana', 'trim|required');
        $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
        $this->form_validation->set_message('is_unique', '%s sudah di pakai, silahkan diganti');
        $this->form_validation->set_message('valid_email', '{field} tidak valid');
        $data = [];
        if ($this->form_validation->run() == FALSE) {
            $errors = array(
                'nama'   => form_error('nama'),
                'email' => form_error('email'),
                'unit_id' => form_error('unit_id'),
            );
            $data = ['status' => FALSE, 'errors' => $errors];
        } else {
            if ($mode == 'add') {
                $data = $this->master->insert_tendik();
                // $data = ['status' => TRUE];
            } else {
                $data = $this->master->update_tendik();
            }
        }
        $this->_json($data);
    }
    public function editTendik()
    {
        $this->ajax_only();
        $id = $this->input->post('id');
        $data = $this->db->get_where('kerma_tendik', ['id' => $id])->row();
        $this->_json(['status' => TRUE, 'data' => $data], TRUE);
    }
    public function hapusTendik()
    {
        $this->ajax_only();
        $id = $this->input->post('id');
        $this->db->delete('kerma_tendik', ['id' => $id]);
        $this->ion_auth->delete_user($id);
        $this->_json(['status' => TRUE], TRUE);
    }
}

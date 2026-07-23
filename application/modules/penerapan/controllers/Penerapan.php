<?php defined('BASEPATH') or exit('No direct script access allowed');

class Penerapan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user = $this->ion_auth->user()->row();
        $this->form_validation->CI = &$this;
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->load->model('Penerapan_model', 'penerapan');
        $this->load->library('datatables'); // Load Library Ignited-Datatables
    }
    public function index()
    {
        $this->is_allowed();
        $this->_assets_table(TRUE);
        $this->template->title = 'Implementasi Kerja Sama';
        $this->breadcrumbs->push('Impelementasi', '/penerapan/index');
        $this->template->stylesheet->add('partial/libs/select2/css/select2.min.css');
        $this->template->stylesheet->add('partial/libs/dropify/css/dropify.min.css');
        $this->template->javascript->add('partial/libs/select2/js/select2.full.min.js');
        $this->template->javascript->add('partial/libs/dropify/js/dropify.min.js');
        $this->template->javascript->add('partial/js/kerma/penerapan.js');
        $data['prodi'] = null;
        if ($this->ion_auth->in_group('prodi')) {
            $data['prodi'] = $this->penerapan->get_user_prodi($this->user->id_tendik);
        }
        $this->template->content->view('index', $data);
        $this->template->publish();
    }
    public function data_penerapan($id = null)
    {
        if ($this->input->is_ajax_request()) {
            $this->_json($this->penerapan->getDataPenerapan($id), false);
        }
    }
    public function save()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $mode = $this->input->post('mode', true);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
            $this->form_validation->set_rules('unit_id', 'Unit Pelaksana', 'trim|required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
            $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'judul'   => form_error('judul'),
                    'unit_id' => form_error('unit_id'),
                    'tanggal' => form_error('tanggal'),
                );
                $data = ['status' => FALSE, 'errors' => $errors];
            } else {
                if ($mode == 'add') {
                    $dokumen = $this->_upload_dokumen();
                    $data = $this->penerapan->insert_data($dokumen);
                } else {
                    $id = $this->input->post('id');
                    $old_penerapan = $this->penerapan->get_penerapan($id)->row();
                    if (isset($_FILES['dokumen']['name']) && $_FILES['dokumen']['name'] != '') {
                        // hapus file yang lama
                        if (file_exists('uploads/penerapan/' . $old_penerapan->dokumen) && $old_penerapan->dokumen) {
                            unlink('uploads/penerapan/' . $old_penerapan->dokumen);
                        }
                        $dokumen = $this->_upload_dokumen();
                    } else {
                        $dokumen = $old_penerapan->dokumen;
                    }
                    $data = $this->penerapan->update_data($dokumen);
                }
            }
            $this->_json($data);
        }
    }
    private function _upload_dokumen()
    {
        $config['upload_path'] = 'uploads/penerapan'; //path folder
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('dokumen')) //upload and validate
        {
            $hasil = array(
                'status_file' => FALSE,
                'msg' => $this->upload->display_errors()
            );
        }
        return $this->upload->data('file_name');
    }
    public function editAjax()
    {
        if ($this->input->is_ajax_request()) {
            $this->_json($this->penerapan->editAjax());
        }
    }
    public function hapusAjax()
    {
        $this->ajax_only();
        $id = $this->input->post('id');
        $penerapan = $this->penerapan->get_penerapan($id)->row();
        if (file_exists('uploads/penerapan/' . $penerapan->dokumen) && $penerapan->dokumen) {
            unlink('uploads/penerapan/' . $penerapan->dokumen);
        }
        $this->db->delete('kerma_penerapan', ['id' => $id]);
        $this->_json(['status' => TRUE]);
    }
    public function cari_unit_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->penerapan->get_unit_select2();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->nm_unit];
            }
            // echo json_encode($json);
            $this->_json($json);
        }
    }
}

<?php defined('BASEPATH') or exit('No direct script access allowed');

class Panduan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user = $this->ion_auth->user()->row();
        $this->form_validation->CI = &$this;
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->load->model('Panduan_model', 'panduan');
        $this->load->library('datatables'); // Load Library Ignited-Datatables
    }
    public function index($mode = null)
    {
        $this->is_allowed();
        $this->template->title = 'Panduan Kerja Sama';
        $this->breadcrumbs->push('Panduan', '/panduan');
        if ($mode == 'grid') {
            $data['panduan'] = $this->panduan->get_Panduan()->result();
            $this->template->content->view('grid', $data);
        } else {
            $this->_assets_table(TRUE);
            $this->template->content->view('index');
        }
        $this->template->stylesheet->add('partial/libs/dropify/css/dropify.min.css');
        $this->template->javascript->add('partial/libs/dropify/js/dropify.min.js');
        $this->template->javascript->add('partial/js/kerma/panduan.js');
        $this->template->publish();
    }

    public function data($id = null)
    {
        $this->_json($this->panduan->getDataPanduan($id), false);
    }
    public function save()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $mode = $this->input->post('mode', true);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
            $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
            $this->form_validation->set_message('required', '%s masih kosong, silahkan isi');
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'judul'     => form_error('judul'),
                    'deskripsi' => form_error('deskripsi'),
                    'tanggal'   => form_error('tanggal'),
                );
                $data = ['status' => FALSE, 'errors' => $errors];
            } else {
                if ($mode == 'add') {
                    $files_name = array('cover' =>  $this->_upload_cover(), 'dokumen' => $this->_upload_dokumen());
                    $data = $this->panduan->insert_data($files_name);
                } else {
                    $id = $this->input->post('id');
                    $cover = '';
                    $dokumen = '';
                    $old_panduan = $this->panduan->get_Panduan($id)->row();
                    if (isset($_FILES['cover']['name']) && $_FILES['cover']['name'] != '') {
                        // hapus file yang lama
                        if (file_exists('uploads/kerma/' . $old_panduan->cover) && $old_panduan->cover) {
                            unlink('uploads/kerma/' . $old_panduan->cover);
                        }
                        $cover = $this->_upload_cover();
                    } else {
                        $cover = $old_panduan->cover;
                    }
                    if (isset($_FILES['dokumen']['name']) && $_FILES['dokumen']['name'] != '') {
                        // hapus file yang lama
                        if (file_exists('uploads/kerma/' . $old_panduan->dokumen) && $old_panduan->dokumen) {
                            unlink('uploads/kerma/' . $old_panduan->dokumen);
                        }
                        $dokumen = $this->_upload_dokumen();
                    } else {
                        $dokumen = $old_panduan->dokumen;
                    }
                    $data = $this->panduan->update_data(['cover' => $cover, 'dokumen' => $dokumen]);
                }
            }
            $this->_json($data);
        }
    }
    private function _upload_cover()
    {

        $config['upload_path'] = 'uploads/panduan'; //path folder
        // $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
        $config['allowed_types'] = '*';
        $config['encrypt_name'] = TRUE; //nama yang terupload nantinya

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('cover')) //upload and validate
        {
            $hasil = array(
                'status_file' => FALSE,
                'msg' => $this->upload->display_errors()
            );
        }
        return $this->upload->data('file_name');
    }
    private function _upload_dokumen()
    {
        $config['upload_path'] = 'uploads/panduan'; //path folder
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
            $id = $this->input->post('id');
            $data = $this->panduan->get_Panduan($id)->row();
            $this->_json(['status' => TRUE, 'data' => $data], TRUE);
        }
    }
    public function hapusAjax()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $panduan = $this->panduan->get_Panduan($id)->row();
            if (file_exists('uploads/panduan/' . $panduan->cover) && $panduan->cover) {
                unlink('uploads/panduan/' . $panduan->cover);
            }
            if (file_exists('uploads/panduan/' . $panduan->dokumen) && $panduan->dokumen) {
                unlink('uploads/panduan/' . $panduan->dokumen);
            }
            $this->db->delete('kerma_panduan', ['id' => $id]);
            $this->_json(['status' => TRUE]);
        }
    }
}

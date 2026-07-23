<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->user = $this->ion_auth->user()->row();
        $this->form_validation->CI = &$this;
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->load->model('Kegiatan_model', 'kegiatan');
        $this->load->library('datatables'); // Load Library Ignited-Datatables
    }
    public function index($mode = null)
    {
        $this->is_allowed();
        $this->template->title = 'Kegiatan Kerja Sama';
        $this->breadcrumbs->push('Kegiatan', '/kegiatan');
        if (!$this->ion_auth->is_admin()) {
            $data['user_id'] = $this->user->id;
            $kegiatan = $this->kegiatan->get_kegiatan_grid($this->user->id)->result();
        } else {
            $data['user_id'] = null;
            $kegiatan = $this->kegiatan->get_kegiatan_grid()->result();
        }
        if ($mode == 'grid') {
            $data['kegiatan'] = $kegiatan;
            $this->template->content->view('grid', $data);
        } else {
            $this->_assets_table(TRUE);
            $this->template->content->view('index', $data);
        }
        $this->template->stylesheet->add('partial/libs/dropify/css/dropify.min.css');
        $this->template->javascript->add('partial/libs/dropify/js/dropify.min.js');
        $this->template->javascript->add('partial/js/kerma/kegiatan.js');
        $this->template->publish();
    }

    public function data($id = null)
    {
        $this->_json($this->kegiatan->getDatakegiatan($id), false);
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
                    $cover = $this->_upload_cover();
                    $data = $this->kegiatan->insert_data($cover, $this->user->id);
                } else {
                    $id = $this->input->post('id');
                    $cover = '';
                    $old_kegiatan = $this->kegiatan->get_kegiatan($id)->row();
                    if (isset($_FILES['cover']['name']) && $_FILES['cover']['name'] != '') {
                        // hapus file yang lama
                        if (file_exists('uploads/kegiatan/' . $old_kegiatan->cover) && $old_kegiatan->cover) {
                            unlink('uploads/kegiatan/' . $old_kegiatan->cover);
                        }
                        $cover = $this->_upload_cover();
                    } else {
                        $cover = $old_kegiatan->cover;
                    }
                    $data = $this->kegiatan->update_data($cover);
                }
            }
            $this->_json($data);
        }
    }
    private function _upload_cover()
    {

        $config['upload_path'] = 'uploads/kegiatan'; //path folder
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
    public function editAjax()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $data = $this->kegiatan->get_kegiatan($id)->row();
            $this->_json(['status' => TRUE, 'data' => $data], TRUE);
        }
    }
    public function hapusAjax()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $kegiatan = $this->kegiatan->get_kegiatan($id)->row();
            if (file_exists('uploads/kegiatan/' . $kegiatan->cover) && $kegiatan->cover) {
                unlink('uploads/kegiatan/' . $kegiatan->cover);
            }
            $this->db->delete('kerma_kegiatan', ['id' => $id]);
            $this->_json(['status' => TRUE]);
        }
    }
}

<?php defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->lang->load('auth');
		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);
		$this->user = $this->ion_auth->user()->row();
		$this->form_validation->CI = &$this;
		$this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
	}
	public function index()
	{
		$this->is_allowed();
		$this->template->title = 'Profile';
		$this->breadcrumbs->push('Profile', '/profile');
		$this->template->stylesheet->add('partial/libs/dropify/css/dropify.min.css');
		$this->template->javascript->add('partial/libs/dropify/js/dropify.min.js');
		$this->template->javascript->add('partial/js/halaman/profile.js');
		$data['user'] = $this->user;
		$data['group'] = $this->ion_auth->get_users_groups()->row();
		$this->template->content->view('index', $data);
		$this->template->publish();
	}
	public function save()
	{
		if ($this->input->is_ajax_request()) {
			$data = array();
			$mode = $this->input->post('mode', true);
			$this->form_validation->set_error_delimiters('', '');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$errors = array(
					'first_name' => form_error('first_name'),
					'username'   => form_error('username'),
					'email' 	 => form_error('email'),
					'phone'		 => form_error('phone'),
				);
				$data = ['status' => FALSE, 'errors' => $errors];
			} else {
				$id = $this->input->post('id');
				$update = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'username'   => $this->input->post('username'),
					'email' 	 => $this->input->post('email'),
					'phone'		 => $this->input->post('phone'),
				);
				$this->ion_auth->update($id, $update);
				$data = ['status' => TRUE, 'cek' => $_POST];
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
	public function save_photo()
	{
		$id = $this->input->post('id');
		$file_name = $this->_do_upload();
		$this->ion_auth->update($id, ['img_name' => $file_name]);
		$data = ['status' => TRUE];
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}
	private function _do_upload()
	{
		$config['upload_path'] = 'partial/images/users'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
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
	public function change_password()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('passold', 'Password Lama', 'trim|required|callback_cek');
		$this->form_validation->set_rules('passnew', 'Password Baru', 'trim|required|min_length[4]|callback_cek_lagi');
		$this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'trim|required|matches[passnew]');
		$this->form_validation->set_message('required', 'Data {field} belum di isi');
		$this->form_validation->set_message('matches', 'Data {field} tidak cocok');
		$this->form_validation->set_message('min_length', '{field} Minimal masukkan 4 angka');
		$this->form_validation->set_message('cek', '{field} Salah');
		$this->form_validation->set_message('cek_lagi', '{field} Tidak Boleh Sama dengan Password Lama');
		$data = array();
		if ($this->form_validation->run() == FALSE) {
			$errors = array(
				'passold'     => form_error('passold'),
				'passnew'     => form_error('passnew'),
				'passconf'    => form_error('passconf'),
			);
			$data = array(
				'status'         => FALSE,
				'errors'         => $errors,
			);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		} else {
			$identity = $this->session->userdata('email');
			$old = $this->input->post('passold');
			$new = $this->input->post('passnew');
			if ($this->ion_auth->change_password($identity, $old, $new)) {
				$data['status'] = TRUE;
			}
			$data['cek'] = $this->ion_auth->errors();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
	public function cek($data)
	{
		return $this->ion_auth
			->hash_password_db($this->user->id, $data) ? TRUE : FALSE;
	}
	function cek_lagi($data)
	{
		return $this->ion_auth
			->hash_password_db($this->user->id, $data) ? FALSE : TRUE;
	}
}

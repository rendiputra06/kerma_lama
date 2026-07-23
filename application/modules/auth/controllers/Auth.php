<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
	public $data = [];
	function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->library('email');
		$this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));

		// Include the google api php libraries
		// $this->load->model('google_oauth_model'); // modular model
		$this->load->config('auth/google_config'); // modular config
		$this->load->config('auth/email'); // modular email

		include_once APPPATH . "libraries/Google/Google_Client.php";
		include_once APPPATH . "libraries/Google/contrib/Google_Oauth2Service.php";
	}

	private function output_json($data)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function login2()
	{
		if ($this->ion_auth->logged_in()) {
			$user_id = $this->ion_auth->user()->row()->id; // Get User ID
			$group = $this->ion_auth->get_users_groups($user_id)->row()->name; // Get user group
			redirect('beranda');
		}
		$this->data['identity'] = [
			'name' => 'identity',
			'id' => 'identity',
			'type' => 'text',
			'placeholder' => 'Email',
			'autofocus'	=> 'autofocus',
			'class' => 'form-control',
			'autocomplete' => 'off'
		];
		$this->data['password'] = [
			'name' => 'password',
			'id' => 'password',
			'type' => 'password',
			'placeholder' => 'Password',
			'class' => 'form-control',
		];

		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->load->view('tampilan_login/_header');
		$this->load->view('tampilan_login/index', $this->data);
		$this->load->view('tampilan_login/_footer');
	}

	public function cek_login()
	{
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required|trim');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required|trim');

		if ($this->form_validation->run() === TRUE) {
			$remember = (bool)$this->input->post('remember');
			// check by email
			$login = $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember);
			if (!$login) {
				$this->ion_auth_model->identity_column = 'username';

				// check by username
				$login = $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember);
			}
			if ($login) {
				$this->cek_akses();
			} else {
				$data = [
					'status' => false,
					'failed' => 'Incorrect Login',
					'post' => $_POST,
				];
				$this->output_json($data);
			}
		} else {
			$invalid = [
				'identity' => form_error('identity'),
				'password' => form_error('password')
			];
			$data = [
				'status' 	=> false,
				'invalid' 	=> $invalid
			];
			$this->output_json($data);
		}
	}

	public function cek_akses()
	{
		if (!$this->ion_auth->logged_in()) {
			$status = false; // jika false, berarti login gagal
			$url = 'auth'; // url untuk redirect
		} else {
			$status = true; // jika true maka login berhasil
			$url = 'beranda';
		}

		$data = [
			'status' => $status,
			'url'	 => $url
		];
		$this->output_json($data);
	}

	function activation_user($id, $active_code)
	{
		// get oAuth data from session 'google'
		$google = $this->session->userdata('google');
		$users = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();

		if ($active_code == $users['active_code']) {
			$activation_user = $this->ion_auth->google_activate($id);
		} else {
			redirect('activation', 'refresh');
		}

		if ($activation_user) {
			// Email notif
			$email_content = '<h2>Hello, <b>' . ucfirst($users['first_name']) . ' ' . ucfirst($users['last_name']) . '</b></h2>';
			$email_content .= '<p>Thank you, your account has been <b>activated</b> !<br>';
			$email_content .= 'Enjoy and have a nice day!</p>';
			email_send($users['email'], 'Activation Completed', $email_content);

			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('type', 'success');
			redirect('home', 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->session->set_flashdata('type', 'error');
			redirect('login', 'refresh');
		}
	}

	function activation()
	{
		$data['judul'] = "Activation";
		$data['deskripsi'] = "CIA HMVC";

		// get oAuth data from session 'google'
		$google = $this->session->userdata('google');

		if (isset($google)) {

			$this->form_validation->set_rules('active_code', 'Activation Code', 'required');
			$users = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();

			$id = $users['id'];
			$active_code = $users['active_code'];
			$code = $this->input->post('active_code');

			if ($this->form_validation->run() == true) {
				if ($code == $active_code || $active_code == 1) {
					$this->ion_auth->google_activate($id);

					// Email notif
					$email_content = '<h2>Hello, <b>' . ucfirst($users['first_name']) . ' ' . ucfirst($users['last_name']) . '</b></h2>';
					$email_content .= '<p>Thank you, your account has been <b>activated</b> !<br>';
					$email_content .= 'You can now sign in using your <b>Google Account</b></p>';
					email_send($users['email'], 'Activation Completed', $email_content);

					// notification if success
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->session->set_flashdata('type', 'success');
					redirect('activation');
				} else {
					// notification if failed
					$this->session->set_flashdata('message', 'The Activation Code is invalid');
					$this->session->set_flashdata('type', 'error');
					redirect('activation');
				}
			} else {
				// validation notification
				$data['message'] = warning_msg(validation_errors());

				// pass the user to the view
				$data['authURL'] = $google['authURL']; // Google Login URL
				$data['identity'] = $users['email'];
				$data['activation'] = $users['activation'];
				$data['id'] = $users['id'];
				$data['active_code'] = array(
					'name' => 'active_code',
					'id'   => 'active_code',
					'type' => 'text',
					'class' => 'form-control',
					'placeholder' => 'Activation Code',
					'value' => $code,
				);
				$this->_render_page('auth/activation', $data);
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	function generate($id)
	{
		$data['title'] = "Generate Code";

		// get oAuth data from session 'google'
		$google = $this->session->userdata('google');

		if (isset($google)) {
			$users = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();

			$id = $users['id'];
			if ($users['activation'] == 1) {
				redirect('home', 'refresh');
			} else {
				$this->ion_auth->generate_activation($id);

				// Get new code
				$new_code = $this->db->where(array('email' => $google['email']))->limit(1)->get('users')->row_array();;

				$email_content = '<h2>Hello, <b>' . ucfirst($users['first_name']) . ' ' . ucfirst($users['last_name']) . '</b></h2>';
				$email_content .= '<p>Below is the the <i>activation code</i> that you just requested</p>';
				$email_content .= '<h3><b>' . $new_code['active_code'] . '</b></h3>';
				$email_content .= '<p>You can paste the code to the activation page</p>';
				$email_content .= '<p><b>- OR -</b></p>';
				$email_content .= '<p>You can click URL below to activate and login directly<br>';
				$email_content .= '<b>' . anchor('activation/user/' . $users['id'] . '/' . $new_code['active_code']) . '</b></p>';

				email_send($users['email'], 'Activation Code Request', $email_content);

				// notification if sgenerate uccess
				$this->session->set_flashdata('message', 'Generate Code has been sent to your email at <b>' . $users['email'] . '</b><br>Please check your <b>inbox</b> !');
				$this->session->set_flashdata('type', 'success');
				redirect('activation');
			}
		} else {
			redirect('login', 'refresh');
		}
	}

	// cancel google register
	function clear()
	{
		$this->session->unset_userdata('token');
		$this->session->unset_userdata('google');
		ob_end_clean();
		redirect('login', 'refresh');
	}

	// log the user out
	function logout()
	{
		$data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		if ($logout) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('type', 'success');
		} else {
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->session->set_flashdata('type', 'error');
		}

		$this->session->unset_userdata('token');
		$this->session->unset_userdata('google');
		$this->session->unset_userdata('userData');

		ob_end_clean();
		redirect('login', 'refresh');
	}

	// forgot password
	function forgot_password()
	{
		// setting validation rules by checking wheather identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false) {
			$data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
			);

			if ($this->config->item('identity', 'ion_auth') != 'email') {
				$data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			} else {
				$data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth/forgot_password', $data);
		} else {
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity)) {

				if ($this->config->item('identity', 'ion_auth') != 'email') {
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				} else {
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten) {
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('login', 'refresh'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code) {
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user) {
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false) {
				// display the form

				// set the flash data error message if there is one
				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
				);
				$data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
				);
				$data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$data['csrf'] = $this->_get_csrf_nonce();
				$data['code'] = $code;

				// render
				$this->_render_page('auth/reset_password', $data);
			} else {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));
				} else {
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change) {
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect('login', 'refresh');
					} else {
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		} else {
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	// activate the user
	function activate($id, $code = false)
	{
		if ($code !== false) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('type', 'success');
			redirect('users', 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->session->set_flashdata('type', 'error');
			redirect("auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	function deactivate($id = NULL)
	{
		// do we have the right userlevel?
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$deactivate = $this->ion_auth->deactivate($id);
		}

		if ($deactivate) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('type', 'success');
		} else {
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->session->set_flashdata('type', 'error');
		}

		// redirect them back to the auth page
		redirect('users', 'refresh');
	}
	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if (
			$this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')
		) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function _render_page($view, $data = null, $returnhtml = false) //I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html; //This will return html on 3rd argument being true
	}
}

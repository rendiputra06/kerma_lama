<?php defined('BASEPATH') or exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

class MY_Controller extends MX_Controller
{
	protected $data = array();
	public function __construct()
	{
		date_default_timezone_set('Asia/Jakarta');
		parent::__construct();
		$this->load->helper(array('url', 'form', 'file', 'directory', 'language', 'string', 'path', 'cookie', 'date'));
		$this->run_first();
		$this->send_json = array('token' => $this->security->get_csrf_hash());
	}

	private function run_first()
	{
		$data = $this->db->get('setting')->result();
		foreach ($data as $row) {
			$this->config->set_item($row->kunci, $row->nilai);
		}
	}

	public function is_allowed($group = null)
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('login', 'refresh');
		} else {
			if ($group != null) {
				// get user group
				if (!$this->ion_auth->in_group($group)) {
					redirect('beranda', 'refresh');
				} else {
					return false;
				}
			}
		}
	}
	public function _assets_table($button = false)
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
	public function _json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}
	public function ajax_only()
	{
		if (!$this->input->is_ajax_request()) {
			redirect('home/not_allowed');
		}
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */

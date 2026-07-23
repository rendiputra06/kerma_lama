<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Beranda extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
        $this->user = $this->ion_auth->user()->row();
        $this->load->model('beranda_model', 'beranda');
        $this->load->library('datatables');
    }

    public function index()
    {
        $this->is_allowed();
        $this->_assets_table();
        $this->template->title = 'Dashboard!';
        $this->template->stylesheet->add('partial/libs/chart.js/Chart.min.css');
        $this->template->javascript->add('partial/libs/chart.js/Chart.min.js');
        $this->template->javascript->add('partial/js/halaman/beranda.js');
        $this->template->content->view('beranda');
        $this->template->publish();
    }
    public function jenis_data()
    {
        if ($this->input->is_ajax_request()) {
            $this->_json($this->beranda->getJenisData(), false);
        }
    }
    public function get_chart()
    {
        $this->ajax_only();
        $data = $this->beranda->get_chart();
        $this->_json($data);
    }
}

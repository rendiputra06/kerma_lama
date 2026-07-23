<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Menu_model', 'menu');
        $this->load->library('form_validation');
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
    }
    private function output_json($data, $encode = true)
    {
        if ($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }
    public function index($flag = null)
    {
        $this->is_allowed('admin');
        $this->template->title = 'Menu';
        $this->load_libs();
        $flag           = $flag != null ? $flag : 'side-menu';
        $data['id']     = $this->menu->get_id_menu_type_by_flag($flag);
        $data['others'] = $this->db->where('name!= "side menu"')->get('menu_type')->result();
        $data['menu']   = $this->create_nestable(0, 1, 'side-menu', true);

        $this->template->content->view('index', $data);
        $this->template->publish();
    }
    private function load_libs()
    {
        $this->template->stylesheet->add('partial/libs/m-switch/css/style.css');
        $this->template->stylesheet->add('partial/libs/nestable/nesteable.css');
        $this->template->stylesheet->add('partial/libs/select2/css/select2.min.css');
        $this->template->javascript->add('partial/libs/select2/js/select2.full.min.js');
        $this->template->javascript->add('partial/libs/js/jquery.hotkeys.js');
        $this->template->javascript->add('partial/libs/nestable/jquery.nestable.js');
        $this->template->javascript->add('partial/libs/m-switch/js/jquery.mswitch.js');
        $this->template->javascript->add('partial/js/halaman/menu.js');
    }
    private function create_nestable($parent, $level, $menu_type, $ignore_active = false)
    {
        $menu_type_id = $this->menu->get_id_menu_type_by_flag($menu_type);
        $result = $this->db->query("SELECT a.id, a.label, a.type, a.active, a.link, Deriv1.Count FROM `navi` a  LEFT OUTER JOIN (SELECT parent, COUNT(*) AS Count FROM `navi` GROUP BY parent) Deriv1 ON a.id = Deriv1.parent WHERE a.menu_type_id = " . $menu_type_id . " AND a.parent=" . $parent . " " . ($ignore_active ? '' : 'and active = 1') . " order by `sort` ASC")->result();

        $ret = '';
        $display_menu_dropdown = function ($row = null) {
            return '<span class="dropdown float-end">
					    <a class="dropdown-toggle" type="button" data-toggle="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-cog"></i> <i class="mdi mdi-chevron-down"></i></a>
					    <div class="dropdown-menu">
					      <button class="removeMenu dropdown-item" data-id="' . $row->id . '">
                            <i class="fa fa-trash btn-action"></i> <span class="text-danger">Delete</span></button>
					      <button class="dropdown-item editMenu" data-id="' . $row->id . '">
                            <i class="fa fa-edit btn-action"></i> Edit</button> 
					      ' . ($row->type != 'label' ? '
					      <button class="dropdown-item addchildBtn" data-id="' . $row->id . '">
                            <i class="fas fa-level-down-alt btn-action"></i> Add child</button>
					      ' : '') . '
					    </div>
					  </span>';
        };
        if ($result) {
            $ret .= '<ol class="dd-list">';
            foreach ($result as $row) {
                if ($row->Count > 0) {
                    $ret .= '<li class="dd-item dd3-item ' . ($row->active ? '' : 'menu-toggle-activate_inactive') . ' menu-toggle-activate" data-id="' . $row->id . '" data-status="' . $row->active . '">';

                    if ($row->type != 'label') {
                        $ret .= '<div class="dd-handle dd3-handle dd-handles"></div>';
                        $ret .= '<div class="dd3-content">' . _ent($row->label);
                    } else {
                        $ret .= '<div class="dd-handle dd3-handle dd-handles dd-handle-label"></div>';
                        $ret .= '<div class="dd3-content "><b>' . _ent($row->label) . '</b>';
                    }
                    $ret .= $display_menu_dropdown($row);

                    $ret .= '</div>';
                    $ret .= $this->create_nestable($row->id, $level + 1, $menu_type, $ignore_active);
                    $ret .= "</li>";
                } elseif ($row->Count == 0) {
                    $ret .= '<li class="dd-item dd3-item ' . ($row->active ? '' : 'menu-toggle-activate_inactive') . ' menu-toggle-activate" data-id="' . $row->id . '" data-status="' . $row->active . '">';

                    if ($row->type != 'label') {
                        $ret .= '<div class="dd-handle dd3-handle dd-handles"></div>';
                        $ret .= '<div class="dd3-content">' . _ent($row->label);
                    } else {
                        $ret .= '<div class="dd-handle dd3-handle dd-handles dd-handle-label"></div>';

                        $ret .= '<div class="dd3-content  "><b>' . _ent($row->label) . '</b>';
                    }
                    $ret .= $display_menu_dropdown($row);
                    $ret .= '</div></li>';
                }
            }
            $ret .= "</ol>";
        }

        return $ret;
    }
    public function cari_parent_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->menu->get_parent();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->label];
            }
            echo json_encode($json);
        }
    }
    public function cari_group_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->menu->get_user_group();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->name];
            }
            echo json_encode($json);
        }
    }
    public function cari_menu_type_select2()
    {
        if ($this->input->is_ajax_request()) {
            $result = $this->menu->get_menu_type();
            $json = [];
            foreach ($result as $row) {
                $json[] = ['id' => $row->id, 'text' => $row->name];
            }
            echo json_encode($json);
        }
    }
    public function save()
    {
        if ($this->input->is_ajax_request()) {
            $data = array();
            $mode = $this->input->post('mode', true);
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('icon', 'Icon', 'required');
            $this->form_validation->set_rules('label', 'Label', 'required');
            $this->form_validation->set_rules('group[]', 'Group', 'required');
            $this->form_validation->set_message('required', '{field} Wajib diisi');
            if ($this->form_validation->run() == FALSE) {
                $errors = array(
                    'icon'  => form_error('icon'),
                    'label' => form_error('label'),
                    'group[]' => form_error('group[]'),
                );
                $data = array(
                    'status'     => FALSE,
                    'errors'     => $errors
                );
            } else {
                if ($mode == 'add') {
                    $data = $this->menu->addMenu();
                } else {
                    $data = $this->menu->editMenu();
                }
            }
            $this->output->set_content_type('application/json')
                ->set_output(json_encode($data));
        }
    }
    public function editMenu()
    {
        if ($this->input->is_ajax_request()) {
            $menu = $this->menu->get_menu($this->input->post('id'));
            $data = ['status' => TRUE, 'menu' => $menu->row()];
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
    public function delete()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            if ($this->db->delete('navi', ['id' => $id])) {
                $this->db->delete('navi_groups', ['navi_id' => $id]);
                $data = ['status' => TRUE];
            } else {
                $data = ['status' => FALSE];
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }
}

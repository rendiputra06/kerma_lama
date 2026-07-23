<?php

/*
 * Demo widget
 */
class Admin_menu extends Widget
{

    public function display()
    {
        $data['ret'] = $this->show_menu(0, 1);
        $this->view('widgets/admin/menu', $data);
    }

    private function is_allow($id)
    {
        $data =  $this->db->get_where('navi_groups', ['navi_id' => $id])->result();
        foreach ($data as $dt) {
            $cek[] = intval($dt->group_id);
        }
        return $this->ion_auth->in_group($cek) ? TRUE : FALSE;
    }

    public function show_menu($parent, $level, $menu_type_id = false)
    {
        if ($menu_type_id == false) {
            $menu_type_id = 1;
        }
        $result = $this->db->query("SELECT a.id, a.label,a.icon_color, a.type, a.link,a.icon, Deriv1.Count 
                FROM `navi` a  LEFT OUTER JOIN (SELECT parent, COUNT(*) AS Count 
                FROM `navi` GROUP BY parent) Deriv1 ON a.id = Deriv1.parent 
                WHERE a.menu_type_id = " . $menu_type_id . " AND a.parent=" . $parent . " and active = 1  order by `sort` ASC")->result();
        $ret = '';
        if ($result) {
            if (($level > 1) and ($parent > 0)) {
                $ret .= '<ul class="treeview-menu">';
            } else {
                $ret = '';
            }
            foreach ($result as $row) {
                // ambil group navi
                if ($this->is_allow($row->id)) {
                    // $perms      = 'menu_' . strtolower(str_replace(' ', '_', $row->label));
                    $links      = explode('/', $row->link);
                    $segments   = array_slice($this->uri->segment_array(), 0);


                    if (implode('/', $segments) == implode('/', $links)) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }

                    $link = filter_var($row->link, FILTER_VALIDATE_URL) ? $row->link : base_url($row->link);
                    if ($row->type == 'label') {
                        $ret .= '<li class="menu-title" data-key="t-menu">' . _ent($row->label) . '</li>';
                    } else {
                        if ($row->Count > 0) {
                            $ret .= '<li class="' . $active . ' "><a href="javascript: void(0);" class="has-arrow">';

                            if ($parent) {
                                $ret .= '<span data-key="t-' . _ent($row->label) . '">' . _ent($row->label) . '</span></a>';
                            } else {
                                $ret .= '<i data-feather="' . _ent($row->icon) . '"></i>
                                        <span data-key="t-' . _ent($row->label) . '">' . _ent($row->label) . '</span></a>';
                            }
                            $ret .= $this->show_menu($row->id, $level + 1, $menu_type_id);
                            $ret .= "</li>";
                        } elseif ($row->Count == 0) {
                            $ret .= '<li> <a href="' . $link . '" class="' . $active . '">';

                            if ($parent) {
                                $ret .= '<span data-key="t-' . _ent($row->label) . '">' . _ent($row->label) . '</span></a>';
                            } else {
                                $ret .= '<i data-feather="' . _ent($row->icon) . '"></i>
                                        <span data-key="t-' . _ent($row->label) . '">' . _ent($row->label) . '</span></a>';
                            }
                            $ret .= "</li>";
                        }
                    }
                }
            }
            if ($level != 1) {
                $ret .= '</ul>';
            }
        }
        return $ret;
    }
}

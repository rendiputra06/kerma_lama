<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting_model extends CI_Model
{
    public function update_setting()
    {
        $old_data = $this->db->get('setting')->result();
        foreach ($old_data as $od) {
            if ($this->input->post($od->kunci)) {
                $this->db->where('kunci', $od->kunci);
                $this->db->set('nilai', $this->input->post($od->kunci));
                $this->db->update('setting');
            }
        }
    }
    public function logo_change($filename)
    {
        $this->db->where('kunci', 'logo');
        $this->db->update('setting', ['nilai' => $filename]);
    }
}

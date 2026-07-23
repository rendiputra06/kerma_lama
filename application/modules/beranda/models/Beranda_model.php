<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Beranda_model extends CI_Model
{
    public function getJenisData()
    {
        $this->datatables->select('id,nama, (SELECT COUNT(id) FROM kerma WHERE kerma_jenis.id=kerma.jenis_id) as jumlah');
        $this->datatables->from('kerma_jenis');
        return $this->datatables->generate();
    }
    private function rand_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
    public function get_chart()
    {
        $this->db->select('id, nm_unit, (SELECT COUNT(id) FROM kerma WHERE kerma_unit.id=kerma.unit_id) as jumlah');
        $this->db->from('kerma_unit');
        $data = $this->db->get()->result();
        $trow = [];
        foreach ($data as $row) {
            $trow[] = array(
                'prodi' => $row->nm_unit,
                'value' => $row->jumlah,
                'color' => $this->rand_color()
            );
        }
        return $trow;
    }
}

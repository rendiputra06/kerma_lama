<?php

/*
 * Demo widget
 */
class Admin_ridebar extends Widget
{

    public function display($data)
    {

        if (!isset($data['items'])) {
            $data['items'] = array('Home', 'About', 'Contact');
        }

        $this->view('widgets/admin/ridebar', $data);
    }
}

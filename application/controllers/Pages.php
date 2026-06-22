<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends Shop_Controller
{
    public function about()
    {
        $this->render('pages/about', array(
            'title' => 'Tentang Kami - Nipzz!! Store'
        ));
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  function __construct()
  {
    parent::__construct();
  }
    public function index()
    {
        if($this->session->userdata('logged_id'))
            redirect('tickets', 'refresh');
        else
        {
            $this->load->helper ('form');
            $this->load->view ('login/login_form');
        }
    }
}
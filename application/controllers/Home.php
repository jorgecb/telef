<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  function __construct()
  {
    parent::__construct();
  }
    public function index()
    {}

    public function logout()
    {
        $this->session->unset_userdata('logged_id');
        session_destroy();
        redirect('login', 'refresh');
    }
}
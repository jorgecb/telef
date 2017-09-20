<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('usuario','',TRUE);
  }

  function index()
  {
        if($this->session->userdata('logged_id'))
            redirect('tickets', 'refresh');
        else
        {
            //This method will have the credentials valusuarioIDation
            $this->load->library('form_validation');

            $this->form_validation->set_rules('usuario', 'usuario', 'trim|required');
            $this->form_validation->set_rules('password', 'password', 'trim|required|callback_check_database');

            if($this->form_validation->run() == FALSE)
            {
				//Field valusuarioIDation failed.  User redirected to login page
				$this->load->view('login/login_form');
            }
            else
            {
				//Go to private area
				if($this->session->userdata('logged_id')["rol"] == 3)//Si es vendedor
					redirect('tickets/venta', 'refresh');  
				else
					redirect('tickets', 'refresh');
            }
         }
  }

  function check_database($password)
  {
    //Field valusuarioIDation succeeded.  ValusuarioIDate against database
    $username = $this->input->post('usuario');

    //query the database
    $result = $this->usuario->login($username, $password);

    if($result)
    {
		$sess_array = array();
		foreach($result as $row)
		{
			$sess_array = array(
				'usuario' => $row->usuario,
				'nombre' => $row->nombre.' '.$row->apellido_paterno.' '.$row->apellido_materno,
				'rol' => $row->id_rol,
			);
			$this->session->set_userdata('logged_id', $sess_array);
		}
		return TRUE;
    }
    else
    {
		$this->form_validation->set_message('check_database', 'Usuario o Password Invalido');
		return false;
    }
  }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends CI_Controller {

  function __construct()
  {
    parent::__construct();
  }
    public function index()
    {
        if ($this->session->userdata('logged_id')) {

            $this->load->helper('form');
            $sesion = $this->session->userdata('logged_id');
            $data['main_content'] = 'Password/password';
            $data['titutlo'] = 'Teleferico Taxco :: Generador de Tickets';
            $data['subtitulo'] = 'Reporte de Venta';
            $data['menu'] = 'reporte';
            $data['usuario'] = $sesion['usuario'];
            $data['nombre'] = $sesion['nombre'];
            $data['rol'] = $sesion['rol'];
           
            $this->load->view('includes/template', $data);
        } else
            redirect('login', 'refresh');
    }
 public function update()
    {
        if ($this->session->userdata('logged_id')) {

			$nombre = $_POST['nombre'];
			$ca = $_POST['ca'];
			$cn = $_POST['cn'];
			$cc = $_POST['cc'];


if($nombre != ""){

	 

$resultado=$this->usuariost->select_single($this->input->post('nombre'))->result();

    if($resultado[0]->password== md5($ca)){
        if($cn == $cc){
           
              
 $usuarioz = array(
		'password' =>  md5($this->input->post('cn')), 
               
            );
		$user = $this->usuariost->update($usuarioz,$this->input->post('nombre'));
              echo 0;
              
        }
        else{
                echo 1;
            }
    }else{
        echo 2;
    }  
}
        } 
    }
}

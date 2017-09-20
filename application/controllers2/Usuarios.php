<?php

Class Usuarios extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        if ($this->session->userdata('logged_id')) {
            $this->load->helper('form');
            $sesion = $this->session->userdata('logged_id');
            $data['main_content'] = 'usuarios/usuarios';
            $data['titutlo'] = 'Teleferico Taxco :: Generador de Tickets';
            $data['subtitulo'] = 'Usuarios';
            $data['menu'] = 'usuarios';
            $data['usuario'] = $sesion['usuario'];
            $data['nombre'] = $sesion['nombre'];
            $data['rol'] = $sesion['rol'];
            $config['base_url'] = base_url() . 'usuarios';
            $config['first_url'] = base_url() . 'usuarios/';
            $config['prefix'] = '/pag/';
            $config['use_page_numbers'] = TRUE;
            $config['total_rows'] = $this->usuariost->total_filas();
            $config['per_page'] = '5';
            $config['num_links'] = 4;
            $config['uri_segment'] = 3;
            $config['first_link'] = 'Primero';
            $config['last_link'] = 'Último';
            $config['next_link'] = 'Siguiente';
            $config['prev_link'] = 'Anterior';
            $inicio = 0;
            if ($this->uri->segment(3))
                $inicio = ($this->uri->segment(3) - 1) * $config['per_page'];
            $this->pagination->initialize($config);
            $noticias = $this->usuariost->get_usuario($config['per_page'], $inicio);
            //usuario
            for ($i = 0; $i < count($noticias); $i++)
                $noticias[$i]['acciones'] = '<button id="modificar" onclick="update(\''.$noticias[$i]['usuario'] .'\')">Modificar</button> <button id="eliminar" onclick="deleteu(\''.$noticias[$i]['usuario'] .'\')">Eliminar</button>';
            $this->table->set_heading('USUARIO', 'NOMBRE', 'APELLIDO_PATERNO', 'APELLIDO_MATERNO', 'E-MAIL', 'ROL', 'ACCIONES');
            $data['tabla'] = $this->table->generate($noticias);
            $data['link'] = $this->pagination->create_links();
            $this->load->view('includes/template', $data);
        } else
            redirect('login', 'refresh');
    }

    public function lista() {
        if ($this->session->userdata('logged_id')) {
            $resp = array(
                'result' => true,
                'lista_usuarios' => '',
            );
            $result = $this->usuariost->select();
            foreach ($result->result()as $row)
                $resp['lista_usuarios'].= '<tr><td>' . $row->usuario . '</td><td>' . $row->nombre . ' ' . $row->apellido_paterno . ' ' . $row->apellido_materno . '</td><td></td><td>' . $row->id_rol . '</td></tr>';
            echo json_encode($resp);
        } else
            redirect('login', 'refresh');
    }
     public function add() {
        if ($this->session->userdata('logged_id')) {
           
              $usuario = array(
		'usuario' => $this->input->post('usuario'),
                'password' =>  md5($this->input->post('password')), 
                'nombre' => $this->input->post('nombre'),
                'apellido_paterno' => $this->input->post('apellido_paterno'),
                'apellido_materno' => $this->input->post('apellido_materno'),
                'e-mail' => $this->input->post('e-mail'),				
                'id_rol' => "3",
                'estatus' =>1
            );
		$user = $this->usuariost->insert($usuario);
              echo $user;
        } else
            redirect('login', 'refresh');
    }

     public function del() {
        if ($this->session->userdata('logged_id')) {
           
           
		$user = $this->usuariost->delete($this->input->post('usuario') );
              echo $user;
        } else
            redirect('login', 'refresh');
    }
    public function listausuarios() {
        if ($this->session->userdata('logged_id')) {
            $resp = array(
                'result' => true,
                'lista_usuarios' => '',
            );
            $result = $this->usuariost->select();
            foreach ($result->result()as $row)
                $resp['lista_usuarios'].= '<option value="' . $row->usuario . '" >' . $row->usuario . '</option>';
            echo json_encode($resp);
        } else
            redirect('login', 'refresh');
    }
    public function cajausuarios() {
        if ($this->session->userdata('logged_id')) {
            
            
            $resp = array(
                'result' => true,
                'lista_usuarios' => '',
            );
           // var_dump($this->input->post());
            $result = $this->usuariost->caja($this->input->post('fecha') );
               $resp['lista_usuarios'].= '<option value="" >---Select---</option>';
            foreach ($result->result()as $row)
                $resp['lista_usuarios'].= '<option value="' . $row->usuario . '" >' . $row->usuario . '</option>';
            echo json_encode($resp);
        } else
            redirect('login', 'refresh');
    }

}

?>
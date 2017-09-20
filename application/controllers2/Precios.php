<?php
Class Precios extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	public function index()
    {
        if($this->session->userdata('logged_id'))
        {
            $this->load->helper ('form');
			$sesion = $this->session->userdata('logged_id');
            $data['main_content'] = 'precios/precios_tickets';
            $data['titutlo'] = 'Teleferico Taxco :: Generador de Tickets';
            $data['subtitulo'] = 'Precios';
			$data['menu'] = 'precio';
			$data['usuario'] = $sesion['usuario'];
			$data['nombre'] = $sesion['nombre'];
			$data['rol'] = $sesion['rol'];
			$config['base_url'] = base_url().'precios';
			$config['first_url'] = base_url().'precios/';
			$config['prefix'] = '/pag/';
			$config['use_page_numbers'] = TRUE;        
			$config['total_rows'] = $this->preciotickets->total_filas();        
			$config['per_page'] = '10';        
			$config['num_links'] = 4;        
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Primero';
			$config['last_link'] = 'Último';
			$config['next_link'] = 'Siguiente';
			$config['prev_link'] = 'Anterior';
			$inicio = 0;
			if($this->uri->segment(3))
			$inicio = ($this->uri->segment(3)-1)*$config['per_page'];
			$this->pagination->initialize($config);
			$noticias = $this->preciotickets->get_precioticket($config['per_page'],$inicio);
			$this->table->set_heading('#', 'TIPO', 'PRECIO', 'VIGENCIA (HRS.)');
			$data['tabla'] = $this->table->generate($noticias);
			$data['link'] = $this->pagination->create_links();
            $this->load->view('includes/template',$data);
        }
        else
            redirect('login', 'refresh');
    }
	public function precios()
	{		if($this->session->userdata('logged_id'))       		{
					$resp = array(
				'result' => true,
				'lista_precios' => '',
			);
			$result = $this->preciotickets->select();
			foreach($result->result()as $row)
				$resp['lista_precios'].= '<tr><td>'.$row->tipo.'</td><td>'.$row->precio.'</td></tr>';
			echo json_encode($resp);					}        		else        			redirect('login', 'refresh');	
	}
}
?>
<?php
Class Paginacion extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        //Cargamos nuestro modelo de noticias
        $this->load->model('preciotickets');
        //Cargamos el Helper para el uso del BASE_URL()
        $this->load->helper('url');
    }
     
    public function index()
    {
        //cargamos la libreria pagination
        $this->load->library('pagination');
        //cargamos la librearia table
        $this->load->library('table');
         
        //la url de mi paginacion
        $config['base_url'] = base_url().'paginacion';
        //le decimos cual es la url del primer link (1)
        $config['first_url'] = base_url().'paginacion/';
        //Agregamos un prefix page (SEO)
        $config['prefix'] = '/pag/';
        //Habilitamos esta opcion para que los link sean page/1,page/2,etc (SEO)
        $config['use_page_numbers'] = TRUE;
        //Le indicamos el numero total de filas
        $config['total_rows'] = $this->preciotickets->total_filas();
        //cuantas noticias vamos a mostrar por página
        $config['per_page'] = '2';
        //cantidad de link a mostrar en la paginacion
        $config['num_links'] = 4;
        //la uri de donde se encuentra nuestra pagina /paginacion/page/1
        $config['uri_segment'] = 3;
         
        $config['first_link'] = 'Primero';
        $config['last_link'] = 'Último';
        $config['next_link'] = 'Siguiente';
        $config['prev_link'] = 'Anterior';
         
        //Logica para obtener el limit
        $inicio = 0;
        if($this->uri->segment(3))
        $inicio = ($this->uri->segment(3)-1)*$config['per_page'];
         
        //cargamos la configuracion en la paginacion
        $this->pagination->initialize($config);
        //las noticias por pagina
        $noticias = $this->preciotickets->get_noticias($config['per_page'],$inicio);
         
        //configuramos la cabecera de mi tabla
        $this->table->set_heading('PRECIO', 'TIPO', 'CODIGO');
        //almacenamos el contenido en una variable
        $data['tabla'] = $this->table->generate($noticias);
        //alamacenamos los link en una variable
        $data['link'] = $this->pagination->create_links();
        //cargamos nuestra vista
        $this->load->view('paginacion/paginacion',$data);
    }
}
?>
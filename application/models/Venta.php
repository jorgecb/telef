<?php
Class Venta extends CI_Model
{
    function insert ($venta)
    {
        $this->db->insert('venta', $venta);
        if($this->db->affected_rows() > 0)
		    return $this->db->insert_id();
        else
            return 0;
    }
	   function last($usuario){
     
      $this->db->select("group_concat(codigo_barras)as codes");                 
                $this->db->join('venta',  'folio_venta=folio', 'INNER');
	               	$this->db->where("usuario ='$usuario'");
                            $this->db->group_by('folio_venta'); 
                   $this->db->order_by("folio", "desc");
                         $this->db->limit(1);
       //var_dump($data);
                  // $sql=$this->db->get("detalle_venta");
     
     
     
		 			return $this->db->get("detalle_venta")->row();    //  echo $this->db->last_query(); die;
    
		
	}
	function select($data){
		       $sesion = $this->session->userdata('logged_id');
            $usuario = $sesion['usuario'];
       $accesos = array(
				'user' => trim($data['user']),
				'date' =>date('Y-m-d H:i:s') ,
        'cajeroreporte'=> trim($data['usuario'])
			
			);
          $this->db->insert('accesos', $accesos);
  
     
                 $this->db->select("distinct(folio)as folio,fecha,venta.subtotal,venta.iva,venta.total");                 
                $this->db->join('detalle_venta',  'venta.folio =detalle_venta.folio_venta', 'INNER');
		if(($data['fechainicio'])!='')
			$this->db->where('fecha >=', $data['fechainicio']);
		if(($data['fechafin'])!='')
			$this->db->where('fecha <=', $data['fechafin']);
               if(($data['usuario'])!='')
			$this->db->where('usuario =', trim($data['usuario']));
                   if(($data['tipo'])!='')
			$this->db->where('detalle_venta.id_preciotickets =', trim($data['tipo']));
               
                 if(($data['motivo'])!='')
			$this->db->where('detalle_venta.motivodescuento  LIKE ', '%'.trim($data['motivo']).'%');
              //var_dump($data);
                   $this->db->order_by("venta.fecha", "asc");
                   $sql=$this->db->get("venta");
                 //  echo $this->db->last_query(); die;
		return $sql;
	}
	 
}
?>
<?php
Class DetalleVenta  extends CI_Model
{
    function insert ($detalleventa)
    {
        $this->db->insert('detalle_venta', $detalleventa);
        if($this->db->affected_rows() > 0)
		    return true;
        else
            return false;
    }
	 function delete ($code)
    {
        $this->db->where('codigo_barras', $code);
        
        $this->db->delete('detalle_venta');
        if($this->db->affected_rows() > 0)
		    return true;
        else
            return false;
    }
	function deleteHis($eliminado)
    {
         $this->db->insert('eliminados', $eliminado);
        if($this->db->affected_rows() > 0)
		    return true;
        else
            return false;
    }
	function detalle($folio,$data=null){
		$this -> db -> from('detalle_venta');
		$this->db->where('folio_venta =', $folio);
                if(!empty($data)){
                      if(($data['tipo'])!='')
			$this->db->where('id_preciotickets =', trim($data['tipo']));
                }
		return $this->db->get();
	}
        function find($motivo){
		$this -> db -> from('detalle_venta');
		$this->db->where('motivodescuento like ', '%'.$motivo.'%');
		return $this->db->get();
	}
	  function findunic($motivo){
		  $this -> db -> select('distinct(motivodescuento)');
		$this -> db -> from('detalle_venta');
		$this->db->where('motivodescuento like ', $motivo.'%');
		return $this->db->get();
	}
        function codeinfo($code){
          //  var_dump($code);
		$this -> db -> from('detalle_venta');
		$this->db->where('codigo_barras=',$code);
             //var_dump($this->db->get_compiled_select());
		return $this->db->get()->row();
	}
	public function get_detalle_venta($per_page,$segmento,$data)
    {
        $this -> db -> select("venta.folio , Date_format(venta.fecha,'%d/%m/%y'), detalle_venta.codigo_barras, precio_tickets.tipo, detalle_venta.subtotal");
		$this->db->join('venta',  'venta.folio = detalle_venta.folio_venta', 'INNER'); 
		$this->db->join('precio_tickets',  'precio_tickets.id_preciotickets = detalle_venta.id_preciotickets', 'INNER');
		if(($data['fechainicio'])!='')
			$this->db->where('venta.fecha >=', $data['fechainicio']);
		if(($data['fechafin'])!='')
			$this->db->where('venta.fecha <=', $data['fechafin']);
		if(($data['usuario'])!=0)
			$this->db->where('venta.usuario =', $data['usuario']);
      
      $this->db->order_by("venta.fecha", "asc");
		$sql = $this->db->get('detalle_venta',$per_page,$segmento);
        return $sql->result_array();
    }
     
    public function total_filas($data)
    {
		$this -> db -> from('detalle_venta');
		$this->db->join('venta',  'venta.folio = detalle_venta.folio_venta', 'INNER'); 
		if(($data['fechainicio'])!='')
			$this->db->where('venta.fecha >=', $data['fechainicio']);
		if(($data['fechafin'])!='')
			$this->db->where('venta.fecha <=', $data['fechafin']);
		if(($data['usuario'])!=0)
			$this->db->where('venta.usuario =', $data['usuario']);
        $sql = $this->db->get();
        return $sql->num_rows();
    }
	public function acumuladores_tipo($data)
    {
        $this -> db -> select("(sum(open)) AS cantidad, precio_tickets.tipo,redondo, sum(detalle_venta.subtotal) as subtotal");
		$this->db->join('venta',  'venta.folio = detalle_venta.folio_venta', 'INNER'); 
		$this->db->join('precio_tickets',  'precio_tickets.id_preciotickets = detalle_venta.id_preciotickets', 'INNER');
                $this->db->join('detalle_tickets',  'detalle_tickets.codigo_barras = detalle_venta.codigo_barras', 'INNER');
                
		if(($data['fechainicio'])!='')
			$this->db->where('venta.fecha >=', $data['fechainicio']);
		if(($data['fechafin'])!='')
			$this->db->where('venta.fecha <=', $data['fechafin']);
                //var_dump($data); 
		if(($data['usuario'])!='')
			$this->db->where('venta.usuario =', $data['usuario']);
                
                $this->db->where('detalle_tickets.id_estatus <>1');
		$this->db->group_by("precio_tickets.tipo"); 
               // var_dump($this->db->get_compiled_select());
		return $this->db->get('detalle_venta');

    }   
}
?>
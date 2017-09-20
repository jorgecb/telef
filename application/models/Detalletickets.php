<?php

Class DetalleTickets extends CI_Model {

    function insert($detalleticket) {
        $this->db->insert('detalle_tickets', $detalleticket);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }

    function update($codigobarras, $detalleticket) {
        $this->db->where('codigo_barras', $codigobarras);
        $this->db->update('detalle_tickets', $detalleticket);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false; 
    }
    function master($data){
		$this -> db -> from('recuerdo_t');
		if(($data['fechainicio'])!='')
			$this->db->where('time >=', $data['fechainicio']);
		if(($data['fechafin'])!='')
			$this->db->where('time <=', $data['fechafin']);
		$this->db->order_by('codigo_barras', 'DESC');                
		$this->db->order_by('time', 'ASC');

		return $this->db->get();
	}
	 function deletes($data){
		$this -> db -> from('eliminados');
		if(($data['fechainicio'])!='')
			$this->db->where('fecha >=', $data['fechainicio']);
		if(($data['fechafin'])!='')
			$this->db->where('fecha <=', $data['fechafin']);
      	return $this->db->get();
	}

    function existecb($codigobarras) {
        $this->db->from('detalle_tickets');
        $this->db->where('codigo_barras = ' . "'" . $codigobarras . "'");
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    function verificacb($codigobarras) {
        $this->db->from('detalle_tickets');
        $this->db->where('codigo_barras = "' . $codigobarras . '"');
        $query = $this->db->get();
        return $query;
    }

    function datos($codigobarras) {
        $this->db->from('detalle_tickets');
        $this->db->where('codigo_barras = "' . $codigobarras . '"');
        $query = $this->db->get();
        return $query->row();
    }

    function detalle($id_ticketsgenerados) {
        $this->db->from('detalle_tickets');
        $this->db->where('id_ticketsgenerados =', $id_ticketsgenerados);
        return $this->db->get();
    }

    public function get_detalle_tickets($per_page, $segmento, $data) {
        $this->db->select("tickets_generados.id_ticketsgenerados, Date_format(tickets_generados.fecha_creacion,'%d/%m/%y'), precio_tickets.tipo, detalle_tickets.codigo_barras, Date_format(detalle_tickets.fecha_vigencia,'%d/%m/%y'), cat_estatus.descripcion");
        $this->db->join('tickets_generados', 'tickets_generados.id_ticketsgenerados = detalle_tickets.id_ticketsgenerados', 'INNER');
        $this->db->join('precio_tickets', 'tickets_generados.id_preciotickets = precio_tickets.id_preciotickets', 'INNER');
        $this->db->join('cat_estatus', 'cat_estatus.id_estatus = detalle_tickets.id_estatus', 'INNER');
        if (($data['fechainicio']) != '')
            $this->db->where('tickets_generados.fecha_creacion >=', $data['fechainicio']);
        if (($data['fechafin']) != '')
            $this->db->where('tickets_generados.fecha_creacion <=', $data['fechafin']);
        $this->db->order_by('tickets_generados.id_ticketsgenerados asc');
        $sql = $this->db->get('detalle_tickets', $per_page, $segmento);
        return $sql->result_array();
    }

    public function total_filas($data) {
        $this->db->from('detalle_tickets');
        $this->db->join('tickets_generados', 'tickets_generados.id_ticketsgenerados = detalle_tickets.id_ticketsgenerados', 'INNER');
        if (($data['fechainicio']) != '')
            $this->db->where('tickets_generados.fecha_creacion  >=', $data['fechainicio']);
        if (($data['fechafin']) != '')
            $this->db->where('tickets_generados.fecha_creacion  <=', $data['fechafin']);
        $sql = $this->db->get();
        return $sql->num_rows(); 
    }

    public function acumuladores_tipo($data) {
        $this->db->select("(sum(open)) AS cantidad,(sum(contador)) AS entradas,redondo, precio_tickets.tipo");
        $this->db->join('tickets_generados', 'tickets_generados.id_ticketsgenerados = detalle_tickets.id_ticketsgenerados', 'INNER');
        $this->db->join('precio_tickets', 'tickets_generados.id_preciotickets = precio_tickets.id_preciotickets', 'INNER');
        $this->db->join('cat_estatus', 'cat_estatus.id_estatus = detalle_tickets.id_estatus', 'INNER');

        if (($data['fechainicio']) != '')
            $this->db->where('tickets_generados.fecha_creacion >=', $data['fechainicio']);
        if (($data['fechafin']) != '')
            $this->db->where('tickets_generados.fecha_creacion <=', $data['fechafin']);
        $this->db->group_by("precio_tickets.tipo");
        $this->db->where("detalle_tickets.id_estatus<>1");
        return $this->db->get('detalle_tickets');
    }

}

?>
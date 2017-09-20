<?php
Class TicketsGenerados  extends CI_Model
{
    function insert ($ticketgenerado)
    {
        $this->db->insert('tickets_generados', $ticketgenerado);
        if($this->db->affected_rows() > 0)
		    return $this->db->insert_id();
        else
            return 0;
    }

    function update ($id_ticketgenerador, $ticketgenerado)
    {
        $this->db->where('id_ticketgenerador', $id_ticketgenerador);
        $this->db->update('tickets_generados', $ticketgenerado);
        if($this->db->affected_rows() > 0)
		    return true;
        else
            return false;

    }
    function datos ($id_ticketgenerador)
    {
        $this -> db -> from('tickets_generados');
		$this -> db -> where('id_ticketsgenerados = "' . $id_ticketgenerador .'"');
		$query = $this -> db -> get();
        return $query->row();
    }
	function select($data){
		$this -> db -> from('tickets_generados');
		if(($data['fechainicio'])!='')
			$this->db->where('fecha_creacion >=', $data['fechainicio']);
		if(($data['fechafin'])!='')
			$this->db->where('fecha_creacion <=', $data['fechafin']);
		return $this->db->get();
	}
}
?>
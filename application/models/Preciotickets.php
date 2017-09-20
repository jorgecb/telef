<?php
Class PrecioTickets  extends CI_Model
{
    function datos ($id_precioticket)
    {
        $this -> db -> from('precio_tickets');
		$this -> db -> where('id_preciotickets = "' . $id_precioticket .'"');
		$query = $this -> db -> get();
        return $query->row();
    }
	function select ()
	{
		return $this->db->get('precio_tickets'); 
	}
	public function get_precioticket($per_page,$segmento)
    {
        $sql = $this->db->get('precio_tickets',$per_page,$segmento);
        return $sql->result_array();
    }
     
    public function total_filas()
    {
        $sql = $this->db->get('precio_tickets');
        return $sql->num_rows();
    }
}
?>
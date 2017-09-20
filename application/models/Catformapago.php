<?php

Class Catformapago  extends CI_Model
{
	function select ()
	{
		return $this->db->get('cat_formapago');
	} 
	function datos ($id_formapago)
    {
        $this -> db -> from('cat_formapago');
		$this -> db -> where('id_formapago = "' . $id_formapago .'"');
		$query = $this -> db -> get();
        return $query->row();
    }
}

?>
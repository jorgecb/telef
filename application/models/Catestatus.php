<?php
Class Catestatus  extends CI_Model
{
    function datos ($id_estatus)
    {
        $this -> db -> from('cat_estatus');
		$this -> db -> where('id_estatus = "' . $id_estatus .'"');
		$query = $this -> db -> get();
        return $query->row();
    }
}
?>
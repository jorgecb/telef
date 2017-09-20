<?php
Class Usuario extends CI_Model
{
	function login($usuario, $password)
	{
  
      $accesos = array(
				'user' => $usuario,
				'date' =>date('Y-m-d H:i:s')
			
			);
          $this->db->insert('accesos', $accesos);
  
		$this -> db -> select('usuario, nombre, apellido_paterno, apellido_materno, id_rol');
		$this -> db -> from('usuarios');
		$this -> db -> where('usuario = "'.$usuario.'"');
$this -> db -> where('estatus = "1"');
		$this -> db -> where('password = MD5("'.$password.'")');
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			//$description=array('task'=>'Inicio sesión el usuario');
			//$this->log->insert('1',$usuario,'1',$usuario,$description);
			return $query->result();
		}
		else
		{
			return false;
		}

	}
}
?>

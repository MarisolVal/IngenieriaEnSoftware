<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestas_model extends CI_Model {
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	function insertaPregunta($data){
		$this->db->insert('reactivos',array('pregunta'=>$data['pregunta']));
	}
	function insertarRegistro($data){
		$this->db->insert('login',array('user'=>$data['nombre'],'password'=>md5($data['contrasena']),'apellido'=>$data['apellido'],'email'=>$data['email'],'tipoUsuario'=>$data['tipoUsuario']));
	}

	function obtenerDatos(){
		$query = $this->db->get("estudios");
		return $query;
	}
}

?>
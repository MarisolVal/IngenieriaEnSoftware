<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('login_model');
		$this->load->library('session');
	}

	public function index(){
		if ($this->session->userdata("login")) {
			redirect(site_url('adminSistema',NULL));
		}
		else{
			$this->load->view('encuestas/inicio');
		}
	}
	public function iniciaSesion(){
		$this->load->view('encuestas/iniciarSesion');
	}
	public function validaLogin(){
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'contrasena' => $this->input->post('contrasena')
		);
		$res = $this->login_model->login($data);
		if(!$res){
			$this->session->set_flashdata('login_failed','El usuario y/o contraseña son incorrectos');
			$this->load->view('encuestas/iniciarSesion');
		}
		else{
			$datos = array(
				'idLogin' => $res->idLogin,
				'user' => $res->user,
				'apellido' => $res->apellido,
				'rol' => $res->rol,
				'login' => TRUE
			);
			$this->session->set_userdata($datos);
			if($this->session->userdata("rol")=='AdminSistema'){
				redirect(site_url('AdminSistema',NULL));
			}
			else if($this->session->userdata("rol")=='AdminEncuesta'){
				redirect(site_url('AdminEncuesta',NULL));
			}else{
				$this->load->view('encuestas/iniciarSesion');
			}
		}
		
	}
	public function logout(){
		$this->session->sess_destroy();
		$this->load->view('encuestas/inicio');
	}
}

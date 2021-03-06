<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminEncuesta extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('AdminEncuesta_model');
		$this->load->library('session');
		$this->load->library('form_validation');
		if (!$this->session->userdata("login")){
			redirect(site_url('login',NULL));
		}
		else if($this->session->userdata('rol')!='AdminEncuesta'){
			redirect(site_url('login/logout',NULL));
		}
	}

 	public function index(){
		$this->load->view('encuestas/adminEncuesta/inicioAdminEncuesta');
	}
	public function altaEstudio(){
		$this->load->view('encuestas/adminEncuesta/altaEstudio');
	}
	public function recibirDatosEstudio(){
		$data = array(
			'nombre' => $this->input->post('nombre'),
			'descripcion' => $this->input->post('descripcion')
		);
		$this->AdminEncuesta_model->insertaEstudio($data);
		$this->load->view('encuestas/adminEncuesta/inicioAdminEncuesta');
	}
	public function altaCuestionario(){
		$this->load->view('encuestas/adminEncuesta/altaCuestionario');
	}
	public function recibirDatosCuestionario(){
		$this->form_validation->set_rules('nombre', 'Nombre', 'required|min_length[1]|trim');
		$this->form_validation->set_message('required','');
		if($this->form_validation->run()!=false){ //Si la validación es correcta
                $data = array('nombre'=> $this->input->post('nombre'));
                $recuperar['recuperar'] = $this->AdminEncuesta_model->insertaCuestionario($data);
                $this->load->view('encuestas/adminEncuesta/altaReactivo',$recuperar);
             }else{                    
             	$datos['error'] = 'Escriba un nombre' ;
                $this->load->view('encuestas/adminEncuesta/altaCuestionario',$datos);
             }
       	$data = array('nombre'=> $this->input->post('nombre'));
        $recuperar['recuperar'] = $this->AdminEncuesta_model->insertaCuestionario($data);
	}

	public function altaReactivo(){
		$this->load->view('encuestas/adminEncuesta/altaReactivo');
	}
	public function recibirDatosReactivo(){
		
		$this->form_validation->set_rules('pregunta', 'Pregunta', 'required|min_length[3]|trim');
		$this->form_validation->set_message('required','');
		if($this->form_validation->run()!=false){ //Si la validación es correcta
                $data = array(
					'pregunta' => $this->input->post('pregunta'));
                $datos['correcto'] = 'Pregunta agregada con éxito' ;
                $this->AdminEncuesta_model->insertaReactivo($data);
                $this->load->view('encuestas/adminEncuesta/altaReactivo',$datos);
             }else{                    
             	$datos['error'] = 'Debe escribir una pregunta válida' ;
                $this->load->view('encuestas/adminEncuesta/altaReactivo',$datos);
             }
		
	}
	public function vista_estudios()
	{
		$data["recuperar"]= $this->AdminEncuesta_model->obtenerDatos();
		$this->load->view('encuestas/encuestador/vistaEstudio',$data);
 	}  



}
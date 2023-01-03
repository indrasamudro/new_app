<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
require FCPATH . 'vendor/autoload.php';
class Api extends RestController {
	function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('m_api');
		
    }
	function index(){

	json_encode($this->load->view("api"))	;

	}
	function customer_get(){
		$data = file_get_contents('php://input');
		$dt = json_decode($data);
		$dataCustomer = $this->db->where('customer_id','1')->get("public.customer")->row();
		$resp=$this->response($dataCustomer);
		}

	function item_get(){
		$js = file_get_contents('php://input');			
	    $data = json_decode($js);	
		$req=[
			"term" => $data->term
		];
		$data = $this->m_api->get_item($req);

		$this->response($data);			
	}

	function order_post(){
		$js = file_get_contents('php://input');			
	    $data = json_decode($js);	
		$req=[
			"berat" => $data->berat,
			"jenis" => $data->jenis,
			"alamat" => $data->alamat,
			"no_telp"=> $data->no_telp,		
			
		];
		$input=array(
			"berat" => $req['berat'], 
			"jenis" => $req['jenis'],
			"alamat" => $req["alamat"],
			"no_telp" => $req["no_telp"]
			
		);		
		$dt =$this->m_api->order($input);
		if($dt==true){
			$message = array('message'=>'Data derhasil di simpan','code'=>200);
		}else{
			$message = array('message'=>'Gagal disimpan','code'=>201);
		}


		$this->response($message);			
	}



	
}


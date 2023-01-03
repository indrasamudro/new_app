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
			"no_telp" => $req["no_telp"],
			"status_terima" => "f",
			"tgl_order" => date("Y-m-d h:i:s")
			
		);		
		$dt =$this->m_api->order($input);
		$dataRespon = $this->db->get_where("public.tb_order",["id_order"=>$dt])->result();
		$resp = [];
		foreach ($dataRespon as $value) {
			$resp = [
				"tgl_order" => $value->tgl_order,	
				"berat" => $value->berat,
				"jenis" => $value->jenis		
			];
		}
		if($dt==true){
			$this->response( [
				'code' => 200,
				'status' => 'Sukses',
				'response' => $resp
			] );
		}else{
			$this->response( [
				'status' => false,
				'message' => 'No such user found'
			], 404 );
		}		
			
	}



	
}


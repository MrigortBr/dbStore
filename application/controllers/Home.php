<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		$this->load->helper('url');
		$this->load->model('ProductsModel');
		$Products = $this->ProductsModel->listAll();
    $this->load->view("home", array("products"=> $Products));

}

    
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'utils\Validators.php';

class Basket extends CI_Controller {

	public function index(){
		Validators::requestIsAllowed('GET');
		$this->load->helper('url');
		$this->load->view('basket');
}
  public function list(){
		Validators::requestIsAllowed('POST');
		$data = Validators::validateJsonPayload(file_get_contents('php://input'), array('token', 'basket'));
		Validators::decodeToken($data['token']);
		$basket = $data['basket'];
		Validators::arrayIsEmpty($basket);
		$this->load->model('ProductsModel');
		$products = array();
		foreach ($basket as $product) {
			$result = $this->ProductsModel->listProductById($product['id']);
			if($result != null){
				$result->quantity = $product['quantity'];
				array_push( $products, $result);
			}
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($products);
	}

	public function buy(){
		Validators::requestIsAllowed('POST');
		$data = Validators::validateJsonPayload(file_get_contents('php://input'), array('token', 'basket'));
		$idBuyer = Validators::decodeToken($data['token']);
		$basket = $data['basket'];
		Validators::arrayIsEmpty($basket);
		$this->load->model('ProductsModel');
		$this->load->model('StoreModel');
		$products = array();
		foreach ($basket as $product) {
			$result = $this->ProductsModel->listProductById($product['id']);
			if($result != null){
				$result->quantity = $product['quantity'];
				array_push( $products, $result);
			}
		}

		foreach ($products as $product) {
			$priceFinal = $product->price* $product->quantity;
			$buy = array(
				"product_id" => $product->id, 
				"buyer_id" => $idBuyer, 
				"amount" => $product->quantity, 
				"pricePerProduct" => $product->price, 
				"priceFinal" => $priceFinal
			);
			
			$product->stock -= $product->quantity;
			$newProduct = array("stock" => $product->stock);
			$this->ProductsModel->buyProduct($buy);
			$this->StoreModel->updateProduct($product->id, $product->store_id, $newProduct);
		}
    
	}

    
}

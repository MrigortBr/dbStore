<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductsModel extends CI_Model {

	public function listAll() {
		$this->load->database();
		$this->db->where('visible', 1);
		$this->db->where('stock >', 0);
		$query = $this->db->get('products');


		// Verifica se há resultados
		if ($query){
			if ($query->num_rows() > 0) {
				// Retorna o primeiro resultado encontrado
				return $query->result_array();
			} else {
				// Se não houver resultados, retorna NULL
				return [];
			}
		}else{
			return [];
		}

	}

	public function listProductById($idProduct) {
		$this->load->database();
		$this->db->where('visible', 1);
		$this->db->where('stock >', 0);
		$this->db->where('id', $idProduct);
		$query = $this->db->get('products');


		// Verifica se há resultados
		if ($query){
			if ($query->num_rows() > 0) {
				// Retorna o primeiro resultado encontrado
				return $query->row();
			} else {
				// Se não houver resultados, retorna NULL
				return null;
			}
		}else{
			return null;
		}

	}

	public function buyProduct($data) {
		$this->load->database();
		$query = $this->db->insert('sales', $data);		
	}
	

}

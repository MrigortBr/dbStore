<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StoreModel extends CI_Model {

	public function getAllProducts($idStore){
		$this->load->database();
		$this->db->where('store_id', $idStore);
		$query = $this->db->get('products');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}	
	}

	public function getAllSales($idProduct){
		$this->load->database();
		$this->db->where('product_id', $idProduct);
		$query = $this->db->get('sales');

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}	
	}

	public function getProductById($idStore, $idProduct){
		$this->load->database();
		$this->db->where('store_id', $idStore);
		$this->db->where('id', $idProduct);

		$query = $this->db->get('products');
		if ($query->num_rows() > 0) {
			return $query->result_array()[0];
		} else {
			return [];
		}	
	}

	public function deleteProductById($idStore, $idProduct) {
		try {
			$this->load->database();
			$this->db->where('store_id', $idStore);
			$this->db->where('id', $idProduct);
			$query = $this->db->delete('products');
	
			if ($this->db->affected_rows() > 0) {
				return array('success' => true); // Se a exclusão for bem-sucedida, retorne verdadeiro
			} else {
				$dbError = $this->db->error();
				return array('success' => false, 'error_code' => $dbError['code'], 'error_message' => $dbError['message']); // Retorne o código de erro do banco de dados
			}
		} catch (Exception $e) {
			return array('success' => false, 'error_code' => $e->getCode(), 'error_message' => $e->getMessage()); // Retorne o código de erro da exceção
		}
	}

	public function showProduct($product, $idStore){
		$this->load->database();

		$this->db->set($product);
		$this->db->where('id', $product['id']);
		$this->db->where('store_id', $idStore);
		$this->db->update('products');
        // Verifique se a atualização foi bem-sucedida
        if ($this->db->affected_rows() > 0) {
					return true; // Atualização bem-sucedida
			} else {
					return false; // Atualização falhou
			}
		
	}

	public function updateProduct($id, $idStore, $data){
		$this->load->database();

		$this->db->set($data);
		$this->db->where('id', $id);
		$this->db->where('store_id', $idStore);
		$this->db->update('products');
		print_r($this->db);

        // Verifique se a atualização foi bem-sucedida
        if ($this->db->affected_rows() > 0) {
					return true; // Atualização bem-sucedida
			} else {
					return false; // Atualização falhou
			}
	}

	public function saveProduct($data) {
		$this->load->database();
    $this->db->insert('products', $data);
		print_r($this->db);

    // Verifica se a inserção foi bem-sucedida
    if ($this->db->affected_rows() > 0) {
        // Retorna o ID do registro inserido
        return $this->db->insert_id();
    } else {
        // Se houver um erro na inserção, retorne FALSE
        return FALSE;
    }

	}

}

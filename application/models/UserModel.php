<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {


	
	public function userExist($login) {
		$this->load->database();

			$this->db->where('login', $login);
			$query = $this->db->get('users');

			return $query->num_rows() > 0;
	}

	public function getUserByLogin($login) {
		// Consulta para buscar o usuário com base no login
		$this->load->database();

		$this->db->where('login', $login);
		$query = $this->db->get('users');

		// Verifica se há resultados
		if ($query->num_rows() > 0) {
				// Retorna o primeiro resultado encontrado
				return $query->row_array();
		} else {
				// Se não houver resultados, retorna NULL
				return NULL;
		}
}

public function getUserById($id) {
	// Consulta para buscar o usuário com base no id
	$this->load->database();

	$this->db->where('id', $id);
	$query = $this->db->get('users');

	// Verifica se há resultados
	if ($query->num_rows() > 0) {
			// Retorna o primeiro resultado encontrado
			return $query->row_array();
	} else {
			// Se não houver resultados, retorna NULL
			return NULL;
	}
}

	public function saveUser($data) {
    $this->db->insert('users', $data);

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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_user($user_id) {
        return $this->db->get_where('projects', ['user_id' => $user_id])->result();
    }

    public function create($data) {
        return $this->db->insert('projects', $data);
    }

    public function delete($id, $user_id) {
        $this->db->where(['id' => $id, 'user_id' => $user_id]);
        return $this->db->delete('projects');
    }

    public function get_by_id_and_user($id, $user_id) {
        return $this->db->get_where('projects', ['id' => $id, 'user_id' => $user_id])->row();
    }

    public function update($id, $user_id, $data) {
        $this->db->where(['id' => $id, 'user_id' => $user_id]);
        return $this->db->update('projects', $data);
    }
} 
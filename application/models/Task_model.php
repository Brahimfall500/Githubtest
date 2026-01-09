<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_by_user($user_id) {
        $this->db->select('tasks.*, projects.name as project_name');
        $this->db->from('tasks');
        $this->db->join('projects', 'tasks.project_id = projects.id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->order_by('tasks.due_date', 'ASC');
        return $this->db->get()->result();
    }

    public function create($data) {
        return $this->db->insert('tasks', $data);
    }

    public function delete($id) {
        return $this->db->delete('tasks', ['id' => $id]);
    }

    public function get_by_id_and_user($id, $user_id) {
        $this->db->select('tasks.*, projects.name as project_name');
        $this->db->from('tasks');
        $this->db->join('projects', 'tasks.project_id = projects.id');
        $this->db->where(['tasks.id' => $id, 'projects.user_id' => $user_id]);
        return $this->db->get()->row();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tasks', $data);
    }
} 
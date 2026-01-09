<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model(['Task_model', 'Project_model']);
        $this->load->library('form_validation');
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['tasks'] = $this->Task_model->get_by_user($user_id);
        $this->load->view('tasks/index', $data);
    }

    public function create() {
        $user_id = $this->session->userdata('user_id');
        $data['projects'] = $this->Project_model->get_by_user($user_id);
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Titre', 'required');
            $this->form_validation->set_rules('project_id', 'Projet', 'required');
            if ($this->form_validation->run()) {
                $data_task = [
                    'project_id' => $this->input->post('project_id'),
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'status' => $this->input->post('status'),
                    'due_date' => $this->input->post('due_date')
                ];
                $this->Task_model->create($data_task);
                redirect('tasks');
            }
        }
        $this->load->view('tasks/create', $data);
    }

    public function delete($id) {
        $this->Task_model->delete($id);
        redirect('tasks');
    }

    public function edit($id) {
        $user_id = $this->session->userdata('user_id');
        $task = $this->Task_model->get_by_id_and_user($id, $user_id);
        if (!$task) {
            show_404();
        }
        $data['projects'] = $this->Project_model->get_by_user($user_id);
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Titre', 'required');
            $this->form_validation->set_rules('project_id', 'Projet', 'required');
            if ($this->form_validation->run()) {
                $data_task = [
                    'project_id' => $this->input->post('project_id'),
                    'title' => $this->input->post('title'),
                    'description' => $this->input->post('description'),
                    'status' => $this->input->post('status'),
                    'due_date' => $this->input->post('due_date')
                ];
                $this->Task_model->update($id, $data_task);
                redirect('tasks');
            }
        }
        $data['task'] = $task;
        $this->load->view('tasks/edit', $data);
    }
} 
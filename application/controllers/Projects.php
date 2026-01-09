<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model('Project_model');
        $this->load->library('form_validation');
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['projects'] = $this->Project_model->get_by_user($user_id);
        $this->load->view('projects/index', $data);
    }

    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nom du projet', 'required');
            if ($this->form_validation->run()) {
                $data = [
                    'user_id' => $this->session->userdata('user_id'),
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description')
                ];
                $this->Project_model->create($data);
                redirect('projects');
            }
        }
        $this->load->view('projects/create');
    }

    public function delete($id) {
        $this->Project_model->delete($id, $this->session->userdata('user_id'));
        redirect('projects');
    }

    public function edit($id) {
        $user_id = $this->session->userdata('user_id');
        $project = $this->Project_model->get_by_id_and_user($id, $user_id);
        if (!$project) {
            show_404();
        }
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nom du projet', 'required');
            if ($this->form_validation->run()) {
                $data = [
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description')
                ];
                $this->Project_model->update($id, $user_id, $data);
                redirect('projects');
            }
        }
        $data['project'] = $project;
        $this->load->view('projects/edit', $data);
    }
} 
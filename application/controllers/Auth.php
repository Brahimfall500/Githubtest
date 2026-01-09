<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(['url', 'form']);
    }

    public function register() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Nom d\'utilisateur', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Mot de passe', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Confirmation', 'required|matches[password]');
            if ($this->form_validation->run()) {
                $data = [
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
                ];
                $this->User_model->register($data);
                $this->session->set_flashdata('success', 'Inscription réussie, connectez-vous.');
                redirect('auth/login');
            }
        }
        $this->load->view('auth/register');
    }

    public function login() {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->User_model->login($username, $password);
            if ($user) {
                $this->session->set_userdata(['user_id' => $user->id, 'username' => $user->username]);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Identifiants invalides.');
            }
        }
        $this->load->view('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
} 
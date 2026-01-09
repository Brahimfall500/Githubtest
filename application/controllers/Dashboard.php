<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url']);
    }

    public function index() {
        // Rediriger les chefs de projet vers leur dashboard spécifique
        $user_role = $this->session->userdata('role');
        
        if ($user_role === 'project_manager') {
            redirect('project_manager');
        }
        
        $this->load->view('dashboard/index');
    }
} 
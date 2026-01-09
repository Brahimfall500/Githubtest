<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url']);
        $this->load->model(['Project_model', 'User_model', 'Task_model', 'Admin_model']);
        
        // Redirige si non connecté
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        // Vérifier si l'utilisateur est admin (vous pouvez ajuster cette logique selon vos besoins)
        // Pour l'instant, on suppose qu'il y a un champ 'role' dans la table users
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        if (!$user || (isset($user->role) && $user->role !== 'admin')) {
            // Si pas d'admin, rediriger vers le dashboard normal
            redirect('dashboard');
        }
    }

    public function index() {
        // Récupérer les statistiques des projets
        $data['total_projects'] = $this->Admin_model->get_total_projects();
        $data['projects_in_progress'] = $this->Admin_model->get_projects_by_status('en_cours');
        $data['projects_completed'] = $this->Admin_model->get_projects_by_status('termine');
        $data['projects_overdue'] = $this->Admin_model->get_overdue_projects();
        
        // Récupérer les statistiques des utilisateurs
        $data['total_users'] = $this->Admin_model->get_total_users();
        $data['active_users'] = $this->Admin_model->get_active_users();
        $data['total_tasks'] = $this->Admin_model->get_total_tasks();
        $data['completed_tasks'] = $this->Admin_model->get_completed_tasks();
        
        // Récupérer les projets récents pour affichage
        $data['recent_projects'] = $this->Admin_model->get_recent_projects(5);
        
        // Récupérer les utilisateurs les plus actifs
        $data['top_users'] = $this->Admin_model->get_top_users(5);
        
        $this->load->view('admin/dashboard', $data);
    }

    public function users() {
        // Récupérer les paramètres de recherche et filtrage
        $search = $this->input->get('search');
        $role_filter = $this->input->get('role');
        $status_filter = $this->input->get('status');
        $date_filter = $this->input->get('date_filter');
        
        // Récupérer la liste des utilisateurs avec filtres
        $data['users'] = $this->Admin_model->get_users_with_filters($search, $role_filter, $status_filter, $date_filter);
        $data['total_users'] = $this->Admin_model->get_total_users();
        $data['active_users'] = $this->Admin_model->get_active_users();
        
        // Paramètres pour la vue
        $data['search'] = $search;
        $data['role_filter'] = $role_filter;
        $data['status_filter'] = $status_filter;
        $data['date_filter'] = $date_filter;
        
        $this->load->view('admin/users', $data);
    }

    public function user_details($user_id) {
        $data['user'] = $this->Admin_model->get_user_details($user_id);
        $data['user_projects'] = $this->Admin_model->get_user_projects($user_id);
        $data['user_tasks'] = $this->Admin_model->get_user_tasks($user_id);
        
        if (!$data['user']) {
            show_404();
        }
        
        $this->load->view('admin/user_details', $data);
    }

    public function toggle_user_status() {
        $user_id = $this->input->post('user_id');
        $action = $this->input->post('action'); // 'activate' or 'deactivate'
        
        if ($user_id && in_array($action, ['activate', 'deactivate'])) {
            $status = ($action === 'activate') ? 1 : 0;
            $result = $this->Admin_model->update_user_status($user_id, $status);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Statut utilisateur mis à jour avec succès.');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la mise à jour du statut.');
            }
        }
        
        redirect('admin/users');
    }

    public function delete_user() {
        $user_id = $this->input->post('user_id');
        
        if ($user_id && $user_id != $this->session->userdata('user_id')) {
            $result = $this->Admin_model->delete_user($user_id);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Utilisateur supprimé avec succès.');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la suppression de l\'utilisateur.');
            }
        } else {
            $this->session->set_flashdata('error', 'Impossible de supprimer cet utilisateur.');
        }
        
        redirect('admin/users');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_manager extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
        $this->load->model(['Project_model', 'User_model', 'Task_model', 'Project_manager_model']);
        
        // Redirige si non connecté
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        // Vérifier si l'utilisateur est chef de projet ou admin
        // Pour le moment, permettre l'accès à tous les utilisateurs connectés
        // TODO: Activer la vérification des rôles quand les rôles seront correctement configurés
        /*
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('users', ['id' => $user_id])->row();
        if (!$user || (!in_array($user->role ?? 'user', ['project_manager', 'admin']))) {
            redirect('dashboard');
        }
        */
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        // Statistiques générales
        $data['total_projects'] = $this->Project_manager_model->get_total_projects($user_id);
        $data['active_projects'] = $this->Project_manager_model->get_active_projects($user_id);
        $data['completed_projects'] = $this->Project_manager_model->get_completed_projects($user_id);
        $data['overdue_projects'] = $this->Project_manager_model->get_overdue_projects($user_id);
        
        // Statistiques des tâches
        $data['total_tasks'] = $this->Project_manager_model->get_total_tasks($user_id);
        $data['pending_tasks'] = $this->Project_manager_model->get_pending_tasks($user_id);
        $data['completed_tasks'] = $this->Project_manager_model->get_completed_tasks($user_id);
        $data['overdue_tasks'] = $this->Project_manager_model->get_overdue_tasks($user_id);
        
        // Projets récents
        $data['recent_projects'] = $this->Project_manager_model->get_recent_projects($user_id, 5);
        
        // Tâches urgentes
        $data['urgent_tasks'] = $this->Project_manager_model->get_urgent_tasks($user_id, 5);
        
        // Charge de travail par membre
        $data['team_workload'] = $this->Project_manager_model->get_team_workload($user_id);
        
        // Données pour les graphiques
        $data['project_status_chart'] = $this->Project_manager_model->get_project_status_distribution($user_id);
        $data['task_progress_chart'] = $this->Project_manager_model->get_task_progress_data($user_id);
        
        $this->load->view('project_manager/dashboard', $data);
    }

    public function projects() {
        // Liste des projets avec filtres
        $search = $this->input->get('search') ?: '';
        $status_filter = $this->input->get('status') ?: 'all';
        
        $projects = $this->project_manager_model->get_projects_with_filters($this->session->userdata('user_id'), $search, $status_filter);
        
        $data = [
            'projects' => $projects,
            'search' => $search,
            'status_filter' => $status_filter
        ];
        
        $this->load->view('project_manager/projects', $data);
    }

    public function create_project() {
        if ($this->input->post()) {
            $project_data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
                'user_id' => $this->session->userdata('user_id'),
                'start_date' => $this->input->post('start_date'),
                'end_date' => $this->input->post('end_date'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $project_id = $this->Project_manager_model->create_project($project_data);
            
            if ($project_id) {
                // Ajouter les membres de l'équipe
                $team_members = $this->input->post('team_members');
                if ($team_members) {
                    $this->Project_manager_model->add_team_members($project_id, $team_members);
                }
                
                $this->session->set_flashdata('success', 'Projet créé avec succès !');
                redirect('project_manager/projects');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la création du projet.');
            }
        }
        
        // Formulaire de création de projet
        $data['users'] = $this->project_manager_model->get_available_users();
        $this->load->view('project_manager/create_project', $data);
    }

    public function project_details($project_id) {
        $user_id = $this->session->userdata('user_id');
        
        // Vérifier que le projet appartient au chef de projet
        $project = $this->Project_manager_model->get_project_details($project_id, $user_id);
        if (!$project) {
            show_404();
        }
        
        $data['project'] = $project;
        $data['tasks'] = $this->Project_manager_model->get_project_tasks($project_id);
        $data['team_members'] = $this->Project_manager_model->get_project_team($project_id);
        $data['project_stats'] = $this->Project_manager_model->get_project_statistics($project_id);
        
        $this->load->view('project_manager/project_details', $data);
    }

    public function create_task($project_id) {
        $user_id = $this->session->userdata('user_id');
        
        // Vérifier que le projet appartient au chef de projet
        if (!$this->Project_manager_model->user_owns_project($project_id, $user_id)) {
            show_404();
        }
        
        if ($this->input->post()) {
            $task_data = [
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'project_id' => $project_id,
                'assigned_to' => $this->input->post('assigned_to'),
                'due_date' => $this->input->post('due_date'),
                'priority' => $this->input->post('priority'),
                'status' => 'À faire',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if ($this->Project_manager_model->create_task($task_data)) {
                $this->session->set_flashdata('success', 'Tâche créée avec succès.');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la création de la tâche.');
            }
            
            redirect('project_manager/project_details/' . $project_id);
        }
        
        $data['project'] = $this->Project_manager_model->get_project_details($project_id, $user_id);
        $data['team_members'] = $this->Project_manager_model->get_project_team($project_id);
        
        $this->load->view('project_manager/create_task', $data);
    }

    public function update_task_status() {
        $task_id = $this->input->post('task_id');
        $status = $this->input->post('status');
        $user_id = $this->session->userdata('user_id');
        
        // Vérifier que la tâche appartient à un projet du chef de projet
        if ($this->Project_manager_model->user_can_manage_task($task_id, $user_id)) {
            if ($this->Project_manager_model->update_task_status($task_id, $status)) {
                $this->session->set_flashdata('success', 'Statut de la tâche mis à jour.');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la mise à jour.');
            }
        }
        
        redirect($this->input->server('HTTP_REFERER'));
    }

    public function assign_task() {
        $task_id = $this->input->post('task_id');
        $assigned_to = $this->input->post('assigned_to');
        $user_id = $this->session->userdata('user_id');
        
        if ($this->Project_manager_model->user_can_manage_task($task_id, $user_id)) {
            if ($this->Project_manager_model->assign_task($task_id, $assigned_to)) {
                $this->session->set_flashdata('success', 'Tâche assignée avec succès.');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de l\'assignation.');
            }
        }
        
        redirect($this->input->server('HTTP_REFERER'));
    }

    public function analytics() {
        $user_id = $this->session->userdata('user_id');
        
        $data['project_analytics'] = $this->Project_manager_model->get_project_analytics($user_id);
        $data['team_performance'] = $this->Project_manager_model->get_team_performance($user_id);
        $data['timeline_data'] = $this->Project_manager_model->get_timeline_data($user_id);
        $data['workload_distribution'] = $this->Project_manager_model->get_workload_distribution($user_id);
        
        $this->load->view('project_manager/analytics', $data);
    }

    public function delete_project($project_id) {
        $user_id = $this->session->userdata('user_id');
        
        if ($this->Project_manager_model->user_owns_project($project_id, $user_id)) {
            if ($this->Project_manager_model->delete_project($project_id)) {
                $this->session->set_flashdata('success', 'Projet supprimé avec succès.');
            } else {
                $this->session->set_flashdata('error', 'Erreur lors de la suppression.');
            }
        }
        
        redirect('project_manager/projects');
    }
}

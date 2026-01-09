<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Statistiques des projets
    public function get_total_projects() {
        return $this->db->count_all('projects');
    }

    public function get_projects_by_status($status) {
        // Since projects table doesn't have status, we'll use task completion as indicator
        if ($status == 'termine') {
            // Projects with all tasks completed
            $this->db->select('projects.id');
            $this->db->from('projects');
            $this->db->join('tasks', 'tasks.project_id = projects.id', 'left');
            $this->db->group_by('projects.id');
            $this->db->having('COUNT(tasks.id) > 0 AND COUNT(CASE WHEN tasks.status != "Terminé" THEN 1 END) = 0');
            return $this->db->get()->num_rows();
        } elseif ($status == 'en_cours') {
            // Projects with at least one task not completed
            $this->db->select('projects.id');
            $this->db->from('projects');
            $this->db->join('tasks', 'tasks.project_id = projects.id', 'left');
            $this->db->group_by('projects.id');
            $this->db->having('COUNT(tasks.id) = 0 OR COUNT(CASE WHEN tasks.status != "Terminé" THEN 1 END) > 0');
            return $this->db->get()->num_rows();
        }
        return 0;
    }

    public function get_overdue_projects() {
        // Projects with overdue tasks
        $this->db->distinct();
        $this->db->select('projects.id');
        $this->db->from('projects');
        $this->db->join('tasks', 'tasks.project_id = projects.id');
        $this->db->where('tasks.due_date <', date('Y-m-d'));
        $this->db->where('tasks.status !=', 'Terminé');
        return $this->db->get()->num_rows();
    }

    // Statistiques des utilisateurs
    public function get_total_users() {
        return $this->db->count_all('users');
    }

    public function get_active_users() {
        // Utilisateurs qui ont créé au moins un projet
        $this->db->distinct();
        $this->db->select('user_id');
        $this->db->from('projects');
        $query = $this->db->get();
        return $query->num_rows();
    }

    // Statistiques des tâches
    public function get_total_tasks() {
        return $this->db->count_all('tasks');
    }

    public function get_completed_tasks() {
        $this->db->where('status', 'Terminé');
        return $this->db->count_all_results('tasks');
    }

    // Projets récents
    public function get_recent_projects($limit = 5) {
        $this->db->select('projects.*, users.username');
        $this->db->from('projects');
        $this->db->join('users', 'users.id = projects.user_id');
        // Assuming there's a created_at or similar timestamp field, otherwise use id
        if ($this->db->field_exists('created_at', 'projects')) {
            $this->db->order_by('projects.created_at', 'DESC');
        } else {
            $this->db->order_by('projects.id', 'DESC');
        }
        $this->db->limit($limit);
        $projects = $this->db->get()->result();
        
        // Add status based on tasks for each project
        foreach ($projects as $project) {
            $project->status = $this->get_project_status($project->id);
        }
        
        return $projects;
    }
    
    // Helper method to determine project status based on tasks
    private function get_project_status($project_id) {
        $this->db->select('COUNT(*) as total_tasks, COUNT(CASE WHEN status = "Terminé" THEN 1 END) as completed_tasks');
        $this->db->from('tasks');
        $this->db->where('project_id', $project_id);
        $result = $this->db->get()->row();
        
        if ($result->total_tasks == 0) {
            return 'en_cours'; // No tasks yet
        } elseif ($result->completed_tasks == $result->total_tasks) {
            return 'termine'; // All tasks completed
        } else {
            // Check if any tasks are overdue
            $this->db->where('project_id', $project_id);
            $this->db->where('due_date <', date('Y-m-d'));
            $this->db->where('status !=', 'Terminé');
            $overdue = $this->db->count_all_results('tasks');
            
            return $overdue > 0 ? 'en_retard' : 'en_cours';
        }
    }

    // Utilisateurs les plus actifs
    public function get_top_users($limit = 5) {
        $this->db->select('users.username, users.email, COUNT(projects.id) as project_count');
        $this->db->from('users');
        $this->db->join('projects', 'projects.user_id = users.id', 'left');
        $this->db->group_by('users.id');
        $this->db->order_by('project_count', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    // Statistiques par mois (pour les graphiques)
    public function get_projects_by_month() {
        $this->db->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count");
        $this->db->from('projects');
        $this->db->where('created_at >=', date('Y-m-d', strtotime('-12 months')));
        $this->db->group_by('month');
        $this->db->order_by('month', 'ASC');
        return $this->db->get()->result();
    }

    // Répartition des projets par statut (basé sur les tâches)
    public function get_projects_status_distribution() {
        // Calculer manuellement la distribution basée sur les tâches
        $total = $this->get_total_projects();
        $completed = $this->get_projects_by_status('termine');
        $in_progress = $this->get_projects_by_status('en_cours');
        $overdue = $this->get_overdue_projects();
        
        $result = [];
        if ($in_progress > 0) {
            $result[] = (object)['status' => 'en_cours', 'count' => $in_progress];
        }
        if ($completed > 0) {
            $result[] = (object)['status' => 'termine', 'count' => $completed];
        }
        if ($overdue > 0) {
            $result[] = (object)['status' => 'en_retard', 'count' => $overdue];
        }
        
        return $result;
    }

    // Gestion des utilisateurs
    public function get_users_with_filters($search = null, $role_filter = null, $status_filter = null, $date_filter = null) {
        $this->db->select('users.*, COUNT(projects.id) as project_count');
        $this->db->from('users');
        $this->db->join('projects', 'projects.user_id = users.id', 'left');
        
        // Filtres de recherche
        if ($search) {
            $this->db->group_start();
            $this->db->like('users.username', $search);
            $this->db->or_like('users.email', $search);
            $this->db->or_like('users.first_name', $search);
            $this->db->or_like('users.last_name', $search);
            $this->db->group_end();
        }
        
        // Filtre par rôle
        if ($role_filter && $role_filter !== 'all') {
            if ($this->db->field_exists('role', 'users')) {
                $this->db->where('users.role', $role_filter);
            }
        }
        
        // Filtre par statut
        if ($status_filter && $status_filter !== 'all') {
            if ($status_filter === 'active') {
                if ($this->db->field_exists('is_active', 'users')) {
                    $this->db->where('users.is_active', 1);
                } else {
                    $this->db->where('users.id >', 0); // Fallback si pas de champ is_active
                }
            } elseif ($status_filter === 'inactive') {
                if ($this->db->field_exists('is_active', 'users')) {
                    $this->db->where('users.is_active', 0);
                }
            }
        }
        
        // Filtre par date
        if ($date_filter) {
            switch ($date_filter) {
                case 'today':
                    if ($this->db->field_exists('created_at', 'users')) {
                        $this->db->where('DATE(users.created_at)', date('Y-m-d'));
                    }
                    break;
                case 'week':
                    if ($this->db->field_exists('created_at', 'users')) {
                        $this->db->where('users.created_at >=', date('Y-m-d', strtotime('-7 days')));
                    }
                    break;
                case 'month':
                    if ($this->db->field_exists('created_at', 'users')) {
                        $this->db->where('users.created_at >=', date('Y-m-d', strtotime('-30 days')));
                    }
                    break;
            }
        }
        
        $this->db->group_by('users.id');
        $this->db->order_by('users.id', 'DESC');
        
        return $this->db->get()->result();
    }

    public function get_user_details($user_id) {
        $this->db->select('users.*, COUNT(projects.id) as total_projects');
        $this->db->from('users');
        $this->db->join('projects', 'projects.user_id = users.id', 'left');
        $this->db->where('users.id', $user_id);
        $this->db->group_by('users.id');
        
        return $this->db->get()->row();
    }

    public function get_user_projects($user_id, $limit = 10) {
        $this->db->select('projects.*, COUNT(tasks.id) as total_tasks, COUNT(CASE WHEN tasks.status = "Terminé" THEN 1 END) as completed_tasks');
        $this->db->from('projects');
        $this->db->join('tasks', 'tasks.project_id = projects.id', 'left');
        $this->db->where('projects.user_id', $user_id);
        $this->db->group_by('projects.id');
        $this->db->order_by('projects.id', 'DESC');
        $this->db->limit($limit);
        
        $projects = $this->db->get()->result();
        
        // Ajouter le statut pour chaque projet
        foreach ($projects as $project) {
            $project->status = $this->get_project_status($project->id);
        }
        
        return $projects;
    }

    public function get_user_tasks($user_id, $limit = 10) {
        $this->db->select('tasks.*, projects.name as project_name');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->order_by('tasks.id', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    public function update_user_status($user_id, $status) {
        // Vérifier si le champ is_active existe
        if ($this->db->field_exists('is_active', 'users')) {
            $data = ['is_active' => $status];
            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
        return false;
    }

    public function delete_user($user_id) {
        // Supprimer d'abord les projets et tâches associées
        $projects = $this->db->get_where('projects', ['user_id' => $user_id])->result();
        
        foreach ($projects as $project) {
            // Supprimer les tâches du projet
            $this->db->delete('tasks', ['project_id' => $project->id]);
        }
        
        // Supprimer les projets
        $this->db->delete('projects', ['user_id' => $user_id]);
        
        // Supprimer l'utilisateur
        return $this->db->delete('users', ['id' => $user_id]);
    }
}

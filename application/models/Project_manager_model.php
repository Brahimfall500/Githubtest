<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_manager_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Statistiques des projets
    public function get_total_projects($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('projects');
    }

    public function get_active_projects($user_id) {
        $this->db->select('projects.id');
        $this->db->from('projects');
        $this->db->join('tasks', 'tasks.project_id = projects.id', 'left');
        $this->db->where('projects.user_id', $user_id);
        $this->db->group_by('projects.id');
        $this->db->having('COUNT(tasks.id) = 0 OR COUNT(CASE WHEN tasks.status != "Terminé" THEN 1 END) > 0');
        return $this->db->get()->num_rows();
    }

    public function get_completed_projects($user_id) {
        $this->db->select('projects.id');
        $this->db->from('projects');
        $this->db->join('tasks', 'tasks.project_id = projects.id', 'left');
        $this->db->where('projects.user_id', $user_id);
        $this->db->group_by('projects.id');
        $this->db->having('COUNT(tasks.id) > 0 AND COUNT(CASE WHEN tasks.status != "Terminé" THEN 1 END) = 0');
        return $this->db->get()->num_rows();
    }

    public function get_overdue_projects($user_id) {
        $this->db->distinct();
        $this->db->select('projects.id');
        $this->db->from('projects');
        $this->db->join('tasks', 'tasks.project_id = projects.id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->where('tasks.due_date <', date('Y-m-d'));
        $this->db->where('tasks.status !=', 'Terminé');
        return $this->db->get()->num_rows();
    }

    // Statistiques des tâches
    public function get_total_tasks($user_id) {
        $this->db->select('COUNT(tasks.id) as total');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('projects.user_id', $user_id);
        $result = $this->db->get()->row();
        return $result ? $result->total : 0;
    }

    public function get_pending_tasks($user_id) {
        $this->db->select('COUNT(tasks.id) as total');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->where_in('tasks.status', ['À faire', 'En cours']);
        $result = $this->db->get()->row();
        return $result ? $result->total : 0;
    }

    public function get_completed_tasks($user_id) {
        $this->db->select('COUNT(tasks.id) as total');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->where('tasks.status', 'Terminé');
        $result = $this->db->get()->row();
        return $result ? $result->total : 0;
    }

    public function get_overdue_tasks($user_id) {
        $this->db->select('COUNT(tasks.id) as total');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->where('tasks.due_date <', date('Y-m-d'));
        $this->db->where('tasks.status !=', 'Terminé');
        $result = $this->db->get()->row();
        return $result ? $result->total : 0;
    }

    // Projets récents
    public function get_recent_projects($user_id, $limit = 5) {
        $this->db->select('projects.*, COUNT(tasks.id) as total_tasks, COUNT(CASE WHEN tasks.status = "Terminé" THEN 1 END) as completed_tasks');
        $this->db->from('projects');
        $this->db->join('tasks', 'tasks.project_id = projects.id', 'left');
        $this->db->where('projects.user_id', $user_id);
        $this->db->group_by('projects.id');
        $this->db->order_by('projects.id', 'DESC');
        $this->db->limit($limit);
        
        $projects = $this->db->get()->result();
        
        // Ajouter le statut et la progression
        foreach ($projects as $project) {
            $project->status = $this->get_project_status($project->id);
            $project->progress = $project->total_tasks > 0 ? round(($project->completed_tasks / $project->total_tasks) * 100) : 0;
        }
        
        return $projects;
    }

    // Tâches urgentes
    public function get_urgent_tasks($user_id, $limit = 5) {
        $this->db->select('tasks.*, projects.name as project_name');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->where('tasks.due_date >=', date('Y-m-d'));
        $this->db->where('tasks.status !=', 'Terminé');
        $this->db->order_by('tasks.due_date', 'ASC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    // Charge de travail par membre (simulation avec utilisateurs actifs)
    public function get_team_workload($user_id) {
        // Retourner une liste simple d'utilisateurs avec des données simulées
        $this->db->select('users.username, users.id, 1 as project_count, 3 as task_count, 2 as completed_count');
        $this->db->from('users');
        $this->db->where('users.id !=', $user_id); // Exclure l'utilisateur actuel
        $this->db->limit(5);
        
        return $this->db->get()->result();
    }

    // Données pour graphiques
    public function get_project_status_distribution($user_id) {
        $active = $this->get_active_projects($user_id);
        $completed = $this->get_completed_projects($user_id);
        $overdue = $this->get_overdue_projects($user_id);
        
        return [
            'active' => $active,
            'completed' => $completed,
            'overdue' => $overdue
        ];
    }

    public function get_task_progress_data($user_id) {
        $total = $this->get_total_tasks($user_id);
        $completed = $this->get_completed_tasks($user_id);
        $pending = $this->get_pending_tasks($user_id);
        $overdue = $this->get_overdue_tasks($user_id);
        
        return [
            'total' => $total,
            'completed' => $completed,
            'pending' => $pending,
            'overdue' => $overdue
        ];
    }

    // Gestion des projets
    public function get_projects_with_filters($user_id, $search = null, $status_filter = null) {
        $this->db->select('projects.*, COUNT(tasks.id) as total_tasks, 
                          SUM(CASE WHEN tasks.status = "Terminé" THEN 1 ELSE 0 END) as completed_tasks,
                          CASE 
                            WHEN COUNT(tasks.id) = 0 THEN 0
                            ELSE ROUND((SUM(CASE WHEN tasks.status = "Terminé" THEN 1 ELSE 0 END) / COUNT(tasks.id)) * 100, 0)
                          END as progress');
        $this->db->from('projects');
        $this->db->join('tasks', 'tasks.project_id = projects.id', 'left');
        $this->db->where('projects.user_id', $user_id);
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('projects.name', $search);
            $this->db->or_like('projects.description', $search);
            $this->db->group_end();
        }
        
        if ($status_filter && $status_filter != 'all') {
            $this->db->where('projects.status', $status_filter);
        }
        
        $this->db->group_by('projects.id');
        $this->db->order_by('projects.created_at', 'DESC');
        
        return $this->db->get()->result();
    }

    public function create_project($project_data) {
        if ($this->db->insert('projects', $project_data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function get_available_users() {
        $this->db->select('id, username, email');
        $this->db->from('users');
        $this->db->where_in('role', ['user', 'project_manager']);
        $this->db->order_by('username', 'ASC');
        
        return $this->db->get()->result();
    }

    public function assign_team_members($project_id, $member_ids) {
        // Supprimer les anciens membres
        $this->db->where('project_id', $project_id);
        $this->db->delete('project_members');
        
        // Ajouter les nouveaux membres
        if (!empty($member_ids)) {
            foreach ($member_ids as $member_id) {
                $data = [
                    'project_id' => $project_id,
                    'user_id' => $member_id,
                    'added_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('project_members', $data);
            }
        }
        
        return true;
    }

    public function add_team_members($project_id, $member_ids) {
        // Créer une table project_members si elle n'existe pas
        if (!$this->db->table_exists('project_members')) {
            $this->create_project_members_table();
        }
        
        foreach ($member_ids as $member_id) {
            $data = [
                'project_id' => $project_id,
                'user_id' => $member_id,
                'added_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('project_members', $data);
        }
    }

    private function create_project_members_table() {
        $this->load->dbforge();
        
        $fields = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'project_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'added_at' => [
                'type' => 'DATETIME'
            ]
        ];
        
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('project_members');
    }

    public function get_project_details($project_id, $user_id) {
        $this->db->select('projects.*, COUNT(tasks.id) as total_tasks, COUNT(CASE WHEN tasks.status = "Terminé" THEN 1 END) as completed_tasks');
        $this->db->from('projects');
        $this->db->join('tasks', 'tasks.project_id = projects.id', 'left');
        $this->db->where('projects.id', $project_id);
        $this->db->where('projects.user_id', $user_id);
        $this->db->group_by('projects.id');
        
        $project = $this->db->get()->row();
        
        if ($project) {
            $project->status = $this->get_project_status($project->id);
            $project->progress = $project->total_tasks > 0 ? round(($project->completed_tasks / $project->total_tasks) * 100) : 0;
        }
        
        return $project;
    }

    public function get_project_tasks($project_id) {
        $this->db->select('tasks.*, users.username as assigned_user');
        $this->db->from('tasks');
        $this->db->join('users', 'users.id = tasks.assigned_to', 'left');
        $this->db->where('tasks.project_id', $project_id);
        $this->db->order_by('tasks.due_date', 'ASC');
        
        return $this->db->get()->result();
    }

    public function get_project_team($project_id) {
        if ($this->db->table_exists('project_members')) {
            $this->db->select('users.id, users.username, users.email');
            $this->db->from('users');
            $this->db->join('project_members', 'project_members.user_id = users.id');
            $this->db->where('project_members.project_id', $project_id);
            
            return $this->db->get()->result();
        }
        
        return [];
    }

    public function get_project_statistics($project_id) {
        $this->db->select('
            COUNT(tasks.id) as total_tasks,
            COUNT(CASE WHEN tasks.status = "Terminé" THEN 1 END) as completed_tasks,
            COUNT(CASE WHEN tasks.status = "En cours" THEN 1 END) as in_progress_tasks,
            COUNT(CASE WHEN tasks.status = "À faire" THEN 1 END) as todo_tasks,
            COUNT(CASE WHEN tasks.due_date < CURDATE() AND tasks.status != "Terminé" THEN 1 END) as overdue_tasks
        ');
        $this->db->from('tasks');
        $this->db->where('project_id', $project_id);
        
        return $this->db->get()->row();
    }

    public function create_task($task_data) {
        return $this->db->insert('tasks', $task_data);
    }

    public function user_owns_project($project_id, $user_id) {
        $this->db->where('id', $project_id);
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('projects') > 0;
    }

    public function user_can_manage_task($task_id, $user_id) {
        $this->db->select('projects.user_id');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('tasks.id', $task_id);
        $result = $this->db->get()->row();
        
        return $result && $result->user_id == $user_id;
    }

    public function update_task_status($task_id, $status) {
        $this->db->where('id', $task_id);
        return $this->db->update('tasks', ['status' => $status]);
    }

    public function assign_task($task_id, $assigned_to) {
        $this->db->where('id', $task_id);
        return $this->db->update('tasks', ['assigned_to' => $assigned_to]);
    }

    public function delete_project($project_id) {
        // Supprimer les tâches
        $this->db->delete('tasks', ['project_id' => $project_id]);
        
        // Supprimer les membres du projet
        if ($this->db->table_exists('project_members')) {
            $this->db->delete('project_members', ['project_id' => $project_id]);
        }
        
        // Supprimer le projet
        return $this->db->delete('projects', ['id' => $project_id]);
    }

    // Méthodes pour les analytics
    public function get_project_analytics($user_id) {
        // Évolution des projets par mois
        $this->db->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count");
        $this->db->from('projects');
        $this->db->where('user_id', $user_id);
        $this->db->where('created_at >=', date('Y-m-d', strtotime('-12 months')));
        $this->db->group_by('month');
        $this->db->order_by('month', 'ASC');
        
        return $this->db->get()->result();
    }

    public function get_team_performance($user_id) {
        $this->db->select('users.username, 
            COUNT(tasks.id) as total_tasks,
            COUNT(CASE WHEN tasks.status = "Terminé" THEN 1 END) as completed_tasks,
            AVG(CASE WHEN tasks.status = "Terminé" AND tasks.due_date IS NOT NULL 
                THEN DATEDIFF(tasks.updated_at, tasks.due_date) END) as avg_delay
        ');
        $this->db->from('users');
        $this->db->join('tasks', 'tasks.assigned_to = users.id', 'left');
        $this->db->join('projects', 'projects.id = tasks.project_id', 'left');
        $this->db->where('projects.user_id', $user_id);
        $this->db->group_by('users.id');
        $this->db->having('total_tasks > 0');
        
        return $this->db->get()->result();
    }

    public function get_timeline_data($user_id) {
        $this->db->select('tasks.title, tasks.due_date, tasks.status, projects.name as project_name');
        $this->db->from('tasks');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->where('tasks.due_date >=', date('Y-m-d'));
        $this->db->order_by('tasks.due_date', 'ASC');
        $this->db->limit(20);
        
        return $this->db->get()->result();
    }

    public function get_workload_distribution($user_id) {
        $this->db->select('users.username, COUNT(tasks.id) as task_count');
        $this->db->from('users');
        $this->db->join('tasks', 'tasks.assigned_to = users.id');
        $this->db->join('projects', 'projects.id = tasks.project_id');
        $this->db->where('projects.user_id', $user_id);
        $this->db->where('tasks.status !=', 'Terminé');
        $this->db->group_by('users.id');
        
        return $this->db->get()->result();
    }

    // Méthode helper pour déterminer le statut d'un projet
    private function get_project_status($project_id) {
        $this->db->select('COUNT(*) as total_tasks, COUNT(CASE WHEN status = "Terminé" THEN 1 END) as completed_tasks');
        $this->db->from('tasks');
        $this->db->where('project_id', $project_id);
        $result = $this->db->get()->row();
        
        if ($result->total_tasks == 0) {
            return 'nouveau';
        } elseif ($result->completed_tasks == $result->total_tasks) {
            return 'termine';
        } else {
            // Vérifier les retards
            $this->db->where('project_id', $project_id);
            $this->db->where('due_date <', date('Y-m-d'));
            $this->db->where('status !=', 'Terminé');
            $overdue = $this->db->count_all_results('tasks');
            
            return $overdue > 0 ? 'en_retard' : 'en_cours';
        }
    }
}

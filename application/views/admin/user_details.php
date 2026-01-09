<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails Utilisateur - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
        }
        .sidebar {
            min-height: 100vh;
            background: rgba(52, 58, 64, 0.95);
            backdrop-filter: blur(10px);
            color: #fff;
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 1rem 1.5rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0.2rem 0.5rem;
        }
        .sidebar a.active, .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .sidebar .sidebar-header {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 2rem 1.5rem 1rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .main-content {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 0.5rem;
            margin: 0.25rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        .info-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .stats-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 0.8rem;
            transition: all 0.3s ease;
            margin-bottom: 0.4rem;
            text-align: center;
            height: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            background: rgba(255,255,255,0.2);
        }
        .stats-number {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0.3rem 0;
            line-height: 1;
        }
        .stats-icon {
            font-size: 1.8rem;
            margin-bottom: 0.4rem;
            opacity: 0.9;
            display: block;
        }
        .table-container {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 0.8rem;
            margin-bottom: 0.6rem;
            max-height: 400px;
            overflow-y: auto;
        }
        .table-dark {
            background: transparent !important;
        }
        .table-dark td, .table-dark th {
            border-color: rgba(255,255,255,0.2);
            background: transparent;
        }
        .badge-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .status-en_cours { background: linear-gradient(45deg, #ffc107, #ff8c00); }
        .status-termine { background: linear-gradient(45deg, #28a745, #20c997); }
        .status-en_retard { background: linear-gradient(45deg, #dc3545, #fd7e14); }
        .admin-badge {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(45deg, #007bff, #0056b3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="sidebar-header">
                <i class="fas fa-crown"></i>
            </div>
            <a href="<?php echo site_url('admin'); ?>">
                <i class="fas fa-chart-line me-2"></i>Dashboard Admin
            </a>
            <a href="<?php echo site_url('admin/users'); ?>" class="active">
                <i class="fas fa-users me-2"></i>Gestion Utilisateurs
            </a>
            <a href="<?php echo site_url('dashboard'); ?>">
                <i class="fas fa-home me-2"></i>Dashboard Utilisateur
            </a>
            <a href="<?php echo site_url('projects'); ?>">
                <i class="fas fa-project-diagram me-2"></i>Tous les Projets
            </a>
            <a href="<?php echo site_url('tasks'); ?>">
                <i class="fas fa-list-check me-2"></i>Toutes les Tâches
            </a>
            <a href="<?php echo site_url('auth/logout'); ?>">
                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
            </a>
            <div class="mt-4 px-3 text-center">
                <div class="stats-card">
                    <i class="fas fa-user-shield stats-icon text-warning"></i>
                    <div>Connecté en tant qu'<br><b><?php echo $this->session->userdata('username'); ?></b>
                        <span class="admin-badge">ADMIN</span>
                    </div>
                </div>
            </div>
        </nav>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-2 py-2">
            <div class="main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-2 border-bottom border-light">
                    <h1 class="h4">
                        <a href="<?php echo site_url('admin/users'); ?>" class="text-light text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                        <i class="fas fa-user me-2"></i>Détails Utilisateur
                    </h1>
                    <div class="text-muted small">
                        <i class="fas fa-calendar me-1"></i>
                        <?php echo date('d/m/Y H:i'); ?>
                    </div>
                </div>

                <?php if ($user): ?>
                    <div class="row">
                        <!-- Informations utilisateur -->
                        <div class="col-md-4">
                            <div class="info-card text-center">
                                <div class="user-avatar mx-auto">
                                    <?php echo strtoupper(substr($user->username, 0, 1)); ?>
                                </div>
                                <h5><?php echo htmlspecialchars($user->username); ?></h5>
                                <?php if (isset($user->first_name) && isset($user->last_name)): ?>
                                    <p class="text-muted"><?php echo htmlspecialchars($user->first_name . ' ' . $user->last_name); ?></p>
                                <?php endif; ?>
                                <p class="mb-2">
                                    <i class="fas fa-envelope me-2"></i>
                                    <?php echo htmlspecialchars($user->email); ?>
                                </p>
                                
                                <?php 
                                $role = isset($user->role) ? $user->role : 'user';
                                $role_labels = [
                                    'admin' => '<span class="badge bg-danger">Admin</span>',
                                    'project_manager' => '<span class="badge bg-primary">Chef de projets</span>',
                                    'user' => '<span class="badge bg-secondary">Utilisateur</span>'
                                ];
                                echo isset($role_labels[$role]) ? $role_labels[$role] : $role_labels['user'];
                                ?>
                                
                                <?php 
                                $is_active = isset($user->is_active) ? $user->is_active : 1;
                                if ($is_active): ?>
                                    <span class="badge bg-success ms-2">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger ms-2">Inactif</span>
                                <?php endif; ?>
                                
                                <hr>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <strong class="text-primary"><?php echo $user->total_projects; ?></strong>
                                        <br><small>Projets</small>
                                    </div>
                                    <div class="col-6">
                                        <strong class="text-info"><?php echo $user->id; ?></strong>
                                        <br><small>ID Utilisateur</small>
                                    </div>
                                </div>
                                
                                <?php if (isset($user->created_at)): ?>
                                    <hr>
                                    <p class="text-muted small">
                                        <i class="fas fa-calendar-plus me-2"></i>
                                        Inscrit le <?php echo date('d/m/Y', strtotime($user->created_at)); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Projets de l'utilisateur -->
                        <div class="col-md-8">
                            <div class="table-container">
                                <h6 class="mb-3"><i class="fas fa-project-diagram me-2"></i>Projets de l'utilisateur</h6>
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover">
                                        <thead>
                                            <tr>
                                                <th>Projet</th>
                                                <th>Tâches</th>
                                                <th>Statut</th>
                                                <th>Progression</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($user_projects)): ?>
                                                <?php foreach ($user_projects as $project): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($project->name); ?></strong>
                                                            <br><small class="text-muted"><?php echo htmlspecialchars(substr($project->description, 0, 60)) . '...'; ?></small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary"><?php echo $project->total_tasks; ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-status status-<?php echo $project->status; ?>">
                                                                <?php 
                                                                switch($project->status) {
                                                                    case 'en_cours': echo 'En cours'; break;
                                                                    case 'termine': echo 'Terminé'; break;
                                                                    case 'en_retard': echo 'En retard'; break;
                                                                    default: echo ucfirst($project->status);
                                                                }
                                                                ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            $progress = $project->total_tasks > 0 ? round(($project->completed_tasks / $project->total_tasks) * 100) : 0;
                                                            ?>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                                                    <?php echo $progress; ?>%
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Aucun projet trouvé</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Tâches récentes -->
                            <div class="table-container">
                                <h6 class="mb-3"><i class="fas fa-tasks me-2"></i>Tâches récentes</h6>
                                <div class="table-responsive">
                                    <table class="table table-dark table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tâche</th>
                                                <th>Projet</th>
                                                <th>Statut</th>
                                                <th>Échéance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($user_tasks)): ?>
                                                <?php foreach ($user_tasks as $task): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($task->title); ?></strong>
                                                            <?php if (isset($task->description) && $task->description): ?>
                                                                <br><small class="text-muted"><?php echo htmlspecialchars(substr($task->description, 0, 50)) . '...'; ?></small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <small><?php echo htmlspecialchars($task->project_name); ?></small>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $status_class = '';
                                                            switch($task->status) {
                                                                case 'Terminé':
                                                                    $status_class = 'bg-success';
                                                                    break;
                                                                case 'En cours':
                                                                    $status_class = 'bg-warning';
                                                                    break;
                                                                default:
                                                                    $status_class = 'bg-secondary';
                                                            }
                                                            ?>
                                                            <span class="badge <?php echo $status_class; ?>"><?php echo htmlspecialchars($task->status); ?></span>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            if (isset($task->due_date) && $task->due_date) {
                                                                $due_date = date('d/m/Y', strtotime($task->due_date));
                                                                $is_overdue = strtotime($task->due_date) < time() && $task->status !== 'Terminé';
                                                                if ($is_overdue) {
                                                                    echo '<span class="text-danger">' . $due_date . '</span>';
                                                                } else {
                                                                    echo $due_date;
                                                                }
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Aucune tâche trouvée</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Utilisateur non trouvé.
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

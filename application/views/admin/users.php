<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Utilisateurs - Admin</title>
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
        .filter-container {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .table-container {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 0.8rem;
            margin-bottom: 0.6rem;
            max-height: 600px;
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
        .status-active { background: linear-gradient(45deg, #28a745, #20c997); }
        .status-inactive { background: linear-gradient(45deg, #dc3545, #fd7e14); }
        .admin-badge {
            background: linear-gradient(45deg, #6f42c1, #e83e8c);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            margin: 0.1rem;
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
                    <h1 class="h4"><i class="fas fa-users me-2"></i>Gestion des Utilisateurs</h1>
                    <div class="text-muted small">
                        <i class="fas fa-calendar me-1"></i>
                        <?php echo date('d/m/Y H:i'); ?>
                    </div>
                </div>

                <!-- Messages flash -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Statistiques rapides -->
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="stats-card">
                            <i class="fas fa-users stats-icon text-primary"></i>
                            <div class="stats-number text-primary"><?php echo $total_users; ?></div>
                            <div>Total Utilisateurs</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="stats-card">
                            <i class="fas fa-user-check stats-icon text-success"></i>
                            <div class="stats-number text-success"><?php echo $active_users; ?></div>
                            <div>Utilisateurs Actifs</div>
                        </div>
                    </div>
                </div>

                <!-- Filtres et recherche -->
                <div class="filter-container">
                    <form method="GET" action="<?php echo site_url('admin/users'); ?>" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Recherche</label>
                            <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Nom, email...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Rôle</label>
                            <select class="form-select" name="role">
                                <option value="all" <?php echo ($role_filter == 'all') ? 'selected' : ''; ?>>Tous</option>
                                <option value="user" <?php echo ($role_filter == 'user') ? 'selected' : ''; ?>>Utilisateur</option>
                                <option value="project_manager" <?php echo ($role_filter == 'project_manager') ? 'selected' : ''; ?>>Chef de projets</option>
                                <option value="admin" <?php echo ($role_filter == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Statut</label>
                            <select class="form-select" name="status">
                                <option value="all" <?php echo ($status_filter == 'all') ? 'selected' : ''; ?>>Tous</option>
                                <option value="active" <?php echo ($status_filter == 'active') ? 'selected' : ''; ?>>Actif</option>
                                <option value="inactive" <?php echo ($status_filter == 'inactive') ? 'selected' : ''; ?>>Inactif</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Période</label>
                            <select class="form-select" name="date_filter">
                                <option value="" <?php echo ($date_filter == '') ? 'selected' : ''; ?>>Toutes</option>
                                <option value="today" <?php echo ($date_filter == 'today') ? 'selected' : ''; ?>>Aujourd'hui</option>
                                <option value="week" <?php echo ($date_filter == 'week') ? 'selected' : ''; ?>>Cette semaine</option>
                                <option value="month" <?php echo ($date_filter == 'month') ? 'selected' : ''; ?>>Ce mois</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search me-1"></i>Filtrer
                                </button>
                                <a href="<?php echo site_url('admin/users'); ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Liste des utilisateurs -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Projets</th>
                                    <th>Statut</th>
                                    <th>Inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user->id; ?></td>
                                            <td>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($user->username); ?></strong>
                                                    <?php if (isset($user->first_name) && isset($user->last_name)): ?>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($user->first_name . ' ' . $user->last_name); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($user->email); ?></td>
                                            <td>
                                                <?php 
                                                $role = isset($user->role) ? $user->role : 'user';
                                                $role_labels = [
                                                    'admin' => '<span class="badge bg-danger">Admin</span>',
                                                    'project_manager' => '<span class="badge bg-primary">Chef de projets</span>',
                                                    'user' => '<span class="badge bg-secondary">Utilisateur</span>'
                                                ];
                                                echo isset($role_labels[$role]) ? $role_labels[$role] : $role_labels['user'];
                                                ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo $user->project_count; ?></span>
                                            </td>
                                            <td>
                                                <?php 
                                                $is_active = isset($user->is_active) ? $user->is_active : 1;
                                                if ($is_active): ?>
                                                    <span class="badge badge-status status-active">Actif</span>
                                                <?php else: ?>
                                                    <span class="badge badge-status status-inactive">Inactif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if (isset($user->created_at)) {
                                                    echo date('d/m/Y', strtotime($user->created_at));
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo site_url('admin/user_details/' . $user->id); ?>" class="btn btn-info btn-action" title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <?php if ($user->id != $this->session->userdata('user_id')): ?>
                                                        <?php if (isset($user->is_active) && $user->is_active): ?>
                                                            <form method="POST" action="<?php echo site_url('admin/toggle_user_status'); ?>" style="display: inline;">
                                                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                                <input type="hidden" name="action" value="deactivate">
                                                                <button type="submit" class="btn btn-warning btn-action" title="Désactiver" onclick="return confirm('Désactiver cet utilisateur ?')">
                                                                    <i class="fas fa-user-times"></i>
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <form method="POST" action="<?php echo site_url('admin/toggle_user_status'); ?>" style="display: inline;">
                                                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                                <input type="hidden" name="action" value="activate">
                                                                <button type="submit" class="btn btn-success btn-action" title="Activer" onclick="return confirm('Activer cet utilisateur ?')">
                                                                    <i class="fas fa-user-check"></i>
                                                                </button>
                                                            </form>
                                                        <?php endif; ?>
                                                        
                                                        <form method="POST" action="<?php echo site_url('admin/delete_user'); ?>" style="display: inline;">
                                                            <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                                                            <button type="submit" class="btn btn-danger btn-action" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Vous</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Aucun utilisateur trouvé</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

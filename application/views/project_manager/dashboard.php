<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Chef de Projet</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .chart-container {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 0.8rem;
            margin-bottom: 0.6rem;
            height: 250px;
        }
        .table-container {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 0.8rem;
            margin-bottom: 0.6rem;
            height: 250px;
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
        .status-nouveau { background: linear-gradient(45deg, #6c757d, #adb5bd); }
        .status-en_cours { background: linear-gradient(45deg, #ffc107, #ff8c00); }
        .status-termine { background: linear-gradient(45deg, #28a745, #20c997); }
        .status-en_retard { background: linear-gradient(45deg, #dc3545, #fd7e14); }
        .manager-badge {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }
        .progress-mini {
            height: 8px;
            border-radius: 4px;
        }
        .task-priority {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
        }
        .priority-high { background: #dc3545; }
        .priority-medium { background: #ffc107; color: #000; }
        .priority-low { background: #28a745; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="sidebar-header">
                <i class="fas fa-project-diagram"></i>
            </div>
            <a href="<?php echo site_url('project_manager'); ?>" class="active">
                <i class="fas fa-chart-line me-2"></i>Tableau de Bord
            </a>
            <a href="<?php echo site_url('project_manager/projects'); ?>">
                <i class="fas fa-folder me-2"></i>Mes Projets
            </a>
            <a href="<?php echo site_url('project_manager/create_project'); ?>">
                <i class="fas fa-plus me-2"></i>Nouveau Projet
            </a>
            <a href="<?php echo site_url('project_manager/analytics'); ?>">
                <i class="fas fa-chart-bar me-2"></i>Analytics
            </a>
            <a href="<?php echo site_url('dashboard'); ?>">
                <i class="fas fa-home me-2"></i>Dashboard Utilisateur
            </a>
            <a href="<?php echo site_url('auth/logout'); ?>">
                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
            </a>
            <div class="mt-4 px-3 text-center">
                <div class="stats-card">
                    <i class="fas fa-user-tie stats-icon text-primary"></i>
                    <div>Connecté en tant qu'<br><b><?php echo $this->session->userdata('username'); ?></b>
                        <span class="manager-badge">CHEF DE PROJET</span>
                    </div>
                </div>
            </div>
        </nav>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-2 py-2">
            <div class="main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-1 mb-2 border-bottom border-light">
                    <h1 class="h4"><i class="fas fa-chart-line me-2"></i>Tableau de Bord Chef de Projet</h1>
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

                <!-- Statistiques des projets -->
                <h6 class="mb-1"><i class="fas fa-project-diagram me-2"></i>Vue d'ensemble des Projets</h6>
                <div class="row mb-1">
                    <div class="col-md-3 col-sm-6">
                        <div class="stats-card">
                            <i class="fas fa-folder stats-icon text-primary"></i>
                            <div class="stats-number text-primary"><?php echo $total_projects; ?></div>
                            <div>Total Projets</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stats-card">
                            <i class="fas fa-spinner stats-icon text-warning"></i>
                            <div class="stats-number text-warning"><?php echo $active_projects; ?></div>
                            <div>Projets Actifs</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stats-card">
                            <i class="fas fa-check-circle stats-icon text-success"></i>
                            <div class="stats-number text-success"><?php echo $completed_projects; ?></div>
                            <div>Projets Terminés</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stats-card">
                            <i class="fas fa-exclamation-triangle stats-icon text-danger"></i>
                            <div class="stats-number text-danger"><?php echo $overdue_projects; ?></div>
                            <div>Projets en Retard</div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques des tâches -->
                <h6 class="mb-1"><i class="fas fa-tasks me-2"></i>Gestion des Tâches</h6>
                <div class="row mb-1">
                    <div class="col-md-3 col-sm-6">
                        <div class="stats-card">
                            <i class="fas fa-list stats-icon text-info"></i>
                            <div class="stats-number text-info"><?php echo $total_tasks; ?></div>
                            <div>Total Tâches</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stats-card">
                            <i class="fas fa-clock stats-icon text-warning"></i>
                            <div class="stats-number text-warning"><?php echo $pending_tasks; ?></div>
                            <div>Tâches en Cours</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stats-card">
                            <i class="fas fa-check-double stats-icon text-success"></i>
                            <div class="stats-number text-success"><?php echo $completed_tasks; ?></div>
                            <div>Tâches Terminées</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="stats-card">
                            <i class="fas fa-exclamation-circle stats-icon text-danger"></i>
                            <div class="stats-number text-danger"><?php echo $overdue_tasks; ?></div>
                            <div>Tâches en Retard</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Projets récents -->
                    <div class="col-md-12">
                        <div class="table-container">
                            <h6 class="mb-1"><i class="fas fa-folder-open me-2"></i>Projets Récents</h6>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Projet</th>
                                            <th>Statut</th>
                                            <th>Progression</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($recent_projects)): ?>
                                            <?php foreach ($recent_projects as $project): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?php echo htmlspecialchars($project->name); ?></strong>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars(substr($project->description, 0, 40)) . '...'; ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-status status-<?php echo $project->status; ?>">
                                                            <?php 
                                                            switch($project->status) {
                                                                case 'nouveau': echo 'Nouveau'; break;
                                                                case 'en_cours': echo 'En cours'; break;
                                                                case 'termine': echo 'Terminé'; break;
                                                                case 'en_retard': echo 'En retard'; break;
                                                                default: echo ucfirst($project->status);
                                                            }
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="progress progress-mini">
                                                            <div class="progress-bar" style="width: <?php echo $project->progress; ?>%"></div>
                                                        </div>
                                                        <small><?php echo $project->progress; ?>%</small>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo site_url('project_manager/project_details/' . $project->id); ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
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
                    </div>


                </div>

                <!-- Graphique des projets -->
                <div class="row mt-1">
                    <div class="col-md-12">
                        <div class="chart-container">
                            <h6 class="mb-1"><i class="fas fa-chart-pie me-2"></i>Répartition des Projets</h6>
                            <canvas id="projectsChart" width="250" height="120"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="<?php echo site_url('project_manager/create_project'); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nouveau Projet
                            </a>
                            <a href="<?php echo site_url('project_manager/projects'); ?>" class="btn btn-outline-light">
                                <i class="fas fa-folder me-2"></i>Voir Tous les Projets
                            </a>
                            <a href="<?php echo site_url('project_manager/analytics'); ?>" class="btn btn-outline-info">
                                <i class="fas fa-chart-bar me-2"></i>Analytics Détaillées
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Graphique en secteurs pour la répartition des projets
const ctx = document.getElementById('projectsChart').getContext('2d');
const projectsChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Actifs', 'Terminés', 'En Retard'],
        datasets: [{
            data: [<?php echo $project_status_chart['active']; ?>, <?php echo $project_status_chart['completed']; ?>, <?php echo $project_status_chart['overdue']; ?>],
            backgroundColor: [
                'rgba(255, 193, 7, 0.8)',
                'rgba(40, 167, 69, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ],
            borderColor: [
                'rgba(255, 193, 7, 1)',
                'rgba(40, 167, 69, 1)',
                'rgba(220, 53, 69, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        }
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Projets - Chef de Projet</title>
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
        .filter-container {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .project-card {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        .project-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            background: rgba(255,255,255,0.2);
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
        .progress-container {
            margin: 0.5rem 0;
        }
        .progress {
            height: 8px;
            border-radius: 4px;
            background: rgba(255,255,255,0.2);
        }
        .project-meta {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
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
                <i class="fas fa-project-diagram"></i>
            </div>
            <a href="<?php echo site_url('project_manager'); ?>">
                <i class="fas fa-chart-line me-2"></i>Tableau de Bord
            </a>
            <a href="<?php echo site_url('project_manager/projects'); ?>" class="active">
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
                    <h1 class="h4"><i class="fas fa-folder me-2"></i>Mes Projets</h1>
                    <div class="d-flex gap-2">
                        <a href="<?php echo site_url('project_manager/create_project'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Nouveau Projet
                        </a>
                        <div class="text-muted small align-self-center">
                            <i class="fas fa-calendar me-1"></i>
                            <?php echo date('d/m/Y H:i'); ?>
                        </div>
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

                <!-- Filtres -->
                <div class="filter-container">
                    <form method="GET" action="<?php echo site_url('project_manager/projects'); ?>" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Recherche</label>
                            <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Nom du projet...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Statut</label>
                            <select class="form-select" name="status">
                                <option value="all" <?php echo ($status_filter == 'all') ? 'selected' : ''; ?>>Tous</option>
                                <option value="nouveau" <?php echo ($status_filter == 'nouveau') ? 'selected' : ''; ?>>Nouveau</option>
                                <option value="en_cours" <?php echo ($status_filter == 'en_cours') ? 'selected' : ''; ?>>En cours</option>
                                <option value="termine" <?php echo ($status_filter == 'termine') ? 'selected' : ''; ?>>Terminé</option>
                                <option value="en_retard" <?php echo ($status_filter == 'en_retard') ? 'selected' : ''; ?>>En retard</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search me-1"></i>Filtrer
                                </button>
                                <a href="<?php echo site_url('project_manager/projects'); ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times me-1"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Liste des projets -->
                <div class="row">
                    <?php if (!empty($projects)): ?>
                        <?php foreach ($projects as $project): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="project-card">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($project->name); ?></h6>
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
                                    </div>
                                    
                                    <p class="text-muted small mb-2">
                                        <?php echo htmlspecialchars(substr($project->description, 0, 100)) . (strlen($project->description) > 100 ? '...' : ''); ?>
                                    </p>
                                    
                                    <div class="progress-container">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small>Progression</small>
                                            <small><strong><?php echo $project->progress; ?>%</strong></small>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?php echo $project->progress; ?>%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="project-meta mb-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <i class="fas fa-tasks me-1"></i>
                                                <small><?php echo $project->total_tasks; ?> tâches</small>
                                            </div>
                                            <div class="col-6">
                                                <i class="fas fa-check me-1"></i>
                                                <small><?php echo $project->completed_tasks; ?> terminées</small>
                                            </div>
                                        </div>
                                        
                                        <?php if (isset($project->start_date) && $project->start_date): ?>
                                            <div class="mt-1">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                <small>Début: <?php echo date('d/m/Y', strtotime($project->start_date)); ?></small>
                                                <?php if (isset($project->end_date) && $project->end_date): ?>
                                                    <br><i class="fas fa-calendar-check me-1"></i>
                                                    <small>Fin prévue: <?php echo date('d/m/Y', strtotime($project->end_date)); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo site_url('project_manager/project_details/' . $project->id); ?>" class="btn btn-outline-primary btn-action" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo site_url('project_manager/create_task/' . $project->id); ?>" class="btn btn-outline-success btn-action" title="Ajouter tâche">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                        
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-danger btn-action" title="Supprimer" onclick="confirmDelete(<?php echo $project->id; ?>, '<?php echo htmlspecialchars($project->name); ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun projet trouvé</h5>
                                <p class="text-muted">Commencez par créer votre premier projet !</p>
                                <a href="<?php echo site_url('project_manager/create_project'); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Créer un Projet
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer le projet <strong id="projectName"></strong> ?</p>
                <p class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Cette action supprimera également toutes les tâches associées et ne peut pas être annulée.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(projectId, projectName) {
    document.getElementById('projectName').textContent = projectName;
    document.getElementById('confirmDeleteBtn').href = '<?php echo site_url('project_manager/delete_project/'); ?>' + projectId;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

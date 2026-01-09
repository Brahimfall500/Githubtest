<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau Projet - Chef de Projet</title>
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
        .form-container {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 1rem;
        }
        .form-control, .form-select, .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255,255,255,0.6);
        }
        .form-label {
            color: rgba(255,255,255,0.9);
            font-weight: 500;
        }
        .manager-badge {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }
        .team-member-item {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 5px;
            padding: 0.5rem;
            margin: 0.2rem;
            display: inline-block;
        }
        .btn-outline-light:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
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
            <a href="<?php echo site_url('project_manager/projects'); ?>">
                <i class="fas fa-folder me-2"></i>Mes Projets
            </a>
            <a href="<?php echo site_url('project_manager/create_project'); ?>" class="active">
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
                    <h1 class="h4">
                        <a href="<?php echo site_url('project_manager/projects'); ?>" class="text-light text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                        <i class="fas fa-plus me-2"></i>Nouveau Projet
                    </h1>
                    <div class="text-muted small">
                        <i class="fas fa-calendar me-1"></i>
                        <?php echo date('d/m/Y H:i'); ?>
                    </div>
                </div>

                <!-- Messages flash -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="form-container">
                    <form method="POST" action="<?php echo site_url('project_manager/create_project'); ?>">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-project-diagram me-2"></i>Nom du Projet *
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" required 
                                           placeholder="Entrez le nom du projet">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">
                                        <i class="fas fa-align-left me-2"></i>Description
                                    </label>
                                    <textarea class="form-control" id="description" name="description" rows="4" 
                                              placeholder="Décrivez les objectifs et le contexte du projet"></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">
                                                <i class="fas fa-calendar-alt me-2"></i>Date de Début
                                            </label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                                   value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="end_date" class="form-label">
                                                <i class="fas fa-calendar-check me-2"></i>Date de Fin Prévue
                                            </label>
                                            <input type="date" class="form-control" id="end_date" name="end_date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-users me-2"></i>Membres de l'Équipe
                                    </label>
                                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto; background: rgba(255,255,255,0.05);">
                                        <?php if (!empty($users)): ?>
                                            <?php foreach ($users as $user): ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="team_members[]" value="<?php echo $user->id; ?>" 
                                                           id="user_<?php echo $user->id; ?>">
                                                    <label class="form-check-label" for="user_<?php echo $user->id; ?>">
                                                        <strong><?php echo htmlspecialchars($user->username); ?></strong>
                                                        <br><small class="text-muted"><?php echo htmlspecialchars($user->email); ?></small>
                                                    </label>
                                                </div>
                                                <hr class="my-2" style="border-color: rgba(255,255,255,0.2);">
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted small">Aucun utilisateur disponible</p>
                                        <?php endif; ?>
                                    </div>
                                    <small class="form-text text-muted">
                                        Sélectionnez les membres qui travailleront sur ce projet
                                    </small>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: rgba(255,255,255,0.3);">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <i class="fas fa-info-circle me-1"></i>
                                Les champs marqués d'un * sont obligatoires
                            </div>
                            <div class="d-flex gap-2">
                                <a href="<?php echo site_url('project_manager/projects'); ?>" class="btn btn-outline-light">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Créer le Projet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Guide rapide -->
                <div class="form-container">
                    <h6><i class="fas fa-lightbulb me-2"></i>Guide de Création de Projet</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-bullseye fa-2x text-primary mb-2"></i>
                                <h6>Définissez les Objectifs</h6>
                                <small class="text-muted">Décrivez clairement ce que le projet doit accomplir</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-calendar-alt fa-2x text-warning mb-2"></i>
                                <h6>Planifiez les Délais</h6>
                                <small class="text-muted">Fixez des dates réalistes pour le début et la fin</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="fas fa-users fa-2x text-success mb-2"></i>
                                <h6>Constituez l'Équipe</h6>
                                <small class="text-muted">Sélectionnez les membres avec les compétences requises</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-arrow-right me-1"></i>
                            Après création, vous pourrez ajouter des tâches et suivre l'avancement
                        </small>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Validation des dates
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = new Date(this.value);
    const endDateInput = document.getElementById('end_date');
    
    if (endDateInput.value) {
        const endDate = new Date(endDateInput.value);
        if (endDate < startDate) {
            endDateInput.value = '';
            alert('La date de fin doit être postérieure à la date de début');
        }
    }
    
    // Définir la date minimum pour la date de fin
    endDateInput.min = this.value;
});

document.getElementById('end_date').addEventListener('change', function() {
    const endDate = new Date(this.value);
    const startDate = new Date(document.getElementById('start_date').value);
    
    if (endDate < startDate) {
        this.value = '';
        alert('La date de fin doit être postérieure à la date de début');
    }
});

// Validation du formulaire
document.querySelector('form').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    
    if (!name) {
        e.preventDefault();
        alert('Le nom du projet est obligatoire');
        document.getElementById('name').focus();
        return false;
    }
    
    if (name.length < 3) {
        e.preventDefault();
        alert('Le nom du projet doit contenir au moins 3 caractères');
        document.getElementById('name').focus();
        return false;
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

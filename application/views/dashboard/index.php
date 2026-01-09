<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80');
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
            padding: 2rem;
            margin: 1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        .card-modern {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .card-modern:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            background: rgba(255,255,255,0.2);
        }
        .btn-modern {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #764ba2 0%, #667eea 100%);
        }
        .stats-card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        .icon-large {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="sidebar-header">
                <i class="fas fa-tasks"></i><br>
                Suivi Projets
            </div>
            <a href="<?php echo site_url('dashboard'); ?>" class="<?php echo uri_string() == 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-home me-2"></i>Dashboard
            </a>
            <a href="<?php echo site_url('projects'); ?>" class="<?php echo uri_string() == 'projects' ? 'active' : ''; ?>">
                <i class="fas fa-project-diagram me-2"></i>Mes Projets
            </a>
            <a href="<?php echo site_url('tasks'); ?>" class="<?php echo uri_string() == 'tasks' ? 'active' : ''; ?>">
                <i class="fas fa-list-check me-2"></i>Mes Tâches
            </a>
            <a href="<?php echo site_url('project_manager'); ?>">
                <i class="fas fa-user-tie me-2"></i>Dashboard Chef de Projet
            </a>
            <a href="<?php echo site_url('admin'); ?>">
                <i class="fas fa-crown me-2"></i>Dashboard Admin
            </a>
            <a href="<?php echo site_url('auth/logout'); ?>">
                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
            </a>
            <div class="mt-4 px-3 text-center">
                <div class="stats-card">
                    <i class="fas fa-user-circle icon-large"></i>
                    <div>Bienvenue, <b><?php echo $this->session->userdata('username'); ?></b></div>
                </div>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
            <div class="main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom border-light">
                    <h1 class="h2"><i class="fas fa-chart-line me-2"></i>Tableau de bord</h1>
                </div>
                <div class="row text-center">
                    <div class="col-md-6 mb-4">
                        <div class="card-modern">
                            <i class="fas fa-project-diagram icon-large text-success"></i>
                            <h4 class="card-title">Gérer mes projets</h4>
                            <p class="card-text">Créer, visualiser et supprimer vos projets.</p>
                            <a href="<?php echo site_url('projects'); ?>" class="btn btn-modern btn-success">
                                <i class="fas fa-eye me-2"></i>Voir mes projets
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card-modern">
                            <i class="fas fa-list-check icon-large text-info"></i>
                            <h4 class="card-title">Gérer mes tâches</h4>
                            <p class="card-text">Ajouter, visualiser et supprimer vos tâches par projet.</p>
                            <a href="<?php echo site_url('tasks'); ?>" class="btn btn-modern btn-info">
                                <i class="fas fa-eye me-2"></i>Voir mes tâches
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html> 
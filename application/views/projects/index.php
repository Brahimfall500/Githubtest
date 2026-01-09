<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Projets</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2015&q=80');
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
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            color: #222;
        }
        .table-modern {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
        }
        .table-modern th {
            background: #f8f9fa;
            border: none;
            color: #222;
            font-weight: 600;
        }
        .table-modern td {
            border: none;
            border-bottom: 1px solid #e9ecef;
            color: #222;
        }
        .table-modern tr:hover {
            background: #f1f3f4;
        }
        .btn-modern {
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            margin: 0 2px;
        }
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        .btn-create {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }
        .btn-create:hover {
            background: linear-gradient(45deg, #20c997, #28a745);
            color: white;
        }
        .btn-edit {
            background: linear-gradient(45deg, #007bff, #6610f2);
            color: white;
        }
        .btn-edit:hover {
            background: linear-gradient(45deg, #6610f2, #007bff);
            color: white;
        }
        .btn-delete {
            background: linear-gradient(45deg, #dc3545, #e83e8c);
            color: white;
        }
        .btn-delete:hover {
            background: linear-gradient(45deg, #e83e8c, #dc3545);
            color: white;
        }
        .stats-card {
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        .table-modern td, .table-modern th {
            color: #222;
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
            <a href="<?php echo site_url('dashboard'); ?>">
                <i class="fas fa-home me-2"></i>Dashboard
            </a>
            <a href="<?php echo site_url('projects'); ?>" class="active">
                <i class="fas fa-project-diagram me-2"></i>Mes Projets
            </a>
            <a href="<?php echo site_url('tasks'); ?>">
                <i class="fas fa-list-check me-2"></i>Mes Tâches
            </a>
            <a href="<?php echo site_url('auth/logout'); ?>">
                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
            </a>
            <div class="mt-4 px-3 text-center">
                <div class="stats-card">
                    <i class="fas fa-user-circle fa-2x mb-2"></i>
                    <div>Bienvenue, <b><?php echo $this->session->userdata('username'); ?></b></div>
                </div>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
            <div class="main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-project-diagram me-2"></i>Mes Projets</h2>
                    <a href="<?php echo site_url('projects/create'); ?>" class="btn btn-modern btn-create">
                        <i class="fas fa-plus me-2"></i>Nouveau Projet
                    </a>
                </div>
                <?php if (empty($projects)): ?>
                    <div class="alert alert-info" style="background: rgba(23, 162, 184, 0.2); border: 1px solid rgba(23, 162, 184, 0.3); color: white;">
                        <i class="fas fa-info-circle me-2"></i>Aucun projet pour l'instant.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-tag me-2"></i>Nom</th>
                                    <th><i class="fas fa-align-left me-2"></i>Description</th>
                                    <th><i class="fas fa-calendar me-2"></i>Date de création</th>
                                    <th><i class="fas fa-cogs me-2"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $project): ?>
                                    <tr>
                                        <td><i class="fas fa-folder me-2"></i><?php echo htmlspecialchars($project->name); ?></td>
                                        <td><?php echo htmlspecialchars($project->description); ?></td>
                                        <td><i class="fas fa-clock me-2"></i><?php echo htmlspecialchars($project->created_at); ?></td>
                                        <td>
                                            <a href="<?php echo site_url('projects/edit/'.$project->id); ?>" class="btn btn-modern btn-edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo site_url('projects/delete/'.$project->id); ?>" class="btn btn-modern btn-delete" onclick="return confirm('Supprimer ce projet ?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <a href="<?php echo site_url('dashboard'); ?>" class="btn btn-modern btn-secondary mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Retour au Dashboard
                </a>
            </div>
        </main>
    </div>
</div>
</body>
</html> 
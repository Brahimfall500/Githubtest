<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Tâche</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 1rem 1.5rem;
            transition: background 0.2s;
        }
        .sidebar a.active, .sidebar a:hover {
            background: #495057;
        }
        .sidebar .sidebar-header {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 2rem 1.5rem 1rem 1.5rem;
            border-bottom: 1px solid #495057;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="sidebar-header">Suivi Projets</div>
            <a href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
            <a href="<?php echo site_url('projects'); ?>">Mes Projets</a>
            <a href="<?php echo site_url('tasks'); ?>" class="active">Mes Tâches</a>
            <a href="<?php echo site_url('auth/logout'); ?>">Déconnexion</a>
            <div class="mt-4 px-3">
                <span>Bienvenue, <b><?php echo $this->session->userdata('username'); ?></b></span>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
            <div class="col-md-8 offset-md-2">
                <h2>Modifier la tâche</h2>
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
                <?php endif; ?>
                <?php echo form_open('tasks/edit/'.$task->id); ?>
                    <div class="mb-3">
                        <label for="project_id" class="form-label">Projet</label>
                        <select name="project_id" class="form-select" required>
                            <option value="">Sélectionner un projet</option>
                            <?php foreach($projects as $project): ?>
                                <option value="<?php echo $project->id; ?>" <?php echo ($project->id == $task->project_id) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($project->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($task->title); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description"><?php echo htmlspecialchars($task->description); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Statut</label>
                        <select name="status" class="form-select" required>
                            <option value="A faire" <?php echo ($task->status == 'A faire') ? 'selected' : ''; ?>>A faire</option>
                            <option value="En cours" <?php echo ($task->status == 'En cours') ? 'selected' : ''; ?>>En cours</option>
                            <option value="Terminé" <?php echo ($task->status == 'Terminé') ? 'selected' : ''; ?>>Terminé</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Date d'échéance</label>
                        <input type="date" class="form-control" name="due_date" value="<?php echo htmlspecialchars($task->due_date); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="<?php echo site_url('tasks'); ?>" class="btn btn-secondary">Annuler</a>
                <?php echo form_close(); ?>
            </div>
        </main>
    </div>
</div>
</body>
</html> 
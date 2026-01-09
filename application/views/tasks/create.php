<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle Tâche</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">Dashboard</a>
        <div class="d-flex">
            <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-outline-light">Déconnexion</a>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2>Créer une nouvelle tâche</h2>
            <?php if(validation_errors()): ?>
                <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
            <?php endif; ?>
            <?php echo form_open('tasks/create'); ?>
                <div class="mb-3">
                    <label for="project_id" class="form-label">Projet</label>
                    <select name="project_id" class="form-select" required>
                        <option value="">Sélectionner un projet</option>
                        <?php foreach($projects as $project): ?>
                            <option value="<?php echo $project->id; ?>"><?php echo htmlspecialchars($project->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Titre</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Statut</label>
                    <select name="status" class="form-select" required>
                        <option value="A faire">A faire</option>
                        <option value="En cours">En cours</option>
                        <option value="Terminé">Terminé</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label">Date d'échéance</label>
                    <input type="date" class="form-control" name="due_date">
                </div>
                <button type="submit" class="btn btn-success">Créer</button>
                <a href="<?php echo site_url('tasks'); ?>" class="btn btn-secondary">Annuler</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html> 
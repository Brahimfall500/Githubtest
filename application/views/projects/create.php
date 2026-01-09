<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau Projet</title>
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
            <h2>Créer un nouveau projet</h2>
            <?php if(validation_errors()): ?>
                <div class="alert alert-danger"><?php echo validation_errors(); ?></div>
            <?php endif; ?>
            <?php echo form_open('projects/create'); ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du projet</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Créer</button>
                <a href="<?php echo site_url('projects'); ?>" class="btn btn-secondary">Annuler</a>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
</body>
</html> 
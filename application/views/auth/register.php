<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            color: white;
            max-width: 450px;
            width: 100%;
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #28a745;
        }
        .form-control {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            color: white;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.15);
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.25);
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255,255,255,0.7);
        }
        .btn-register {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #20c997, #28a745);
        }
        .alert {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: white;
            border-radius: 10px;
        }
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        .login-link a {
            color: #28a745;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .login-link a:hover {
            color: #20c997;
        }
        .input-group-text {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.7);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="register-card">
                <div class="register-header">
                    <i class="fas fa-user-plus"></i>
                    <h3>Inscription</h3>
                    <p class="text-muted">Créez votre compte pour commencer</p>
                </div>
                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" style="background: rgba(40, 167, 69, 0.2); border: 1px solid rgba(40, 167, 69, 0.3);">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                <?php echo form_open('auth/register'); ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-2"></i>Nom d'utilisateur
                        </label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Mot de passe
                        </label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">
                            <i class="fas fa-lock me-2"></i>Confirmer le mot de passe
                        </label>
                        <input type="password" class="form-control" name="password_confirm" required>
                    </div>
                    <button type="submit" class="btn btn-register">
                        <i class="fas fa-user-plus me-2"></i>S'inscrire
                    </button>
                <?php echo form_close(); ?>
                <div class="login-link">
                    <a href="<?php echo site_url('auth/login'); ?>">
                        <i class="fas fa-sign-in-alt me-2"></i>Déjà un compte ? Se connecter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> 
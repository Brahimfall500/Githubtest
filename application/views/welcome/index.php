<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suivi Projets - Gestion de projets et tâches</title>
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
            color: white;
        }
        .hero-section {
            padding: 100px 0;
            text-align: center;
        }
        .hero-title {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .features-section {
            padding: 80px 0;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }
        .feature-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #667eea;
        }
        .btn-hero {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 30px;
            padding: 15px 40px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            margin: 0 10px;
        }
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #764ba2, #667eea);
            color: white;
        }
        .btn-outline-hero {
            background: transparent;
            border: 2px solid #667eea;
            border-radius: 30px;
            padding: 15px 40px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            color: #667eea;
            margin: 0 10px;
        }
        .btn-outline-hero:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        .navbar {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-tasks me-2"></i>Suivi Projets
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="<?php echo site_url('auth/login'); ?>">Connexion</a>
                <a class="nav-link" href="<?php echo site_url('auth/register'); ?>">Inscription</a>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">Suivi Projets</h1>
            <p class="hero-subtitle">La solution complète pour gérer vos projets et tâches efficacement</p>
            <div class="mt-4">
                <a href="<?php echo site_url('auth/register'); ?>" class="btn btn-hero">
                    <i class="fas fa-user-plus me-2"></i>Commencer gratuitement
                </a>
                <a href="<?php echo site_url('auth/login'); ?>" class="btn btn-outline-hero">
                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                </a>
            </div>
        </div>
    </div>

    <div class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-project-diagram feature-icon"></i>
                        <h4>Gestion de Projets</h4>
                        <p>Créez et organisez vos projets avec des descriptions détaillées. Suivez l'avancement de chaque projet facilement.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-list-check feature-icon"></i>
                        <h4>Gestion de Tâches</h4>
                        <p>Ajoutez des tâches à vos projets, définissez des priorités et suivez leur statut (À faire, En cours, Terminé).</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-users feature-icon"></i>
                        <h4>Multi-utilisateurs</h4>
                        <p>Chaque utilisateur peut créer ses propres projets et tâches. Interface sécurisée et personnalisée.</p>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-calendar-alt feature-icon"></i>
                        <h4>Échéances</h4>
                        <p>Définissez des dates d'échéance pour vos tâches et gardez une vue d'ensemble de vos deadlines.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h4>Dashboard Moderne</h4>
                        <p>Interface intuitive avec navigation latérale et design moderne pour une expérience utilisateur optimale.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h4>Sécurisé</h4>
                        <p>Authentification sécurisée avec hashage des mots de passe et protection des données utilisateur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4">
        <div class="container">
            <p>&copy; 2025 Suivi Projets. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html> 
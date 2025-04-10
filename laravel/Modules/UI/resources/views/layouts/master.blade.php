<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SaluteOra - Promozione della salute orale per le gestanti in condizioni di vulnerabilità socio-economica">
    <meta name="author" content="SaluteOra">
    <title>@yield('title', 'SaluteOra - Salute Orale per Gestanti')</title>

    <!-- Favicon -->
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #4D77FF;
            --secondary-color: #F9AFDD;
            --accent-color: #5BCDFA;
            --light-color: #F8F9FA;
            --dark-color: #2A2A2A;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-color);
            background-color: #ffffff;
            line-height: 1.6;
        }
        
        .navbar-brand img {
            height: 50px;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: white;
        }
        
        .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: color 0.3s;
        }
        
        .nav-link:hover, .nav-link:focus {
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            border-radius: 30px;
        }
        
        .btn-primary:hover {
            background-color: #3a5dcc;
            border-color: #3a5dcc;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            border-radius: 30px;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .hero-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        .section {
            padding: 5rem 0;
        }
        
        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            margin-bottom: 1.5rem;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 3rem 0;
        }
        
        .footer a {
            color: rgba(255,255,255,0.8);
            transition: color 0.3s;
        }
        
        .footer a:hover {
            color: white;
            text-decoration: none;
        }
        
        .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        
        .social-icons a:hover {
            background-color: var(--primary-color);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light py-3">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <span class="fw-bold text-primary">Salute<span class="text-secondary">Ora</span></span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/chi-siamo">Chi Siamo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/servizi">Servizi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/contatti">Contatti</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-primary" href="/verificare-idoneita">Verificare Idoneità</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="text-white">SaluteOra</h5>
                    <p class="text-light">Promozione della salute orale per le gestanti in condizioni di vulnerabilità socio-economica</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 mb-4 mb-lg-0">
                    <h6 class="text-white">Links Rapidi</h6>
                    <ul class="list-unstyled">
                        <li><a href="/">Home</a></li>
                        <li><a href="/chi-siamo">Chi Siamo</a></li>
                        <li><a href="/servizi">Servizi</a></li>
                        <li><a href="/contatti">Contatti</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <h6 class="text-white">Servizi</h6>
                    <ul class="list-unstyled">
                        <li><a href="/verificare-idoneita">Verificare Idoneità</a></li>
                        <li><a href="/prenotare-visita">Prenotare Visita</a></li>
                        <li><a href="/risorse-educative">Risorse Educative</a></li>
                        <li><a href="/faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white">Contatti</h6>
                    <address class="text-light">
                        <p><i class="fas fa-map-marker-alt me-2"></i> Via Roma 123, 00100 Roma</p>
                        <p><i class="fas fa-phone me-2"></i> +39 06 1234567</p>
                        <p><i class="fas fa-envelope me-2"></i> info@saluteora.it</p>
                    </address>
                </div>
            </div>
            <hr class="bg-light mt-4 mb-4">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-light">© 2025 SaluteOra. Tutti i diritti riservati.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="/privacy-policy" class="text-light me-3">Privacy Policy</a>
                    <a href="/termini-condizioni" class="text-light">Termini e Condizioni</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>

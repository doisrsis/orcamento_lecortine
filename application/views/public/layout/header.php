<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Le Cortine - Orçamento Online' ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/img/favicon.png') ?>" type="image/png">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Customizado -->
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2691E;
            --accent-color: #F4A460;
            --dark-color: #2C1810;
            --light-color: #F5F5DC;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f5dc 0%, #fff 100%);
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .progress-container {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 900px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .step-progress {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-bottom: 3rem;
        }
        
        .step-progress::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 4px;
            background: #e0e0e0;
            z-index: 0;
        }
        
        .step-progress-bar {
            position: absolute;
            top: 20px;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            z-index: 1;
            transition: width 0.3s ease;
        }
        
        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .step.active .step-circle {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            box-shadow: 0 4px 15px rgba(139, 69, 19, 0.4);
            transform: scale(1.1);
        }
        
        .step.completed .step-circle {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff;
        }
        
        .step-label {
            font-size: 0.75rem;
            color: #666;
            font-weight: 500;
        }
        
        .step.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .card-form {
            background: #fff;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        .card-form h2 {
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 69, 19, 0.3);
        }
        
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }
        
        .product-card {
            border: 3px solid #e0e0e0;
            border-radius: 15px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .product-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .product-card.selected {
            border-color: var(--primary-color);
            background: linear-gradient(135deg, rgba(139, 69, 19, 0.05), rgba(210, 105, 30, 0.05));
        }
        
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="ti ti-home-2"></i> Le Cortine
            </a>
            <span class="navbar-text text-white">
                <i class="ti ti-phone"></i> (11) 99999-9999
            </span>
        </div>
    </nav>

    <!-- Conteúdo -->
    <div class="container py-4">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'WinAudit' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #1e1e1e;
            --sidebar-bg: #252526;
            --text-color: #d4d4d4;
            --accent-color: #007acc;
            --border-color: #333333;
        }

        [data-theme="high-contrast"] {
            --bg-color: #000000;
            --sidebar-bg: #000000;
            --text-color: #ffffff;
            --accent-color: #ffff00;
            --border-color: #ffffff;
        }

        [data-theme="light"] {
            --bg-color: #ffffff;
            --sidebar-bg: #f3f3f3;
            --text-color: #333333;
            --accent-color: #007acc;
            --border-color: #cccccc;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            padding-top: 20px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .sidebar a {
            color: var(--text-color);
            text-decoration: none;
            padding: 10px 20px;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--accent-color);
            color: #fff;
        }

        .card {
            background-color: var(--sidebar-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
        }

        .table {
            color: var(--text-color);
        }

        .table th {
            border-bottom: 2px solid var(--border-color);
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .navbar {
            background-color: var(--sidebar-bg);
            border-bottom: 1px solid var(--border-color);
            margin-left: 250px;
            padding: 10px 20px;
        }
    </style>
</head>
<body data-theme="<?= session()->get('theme') ?? 'dark' ?>">

<div class="sidebar">
    <div class="text-center mb-4">
        <h4><i class="fas fa-shield-alt"></i> WinAudit</h4>
    </div>
    <a href="/dashboard" class="<?= current_url() == base_url('dashboard') ? 'active' : '' ?>"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
    <a href="/servers" class="<?= strpos(current_url(), 'servers') !== false ? 'active' : '' ?>"><i class="fas fa-server me-2"></i> Servers</a>
    <a href="/upload" class="<?= strpos(current_url(), 'upload') !== false ? 'active' : '' ?>"><i class="fas fa-upload me-2"></i> Upload Audit</a>
    <a href="/history" class="<?= strpos(current_url(), 'history') !== false ? 'active' : '' ?>"><i class="fas fa-history me-2"></i> Audit History</a>
    <hr class="mx-3">
    <div class="px-3 mb-2">Themes:</div>
    <div class="d-flex justify-content-around px-3">
        <a href="/theme/switch/dark" title="Dark"><i class="fas fa-moon"></i></a>
        <a href="/theme/switch/light" title="Light"><i class="fas fa-sun"></i></a>
        <a href="/theme/switch/high-contrast" title="High Contrast"><i class="fas fa-adjust"></i></a>
    </div>
    <a href="/auth/logout" class="mt-auto"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
</div>

<div class="navbar d-flex justify-content-between">
    <span class="navbar-brand mb-0 h1"><?= $title ?></span>
    <div>
        <span class="me-3"><i class="fas fa-user-circle me-1"></i> <?= session()->get('username') ?></span>
    </div>
</div>

<div class="main-content">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

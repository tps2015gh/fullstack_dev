<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Central Tracker' ?></title>
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
        body { background-color: var(--bg-color); color: var(--text-color); font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 250px; height: 100vh; position: fixed; background-color: var(--sidebar-bg); border-right: 1px solid var(--border-color); padding-top: 20px; }
        .main-content { margin-left: 250px; padding: 20px; }
        .sidebar a { color: var(--text-color); text-decoration: none; padding: 10px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background-color: var(--accent-color); color: #fff; }
        .card { background-color: var(--sidebar-bg); border: 1px solid var(--border-color); color: var(--text-color); }
        .table { color: var(--text-color); }
        .navbar { background-color: var(--sidebar-bg); border-bottom: 1px solid var(--border-color); margin-left: 250px; padding: 10px 20px; }
        .badge-bug { background-color: #f44336; }
        .badge-plan { background-color: #9c27b0; }
        .badge-request { background-color: #2196f3; }
        .badge-task { background-color: #4caf50; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="text-center mb-4">
        <h4><i class="fas fa-tasks"></i> IssueTracker</h4>
    </div>
    <a href="/dashboard" class="<?= current_url() == base_url('dashboard') ? 'active' : '' ?>"><i class="fas fa-chart-pie me-2"></i> Dashboard</a>
    <a href="/projects" class="<?= strpos(current_url(), 'projects') !== false ? 'active' : '' ?>"><i class="fas fa-layer-group me-2"></i> My Applications</a>
    <a href="/issues" class="<?= strpos(current_url(), 'issues') !== false ? 'active' : '' ?>"><i class="fas fa-list-ul me-2"></i> All Issues</a>
    <a href="/issues/add" class="btn btn-primary mx-3 mt-3"><i class="fas fa-plus me-2"></i> New Issue</a>
</div>

<div class="navbar d-flex justify-content-between">
    <span class="navbar-brand mb-0 h1"><?= $title ?></span>
</div>

<div class="main-content">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success bg-success text-white border-0"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

</body>
</html>

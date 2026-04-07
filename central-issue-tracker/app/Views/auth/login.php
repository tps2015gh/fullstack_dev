<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WinAudit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e1e1e; color: #d4d4d4; }
        .login-card { background-color: #252526; border: 1px solid #333; margin-top: 100px; padding: 20px; }
        .btn-primary { background-color: #007acc; border: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="login-card rounded shadow">
                <h3 class="text-center mb-4"><i class="fas fa-shield-alt"></i> WinAudit Login</h3>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger small"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <form action="/auth/login" method="post">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control bg-dark text-light border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control bg-dark text-light border-secondary" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="mt-3 text-center small text-secondary">
                    <em>Default credentials configured by administrator</em>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

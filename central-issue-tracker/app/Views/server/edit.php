<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <h3><i class="fas fa-edit me-2"></i> Edit Server</h3>
    <a href="/servers" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left me-2"></i> Back to Servers</a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-secondary">
                <i class="fas fa-server me-2"></i> Server Details
            </div>
            <div class="card-body">
                <form action="/servers/update/<?= $server['id'] ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label>Hostname</label>
                        <input type="text" name="hostname" class="form-control bg-dark text-light border-secondary" value="<?= $server['hostname'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>IP Address</label>
                        <input type="text" name="ip_address" class="form-control bg-dark text-light border-secondary" value="<?= $server['ip_address'] ?>">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select bg-dark text-light border-secondary">
                            <option value="online" <?= $server['status'] === 'online' ? 'selected' : '' ?>>Online</option>
                            <option value="warning" <?= $server['status'] === 'warning' ? 'selected' : '' ?>>Warning</option>
                            <option value="offline" <?= $server['status'] === 'offline' ? 'selected' : '' ?>>Offline</option>
                        </select>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Server</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-secondary">
                <i class="fas fa-history me-2"></i> Last Audit
            </div>
            <div class="card-body">
                <?php if ($lastAudit): ?>
                    <div class="mb-3">
                        <label class="text-secondary small">Upload Date</label>
                        <p class="text-light"><?= $lastAudit['upload_date'] ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary small">Summary</label>
                        <p class="text-light"><?= $lastAudit['summary'] ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary small">JSON File</label>
                        <p class="text-light small"><?= $lastAudit['raw_json_path'] ?></p>
                    </div>
                    <a href="/history" class="btn btn-sm btn-outline-info"><i class="fas fa-list me-2"></i>View Full History</a>
                <?php else: ?>
                    <div class="text-center text-secondary py-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>No audit data available for this server yet.</p>
                        <a href="/upload" class="btn btn-sm btn-primary"><i class="fas fa-upload me-2"></i>Upload Audit</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

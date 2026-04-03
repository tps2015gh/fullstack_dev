<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <h3><i class="fas fa-server me-2"></i> Managed Servers</h3>
    <a href="/servers/add" class="btn btn-sm btn-primary"><i class="fas fa-plus me-2"></i> Add Server</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Hostname</th>
                    <th>IP Address</th>
                    <th>OS</th>
                    <th>Status</th>
                    <th>Last Audit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servers as $server): ?>
                <tr>
                    <td><?= $server['hostname'] ?></td>
                    <td><?= $server['ip_address'] ?></td>
                    <td><?= $server['os_name'] ?></td>
                    <td>
                        <span class="badge bg-<?= $server['status'] == 'online' ? 'success' : ($server['status'] == 'warning' ? 'warning' : 'danger') ?>">
                            <?= ucfirst($server['status']) ?>
                        </span>
                    </td>
                    <td><?= $server['last_audit_at'] ?? 'Never' ?></td>
                    <td>
                        <a href="/servers/edit/<?= $server['id'] ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-edit"></i></a>
                        <a href="/servers/delete/<?= $server['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($servers)): ?>
                <tr>
                    <td colspan="6" class="text-center text-secondary">No servers managed yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

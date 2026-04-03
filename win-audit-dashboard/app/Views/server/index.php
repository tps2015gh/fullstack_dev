<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <div>
        <h3><i class="fas fa-server me-2"></i> Managed Servers</h3>
        <small class="text-secondary"><i class="fas fa-info-circle me-1"></i>Status is set from latest audit upload. Online = audited, Warning = needs attention, Offline = not responding. Last audit time shown below status.</small>
    </div>
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
                    <td>
                        <?= $server['os_name'] ?>
                        <?php if ($server['security_patch_count'] > 0): ?>
                            <br><small class="text-danger"><i class="fas fa-shield-alt me-1"></i><?= $server['security_patch_count'] ?> security patches</small>
                        <?php elseif ($server['total_patch_count'] > 0): ?>
                            <br><small class="text-secondary"><i class="fas fa-download me-1"></i><?= $server['total_patch_count'] ?> patches</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge bg-<?= $server['status'] == 'online' ? 'success' : ($server['status'] == 'warning' ? 'warning' : 'danger') ?>">
                            <?= ucfirst($server['status']) ?>
                        </span>
                        <?php if ($server['last_audit_at']): ?>
                            <br><small class="text-secondary" title="Last audit"><i class="fas fa-clock me-1"></i><?= date('H:i:s', strtotime($server['last_audit_at'])) ?></small>
                        <?php endif; ?>
                    </td>
                    <td><?= $server['last_audit_at'] ?? 'Never' ?></td>
                    <td>
                        <a href="/servers/detail/<?= $server['id'] ?>" class="btn btn-sm btn-outline-secondary me-1"><i class="fas fa-eye"></i></a>
                        <a href="/servers/edit/<?= $server['id'] ?>" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-edit"></i></a>
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

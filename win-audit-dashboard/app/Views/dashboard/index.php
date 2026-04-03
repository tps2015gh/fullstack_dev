<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <h6 class="text-secondary">Total Servers</h6>
                <h2><?= $totalServers ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <h6 class="text-secondary text-success">Online</h6>
                <h2><?= $onlineServers ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <h6 class="text-secondary text-warning">Warning</h6>
                <h2><?= $warningServers ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header border-secondary">
        <i class="fas fa-history me-2"></i> Recent Audits
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Server</th>
                    <th>Date</th>
                    <th>Summary</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentAudits as $audit): ?>
                <tr>
                    <td><?= $audit['hostname'] ?></td>
                    <td><?= $audit['upload_date'] ?></td>
                    <td><?= $audit['summary'] ?></td>
                    <td>
                        <a href="/history" class="btn btn-sm btn-outline-info">View All</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($recentAudits)): ?>
                <tr>
                    <td colspan="4" class="text-center text-secondary">No audits found. Use the Go agent and upload JSON.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

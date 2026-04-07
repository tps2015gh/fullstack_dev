<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center">
                <h6 class="text-secondary">Tracked Applications</h6>
                <h2><?= $totalProjects ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body text-center border-start border-warning border-4">
                <h6 class="text-warning">Open Issues</h6>
                <h2><?= $openIssues ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header border-secondary d-flex justify-content-between">
        <span><i class="fas fa-history me-2"></i> Recent Activity</span>
        <a href="/issues/add" class="btn btn-sm btn-outline-primary">New Task</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>App</th>
                    <th>Issue</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentIssues as $issue): ?>
                <tr>
                    <td class="text-info"><?= $issue['project_name'] ?></td>
                    <td><strong><?= $issue['title'] ?></strong></td>
                    <td>
                        <span class="badge badge-<?= $issue['type'] ?>"><?= ucfirst($issue['type']) ?></span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <?= str_replace('_', ' ', ucfirst($issue['status'])) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="/issues/status/<?= $issue['id'] ?>/in_progress">In Progress</a></li>
                                <li><a class="dropdown-item" href="/issues/status/<?= $issue['id'] ?>/completed">Completed</a></li>
                                <li><a class="dropdown-item" href="/issues/status/<?= $issue['id'] ?>/closed">Closed</a></li>
                            </ul>
                        </div>
                    </td>
                    <td><small class="text-secondary"><?= date('d M Y', strtotime($issue['created_at'])) ?></small></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($recentIssues)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-secondary">No issues found. Start by adding your apps and tasks!</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

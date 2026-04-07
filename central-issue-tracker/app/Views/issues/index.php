<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <h3><i class="fas fa-list-ul me-2"></i> All Logged Issues</h3>
    <a href="/issues/add" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Log New Issue</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>App</th>
                    <th>Issue Title</th>
                    <th>Type</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($issues as $issue): ?>
                <tr>
                    <td class="text-info"><?= $issue['project_name'] ?></td>
                    <td><strong><?= $issue['title'] ?></strong></td>
                    <td><span class="badge badge-<?= $issue['type'] ?>"><?= ucfirst($issue['type']) ?></span></td>
                    <td>
                        <span class="text-<?= $issue['priority'] == 'critical' ? 'danger' : ($issue['priority'] == 'high' ? 'warning' : 'secondary') ?>">
                            <?= ucfirst($issue['priority']) ?>
                        </span>
                    </td>
                    <td><?= str_replace('_', ' ', ucfirst($issue['status'])) ?></td>
                    <td><?= $issue['due_date'] ?? '-' ?></td>
                    <td>
                        <a href="/issues/delete/<?= $issue['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this issue?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

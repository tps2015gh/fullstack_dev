<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h3><i class="fas fa-history me-2"></i> Audit History</h3>

<div class="card mt-4">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Server</th>
                    <th>Date</th>
                    <th>Summary</th>
                    <th>Raw JSON</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $h): ?>
                <tr>
                    <td><?= $h['hostname'] ?></td>
                    <td><?= $h['upload_date'] ?></td>
                    <td><?= $h['summary'] ?></td>
                    <td><span class="badge bg-dark"><?= basename($h['raw_json_path']) ?></span></td>
                    <td>
                        <a href="/history/delete/<?= $h['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($history)): ?>
                <tr>
                    <td colspan="5" class="text-center text-secondary">No audit history found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

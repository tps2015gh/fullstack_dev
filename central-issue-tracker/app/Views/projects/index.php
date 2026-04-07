<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <h3><i class="fas fa-layer-group me-2"></i> Intranet Applications</h3>
    <a href="/projects/add" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Add App</a>
</div>

<div class="row">
    <?php foreach ($projects as $project): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100 border-0 border-top border-primary border-4">
            <div class="card-body">
                <h5 class="card-title"><?= $project['name'] ?></h5>
                <p class="card-text text-secondary small"><?= $project['description'] ?></p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="badge bg-dark"><?= ucfirst($project['status']) ?></span>
                    <a href="/projects/delete/<?= $project['id'] ?>" class="text-danger" onclick="return confirm('Delete this application tracking?')"><i class="fas fa-trash"></i></a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($projects)): ?>
    <div class="col-12 text-center py-5">
        <i class="fas fa-folder-open fa-3x text-secondary mb-3"></i>
        <p class="text-secondary">No applications registered yet.</p>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

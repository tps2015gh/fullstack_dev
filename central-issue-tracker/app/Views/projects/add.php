<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card col-md-6 mx-auto">
    <div class="card-header border-secondary">Register New Application</div>
    <div class="card-body">
        <form action="/projects/save" method="post">
            <div class="mb-3">
                <label class="form-label">Application Name</label>
                <input type="text" name="name" class="form-control bg-dark text-light border-secondary" required placeholder="e.g. Inventory System">
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control bg-dark text-light border-secondary" rows="3"></textarea>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Save Application</button>
                <a href="/projects" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

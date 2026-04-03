<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card col-md-6 mx-auto">
    <div class="card-header border-secondary">
        <i class="fas fa-plus me-2"></i> Add New Server
    </div>
    <div class="card-body">
        <form action="/servers/save" method="post">
            <div class="mb-3">
                <label>Hostname</label>
                <input type="text" name="hostname" class="form-control bg-dark text-light border-secondary" required>
            </div>
            <div class="mb-3">
                <label>IP Address</label>
                <input type="text" name="ip_address" class="form-control bg-dark text-light border-secondary">
            </div>
            <div class="mb-3">
                <label>Initial Status</label>
                <select name="status" class="form-select bg-dark text-light border-secondary">
                    <option value="online">Online</option>
                    <option value="warning">Warning</option>
                    <option value="offline">Offline</option>
                </select>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/servers" class="btn btn-secondary me-md-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Server</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

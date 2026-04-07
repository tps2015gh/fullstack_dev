<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card col-md-8 mx-auto">
    <div class="card-header border-secondary text-primary">Create New Task / Report Bug</div>
    <div class="card-body">
        <form action="/issues/save" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary">Target Application</label>
                    <select name="project_id" class="form-select bg-dark text-light border-secondary" required>
                        <option value="">Select App...</option>
                        <?php foreach ($projects as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary">Issue Type</label>
                    <select name="type" class="form-select bg-dark text-light border-secondary">
                        <option value="task">Task</option>
                        <option value="bug">Bug Fix</option>
                        <option value="plan">Plan / Roadmap</option>
                        <option value="request">User Request</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary">Title</label>
                <input type="text" name="title" class="form-control bg-dark text-light border-secondary" required placeholder="Short summary of the task">
            </div>

            <div class="mb-3">
                <label class="form-label text-secondary">Description / Notes</label>
                <textarea name="description" class="form-control bg-dark text-light border-secondary" rows="5" placeholder="Detail explanation or steps to reproduce if bug"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary">Priority</label>
                    <select name="priority" class="form-select bg-dark text-light border-secondary">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label text-secondary">Due Date (Optional)</label>
                    <input type="date" name="due_date" class="form-control bg-dark text-light border-secondary">
                </div>
            </div>

            <div class="d-grid gap-2 mt-3">
                <button type="submit" class="btn btn-primary btn-lg">Create Issue</button>
                <a href="/dashboard" class="btn btn-outline-secondary">Back to Dashboard</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

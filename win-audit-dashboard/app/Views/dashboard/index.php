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
        <?php if (empty($recentAudits)): ?>
            <div class="text-center text-secondary py-5">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>No audits found. Use the Go agent and upload JSON.</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($recentAudits as $audit): ?>
                <div class="col-md-12 mb-3">
                    <div class="card border-info">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-server me-2"></i><strong><?= $audit['hostname'] ?></strong>
                                <span class="badge bg-info ms-2"><?= $audit['upload_date'] ?></span>
                            </div>
                            <div>
                                <?php if (isset($audit['security_patch_count'])): ?>
                                    <span class="badge bg-danger me-1"><i class="fas fa-shield-alt me-1"></i><?= $audit['security_patch_count'] ?> Security</span>
                                <?php endif; ?>
                                <?php if (isset($audit['os_patch_count'])): ?>
                                    <span class="badge bg-warning me-1"><i class="fab fa-windows me-1"></i><?= $audit['os_patch_count'] ?> OS</span>
                                <?php endif; ?>
                                <small class="text-secondary"><?= basename($audit['raw_json_path']) ?></small>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if ($audit['full_data']): ?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <h6 class="text-info"><i class="fab fa-windows me-2"></i>OS Information</h6>
                                        <table class="table table-sm table-borderless text-light small">
                                            <tbody>
                                                <tr>
                                                    <td class="text-secondary" style="width: 40%">Name:</td>
                                                    <td><?= $audit['full_data']['os_info']['name'] ?? 'N/A' ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-secondary">Version:</td>
                                                    <td><?= $audit['full_data']['os_info']['version'] ?? 'N/A' ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-secondary">Architecture:</td>
                                                    <td><?= $audit['full_data']['os_info']['architecture'] ?? 'N/A' ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="text-info"><i class="fas fa-microchip me-2"></i>Hardware</h6>
                                        <table class="table table-sm table-borderless text-light small">
                                            <tbody>
                                                <tr>
                                                    <td class="text-secondary" style="width: 40%">CPU:</td>
                                                    <td><?= $audit['full_data']['hardware_info']['cpu'] ?? 'N/A' ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-secondary">RAM:</td>
                                                    <td><?= $audit['full_data']['hardware_info']['ram_total'] ?? 'N/A' ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="text-info"><i class="fas fa-shield-alt me-2"></i>Security</h6>
                                        <table class="table table-sm table-borderless text-light small">
                                            <tbody>
                                                <tr>
                                                    <td class="text-secondary" style="width: 40%">Antivirus:</td>
                                                    <td><?= $audit['full_data']['security_info']['av_status'] ?? 'N/A' ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-secondary">Firewall:</td>
                                                    <td><?= $audit['full_data']['security_info']['firewall_status'] ?? 'N/A' ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <?php if (!empty($audit['full_data']['system_updates'])): ?>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h6 class="text-info"><i class="fas fa-download me-2"></i>Installed Patches (<?= count($audit['full_data']['system_updates']) ?> total)</h6>
                                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                            <table class="table table-sm table-dark table-hover small">
                                                <thead class="border-secondary">
                                                    <tr>
                                                        <th>HotFix ID</th>
                                                        <th>Type</th>
                                                        <th>Description</th>
                                                        <th>Installed On</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($audit['full_data']['system_updates'] as $update): ?>
                                                    <tr>
                                                        <td><code><?= $update['hotfix_id'] ?? 'N/A' ?></code></td>
                                                        <td>
                                                            <?php if (($update['type'] ?? '') === 'Security Update'): ?>
                                                                <span class="badge bg-danger">Security</span>
                                                            <?php elseif (($update['type'] ?? '') === 'Cumulative Update'): ?>
                                                                <span class="badge bg-primary">Cumulative</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary"><?= $update['type'] ?? 'Update' ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $update['description'] ?? 'N/A' ?></td>
                                                        <td><?= $update['installed_on'] ?? 'N/A' ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($audit['full_data']['network_info'])): ?>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <h6 class="text-info"><i class="fas fa-network-wired me-2"></i>Network</h6>
                                        <div class="text-light small">
                                            <?php foreach ($audit['full_data']['network_info'] as $iface): ?>
                                                <div class="mb-1">
                                                    <strong class="text-secondary"><?= $iface['name'] ?>:</strong> 
                                                    IPs: <?= implode(', ', $iface['ips'] ?? []) ?> | 
                                                    MAC: <?= $iface['mac'] ?? 'N/A' ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-secondary mb-0"><?= $audit['summary'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer border-secondary">
                            <div class="d-flex justify-content-between">
                                <small class="text-secondary"><?= $audit['summary'] ?></small>
                                <a href="/history" class="btn btn-sm btn-outline-info">View Full History</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

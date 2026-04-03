<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <h3><i class="fas fa-server me-2"></i> Server Details: <?= $server['hostname'] ?></h3>
    <div>
        <a href="/servers/edit/<?= $server['id'] ?>" class="btn btn-sm btn-warning me-2"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="/servers" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back to Servers</a>
    </div>
</div>

<?php if ($fullAuditData): ?>
    <!-- Audit Summary Header -->
    <div class="card mb-4 border-info">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-clipboard-check me-2"></i><strong>Last Audit: <?= $server['hostname'] ?></strong>
                <span class="badge bg-info ms-2"><?= $lastAudit['upload_date'] ?></span>
            </div>
            <div>
                <?php 
                $securityCount = 0;
                $osCount = 0;
                if (isset($fullAuditData['system_updates'])) {
                    foreach ($fullAuditData['system_updates'] as $update) {
                        if (($update['type'] ?? '') === 'Security Update') {
                            $securityCount++;
                        } else {
                            $osCount++;
                        }
                    }
                }
                ?>
                <?php if ($securityCount > 0): ?>
                    <span class="badge bg-danger me-1"><i class="fas fa-shield-alt me-1"></i><?= $securityCount ?> Security</span>
                <?php endif; ?>
                <?php if ($osCount > 0): ?>
                    <span class="badge bg-warning me-1"><i class="fab fa-windows me-1"></i><?= $osCount ?> OS</span>
                <?php endif; ?>
                <small class="text-secondary ms-2"><?= basename($lastAudit['raw_json_path']) ?></small>
            </div>
        </div>
    </div>

    <!-- Main Details Grid -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-header border-secondary">
                    <i class="fab fa-windows me-2"></i>OS Information
                </div>
                <div class="card-body">
                    <table class="table table-borderless text-light small mb-0">
                        <tbody>
                            <tr>
                                <td class="text-secondary" style="width: 35%">Name:</td>
                                <td><?= $fullAuditData['os_info']['name'] ?? $server['os_name'] ?? 'N/A' ?></td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Version:</td>
                                <td><?= $fullAuditData['os_info']['version'] ?? $server['os_version'] ?? 'N/A' ?></td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Architecture:</td>
                                <td><?= $fullAuditData['os_info']['architecture'] ?? 'N/A' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-header border-secondary">
                    <i class="fas fa-microchip me-2"></i>Hardware
                </div>
                <div class="card-body">
                    <table class="table table-borderless text-light small mb-0">
                        <tbody>
                            <tr>
                                <td class="text-secondary" style="width: 35%">CPU:</td>
                                <td><?= $fullAuditData['hardware_info']['cpu'] ?? 'N/A' ?></td>
                            </tr>
                            <tr>
                                <td class="text-secondary">RAM:</td>
                                <td><?= $fullAuditData['hardware_info']['ram_total'] ?? 'N/A' ?></td>
                            </tr>
                            <?php if (!empty($fullAuditData['hardware_info']['disk_partitions'])): ?>
                            <tr>
                                <td class="text-secondary">Disks:</td>
                                <td>
                                    <?php foreach ($fullAuditData['hardware_info']['disk_partitions'] as $disk): ?>
                                        <div><?= $disk['device'] ?>: <?= number_format($disk['total_size_gb'], 1) ?> GB (<?= number_format($disk['free_space_gb'], 1) ?> free)</div>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-header border-secondary">
                    <i class="fas fa-shield-alt me-2"></i>Security
                </div>
                <div class="card-body">
                    <table class="table table-borderless text-light small mb-0">
                        <tbody>
                            <tr>
                                <td class="text-secondary" style="width: 35%">Antivirus:</td>
                                <td><?= str_replace("\r\n", '<br>', $fullAuditData['security_info']['av_status'] ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <td class="text-secondary">Firewall:</td>
                                <td><?= str_replace("\r\n", '<br>', $fullAuditData['security_info']['firewall_status'] ?? 'N/A') ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Network Information -->
    <?php if (!empty($fullAuditData['network_info'])): ?>
    <div class="card mb-4 border-secondary">
        <div class="card-header border-secondary">
            <i class="fas fa-network-wired me-2"></i>Network Interfaces
        </div>
        <div class="card-body p-0">
            <table class="table table-dark table-hover small mb-0">
                <thead>
                    <tr>
                        <th>Interface</th>
                        <th>IP Addresses</th>
                        <th>MAC Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fullAuditData['network_info'] as $iface): ?>
                    <tr>
                        <td><strong><?= $iface['name'] ?></strong></td>
                        <td><code><?= implode(', ', $iface['ips'] ?? []) ?></code></td>
                        <td><?= $iface['mac'] ?? 'N/A' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- Installed Patches -->
    <?php if (!empty($fullAuditData['system_updates'])): ?>
    <div class="card border-secondary">
        <div class="card-header border-secondary d-flex justify-content-between align-items-center">
            <span><i class="fas fa-download me-2"></i>Installed Patches (<?= count($fullAuditData['system_updates']) ?> total)</span>
            <div>
                <span class="badge bg-danger"><?= $securityCount ?> Security</span>
                <span class="badge bg-secondary"><?= $osCount ?> OS</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-dark table-hover small mb-0">
                    <thead class="border-secondary" style="position: sticky; top: 0; background: #1a1d20;">
                        <tr>
                            <th>HotFix ID</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Installed On</th>
                            <th>Installed By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fullAuditData['system_updates'] as $update): ?>
                        <tr>
                            <td><code><?= $update['hotfix_id'] ?? 'N/A' ?></code></td>
                            <td>
                                <?php if (($update['type'] ?? '') === 'Security Update'): ?>
                                    <span class="badge bg-danger">Security</span>
                                <?php elseif (($update['type'] ?? '') === 'Cumulative Update'): ?>
                                    <span class="badge bg-primary">Cumulative</span>
                                <?php elseif (($update['type'] ?? '') === 'Feature Update'): ?>
                                    <span class="badge bg-success">Feature</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= $update['type'] ?? 'Update' ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $update['description'] ?? 'N/A' ?></td>
                            <td><?= $update['installed_on'] ?? 'N/A' ?></td>
                            <td><small><?= $update['installed_by'] ?? 'N/A' ?></small></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

<?php else: ?>
    <div class="card border-warning">
        <div class="card-body text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h5>No Audit Data Available</h5>
            <p class="text-secondary">There is no audit data available for this server. Please run the WinAudit agent and upload the JSON file.</p>
            <a href="/upload" class="btn btn-primary"><i class="fas fa-upload me-2"></i>Upload Audit</a>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

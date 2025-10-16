<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?= $pager->links('default', 'bootstrap') ?>

<div class="container mt-4">
    <h3>Rekap Absensi</h3>

    <form method="get" action="<?= base_url('absensi/rekap') ?>" class="mb-3 d-flex gap-2">
        <input type="date" name="start_date" value="<?= esc($startDate) ?>" class="form-control" required>
        <input type="date" name="end_date" value="<?= esc($endDate) ?>" class="form-control" required>
        <button class="btn btn-primary">Filter</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($rekap)): ?>
                <?php foreach ($rekap as $r): ?>
                    <tr>
                        <td><?= esc($r['tanggal']) ?></td>
                        <td><?= esc($r['jam_masuk']) ?: '-' ?></td>
                        <td><?= esc($r['jam_keluar']) ?: '-' ?></td>
                        <td><?= esc($r['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data absensi</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
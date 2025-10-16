<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h3>Dashboard Guru</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rekap as $r): ?>
            <tr>
                <td><?= esc($r['nama']) ?></td>
                <td><?= esc($r['tanggal']) ?></td>
                <td><?= esc($r['jam_masuk']) ?></td>
                <td><?= esc($r['jam_keluar']) ?></td>
                <td><?= esc($r['status']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
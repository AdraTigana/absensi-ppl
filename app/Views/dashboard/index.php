<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row mt-4">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="mb-3">Selamat datang, <?= esc($nama) ?>!</h4>
                <p class="text-muted mb-4">Peran kamu: <b><?= esc(ucfirst($role)) ?></b></p>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <div id="absensi-container" class="d-flex gap-2">
                    <?php if (!$absen): ?>
                        <button id="btnCheckIn" class="btn btn-success flex-fill">Check In</button>
                        <button class="btn btn-secondary flex-fill" disabled>Check Out</button>
                    <?php elseif ($absen['jam_keluar'] === null): ?>
                        <button class="btn btn-secondary flex-fill" disabled>Check In</button>
                        <button id="btnCheckOut" class="btn btn-danger flex-fill">Check Out</button>
                    <?php else: ?>
                        <button class="btn btn-secondary flex-fill" disabled>Check In</button>
                        <button class="btn btn-secondary flex-fill" disabled>Check Out</button>
                    <?php endif; ?>
                </div>



                <hr>

                <div class="mt-3">
                    <h6>Riwayat Absensi Hari Ini</h6>
                    <table class="table table-sm table-bordered mt-2">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($absen): ?>
                                <tr>
                                    <td><?= esc($absen['tanggal']) ?></td>
                                    <td><?= esc($absen['jam_masuk'] ?? '-') ?></td>
                                    <td><?= esc($absen['jam_keluar'] ?? '-') ?></td>
                                    <td><span id="status-text"><?= esc($statusHariIni) ?></span></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td><?= date('Y-m-d') ?></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>Belum absen</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
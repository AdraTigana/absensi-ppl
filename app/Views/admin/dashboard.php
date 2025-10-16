<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Manajemen User</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUser">+ Tambah User</button>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($users as $u): ?>
                <tr data-id="<?= $u['id'] ?>">
                    <td><?= $no++ ?></td>
                    <td><?= $u['nama'] ?></td>
                    <td><?= $u['email'] ?></td>
                    <td><?= $u['role'] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-edit"
                            data-id="<?= $u['id'] ?>"
                            data-nama="<?= $u['nama'] ?>"
                            data-email="<?= $u['email'] ?>"
                            data-role="<?= $u['role'] ?>">Edit</button>
                        <button class="btn btn-danger btn-sm deleteBtn"
                            data-id="<?= $u['id']; ?>">
                            Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?= $this->include('admin/user_modal') ?>

<script src="<?= base_url('js/admin.js') ?>"></script>

<?= $this->endSection() ?>
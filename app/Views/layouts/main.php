<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Absensi PPL' ?></title>
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .card {
            border-radius: 1rem;
        }

        .btn {
            border-radius: .75rem;
        }
    </style>

</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/<?= session()->get('role') ?>/dashboard">Absensi PPL</a>

            <?php if (session()->get('isLoggedIn')): ?>
                <div>
                    <span class="text-white me-2"><?= esc(session()->get('nama')) ?></span>
                    <a href="/logout" class="btn btn-sm btn-danger">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>


    <div class="container py-4">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url('js/admin.js') ?>"></script>

    <script>
        $(function() {
            function refreshStatus() {
                $.get('/absensi/status', function(data) {
                    $('#status-text').text(data.status);
                    let html = '';

                    if (data.canCheckIn) {
                        html = `
                    <button id="btnCheckIn" class="btn btn-success flex-fill">Check In</button>
                    <button class="btn btn-secondary flex-fill" disabled>Check Out</button>`;
                    } else if (data.canCheckOut) {
                        html = `
                    <button class="btn btn-secondary flex-fill" disabled>Check In</button>
                    <button id="btnCheckOut" class="btn btn-danger flex-fill">Check Out</button>`;
                    } else {
                        html = `
                    <button class="btn btn-secondary flex-fill" disabled>Check In</button>
                    <button class="btn btn-secondary flex-fill" disabled>Check Out</button>`;
                    }

                    $('#absensi-container').html(html);
                }, 'json');
            }

            // Check-in/out event handler
            $(document).on('click', '#btnCheckIn, #btnCheckOut', function() {
                const url = $(this).attr('id') === 'btnCheckIn' ? '/absensi/checkin' : '/absensi/checkout';
                const btn = $(this);

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.post(url, {}, function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    refreshStatus();
                }).fail(function(xhr) {
                    const res = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: res?.message || 'Terjadi kesalahan!'
                    });
                }).always(() => {
                    btn.prop('disabled', false);
                });
            });

            // auto-refresh tiap 15 detik
            setInterval(refreshStatus, 1000);
        });
    </script>


</body>

</html>
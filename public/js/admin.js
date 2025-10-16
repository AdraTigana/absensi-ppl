$(document).ready(function() {

    // CREATE user
    $('#formUser').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/admin/create',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire('Berhasil!', res.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal menghubungi server', 'error');
            }
        });
    });

    // EDIT user
    $(document).on('click', '.btn-edit', function() {
        $('#edit_id').val($(this).data('id'));
        $('#edit_nama').val($(this).data('nama'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_role').val($(this).data('role'));
        $('#modalEditUser').modal('show');
    });

    $('#formEditUser').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/admin/update',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    $('#modalEditUser').modal('hide');
                    Swal.fire('Berhasil!', res.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal menghubungi server', 'error');
            }
        });
    });

    // DELETE user
    $(document).on('click', '.deleteBtn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Yakin mau hapus?',
            text: 'Data user ini akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/delete', // sama seperti update
                    method: 'POST',
                    data: { id: id }, // kirim id lewat body
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire('Terhapus!', res.message, 'success');
                            setTimeout(() => location.reload(), 800);
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal menghubungi server', 'error');
                    }
                });
            }
        });
    });

});

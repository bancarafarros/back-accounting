$(function() {
    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('kasbank/datatable') ?>",
            "type": "POST"
        },
        "columnDefs": [{
                "targets": [0],
                "orderable": false,
            },
            {
                "targets": [1],
                "orderable": false,
            },
        ],
        'dom': 'rtip',
        // "fixedColumns": {
        // "left": 4,
        // "right": 1
        // }
    });

    $('#formAddjurnal').on('keyup keypress', function(e) {
        if (e.which == 13) {
            e.preventDefault();
        }
    });

    $(document).ready(function() {
        $('#save').hide();
        $('#editJurnSave').hide();
        $("#modal-add").on('shown.bs.modal', function() {
            $(this).find('#reff').focus();
            $(this).find('#reff').select();
            $('#sum_baris').val(0)
        });
        //focus modal
        $('#myModalAkun').on('shown.bs.modal', function() {
            $('input[type="search"]').val("");
            $('input[type="search"]').focus();
        });
        $('#myModalAkun').on('keydown', 'input[type="search"]', function(e) {
            if (e.which == 13) {
                $('.chsAkn:first').focus();
            }
        });
        $('#myModalAkun').on('hidden.bs.modal', function() {
            $('#adddebet' + $('#cekIndex').val()).focus();
        });

        $('.lookup').DataTable({
            "info": false,
            "paging": false,
        });
        $('.list-jurnal').DataTable({
            "info": false,
            "paging": false,
            "order": [
                [0, 'desc']
            ]

        });
        $('#lookup_filter input').focus()
            //$('#lookup_filter [type="search"]').focus()
        $('.lookup-djurnal').DataTable({
            "info": false,
            "paging": false,
            "searching": false,
            "ordering": false,
            "order": [
                [2, 'asc'],
                [0, 'asc']
            ]
        });
        $('#lookup_filter input').focus()
            //$('#lookup_filter [type="search"]').focus()
    });



    $('#bulanJ').change(function() {
        setColumnSearchValue(3, (getSelectedId('#tahunJ') + '-' + getSelectedId('#bulanJ')));
        table.draw();
    })
    $('#tahunJ').change(function() {
        setColumnSearchValue(3, (getSelectedId('#tahunJ') + '-' + getSelectedId('#bulanJ')));
        table.draw();
    })

    $('#export-excel').click(function() {
        exportExcel(table, site_url + '/kasbank/exportExcel', 'Data Transaksi Kas Dan Bank');
    });
})

function setColumnSearchValue(column, value) {
    table.column(column).search(value)
}

function getSelectedId(selector) {
    let value = $(selector) ?. val() || null;
    return value === 'SEMUA' ? '' : value;
}
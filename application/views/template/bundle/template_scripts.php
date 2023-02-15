<script src="<?= base_url('public/lib/jquery/dist/jquery.min.js'); ?>"></script>
<script src="<?= base_url('public/lib/autoNumeric/autoNumeric.js'); ?>"></script>
<!-- <script src="<?= base_url('public/lib/jquery/dist/jquery-dateformat.js'); ?>"></script> -->
<!-- Bootstrap tether Core JavaScript -->
<script src="<?= base_url('public/lib/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('public/lib/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?= base_url('public/lib/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js'); ?>"></script>
<!--Wave Effects -->
<!-- Charts js Files -->
<script src="<?= base_url('public/lib/flot/excanvas.js'); ?>"></script>
<script src="<?= base_url('public/lib/flot/jquery.flot.js'); ?>"></script>

<!-- Core Vendors JS -->
<script src="<?= base_url('public/enlink') ?>/assets/js/vendors.min.js"></script>
<script src="<?= base_url('public/lib/modalsteps/modal-steps.min.js'); ?>"></script>
<!-- This Page JS -->
<script src="<?= base_url('public/lib/select2/dist/js/select2.min.js'); ?>"></script>
<script src="<?= base_url('public/lib/chart.js/dist/Chart.min.js'); ?>"></script>
<script src="<?= base_url('public/lib/index-0.js'); ?>"></script>

<!-- parley -->
<script src="<?= base_url('public') ?>/lib/parsleyjs/parsley.min.js"></script>
<script src="<?= base_url('public') ?>/lib/parsleyjs/i18n/id.js"></script>

<!-- popper -->
<!-- <script src="<?= base_url('public/lib') ?>/popper.js/dist/popper.min.js"></script> -->
<script src="<?= base_url('public/lib/summernote/summernote-bs4.js') ?>"></script>
<script src="<?= base_url('public/lib/sweetalert2/sweetalert2.js') ?>"></script>

<script src="<?= base_url('public/lib/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?= base_url('public/enlink') ?>/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url('public/enlink') ?>/assets/vendors/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js"></script>
<!-- <script src="<?= base_url('public/lib') ?>/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('public/lib') ?>/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="<?= base_url('public/lib') ?>/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('public/lib') ?>/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script> -->

<script src="<?= base_url('public') ?>/enlink/assets/vendors/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('public') ?>/enlink/assets/vendors/datatables/dataTables.bootstrap.min.js"></script>


<!-- page js -->
<script src="<?= base_url('public/enlink') ?>/assets/vendors/chartjs/Chart.min.js"></script>
<!-- <script src="<?= base_url('public/enlink') ?>/assets/js/pages/dashboard-default.js"></script> -->

<script src="<?= base_url('public/lib') ?>/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- Core JS -->
<script src="<?= base_url('public/enlink') ?>/assets/js/app.min.js"></script>

<?php
if (isset($output->js_files)) {
	foreach ($output->js_files as $file) {
		echo '<script src="' . $file . '"></script>';
	}
}
?>
<script>
	var site_url = "<?= site_url() ?>";
	var base_url = "<?= base_url() ?>";

	$(function() {
		bsCustomFileInput.init();
	});

	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
		$('.capital').keyup(function(e) {
			parsing = $(this).val().toUpperCase();
			$(this).val(parsing);
		});
	})

	function showLoading() {
		document.getElementById("spinner-front").classList.add("show");
		document.getElementById("spinner-back").classList.add("show");
	}

	function hideLoading() {
		document.getElementById("spinner-front").classList.remove("show");
		document.getElementById("spinner-back").classList.remove("show");
	}
	$(function() {
		$('.datepicker').datepicker({
			language: 'id',
			autoclose: true,
			todayHighlight: true,
			format: "yyyy-mm-dd",
		});

		$('.datepicker-ym').datepicker({
			language: 'id',
			autoclose: true,
			todayHighlight: true,
			format: "yyyy-mm",
			startView: "months",
			minViewMode: "months"
		});

		$('.select2').select2({
			theme: 'bootstrap4',
		});

		$('.nottyping').keypress(function() {
			return false;
		})

		$('.summernote').summernote();

		$('.numeric').bind('keydown', function(e) {
			if (e.altKey) {
				e.preventDefault();
			} else {
				var charCode = (e.which) ? e.which : event.keyCode
				if (charCode > 31 && (charCode < 48 || charCode > 57)) {
					e.preventDefault();
				}
				return true;
			}
		});

	});

	number_format = function(numbers, decimals, dec_point, thousands_sep) {
		var number = parseFloat(numbers)
		number = number.toFixed(decimals);
		var nstr = number.toString();
		nstr += '';
		x = nstr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? dec_point + x[1] : '';
		var rgx = /(\d+)(\d{3})/;

		while (rgx.test(x1))
			x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

		return x1 + x2;
	}

	function formatRupiah(angka, prefix) {
		var number_string = angka.toString().replace(/[^,\d]/g, ''),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

		return prefix === undefined ? rupiah : (rupiah ? `${prefix} ` + rupiah : '');
	}

	function showSessionExpiredAlert(jqXHR, redirectTo) {
		let errorText = 'Error';
		let sessionExpiredText = 'Session anda telah berakhir, silahkan login kembali untuk masuk ke dashboard.';

		if (jqXHR['responseText'].includes(errorText) && jqXHR['responseText'].includes(sessionExpiredText)) {
			swal(errorText, sessionExpiredText, 'error').then(function() {
				window.location.href = redirectTo;
			});
		};
	}

	function cekFile(input) {
		var limit = 2048576; // 2 MB
		var file_info = $(input).parent().next();
		$(file_info).removeClass('text-info').removeClass('text-danger').html('');
		if (input.files && input.files[0]) {
			var filesize = input.files[0].size;
			var filetype = (input.files[0].name).split('.').pop().toLowerCase();
			if (input.name == 'image') {
				var allowed = ['png', 'jpg', 'jpeg'];
			} else {
				var allowed = ['png', 'jpg', 'jpeg', 'pdf'];
			}
			if (filesize < limit && allowed.includes(filetype)) {
				var reader = new FileReader();
				reader.readAsDataURL(input.files[0]);
				$(file_info).addClass('text-info').html(input.files[0].name + ' (' + getFileSize(filesize) + ') <i class="fa fa-check text-success"></i>');
			} else {
				$(input).val('');
				if (allowed.includes(filetype) === false)
					$(file_info).addClass('text-danger').html("<i>Jenis file '" + filetype.toUpperCase() + "' tidak diijinkan. </i>")
				if (filesize > limit)
					$(file_info).addClass('text-danger').html('<i>Ukuran file tidak boleh lebih dari 2 MB</i>')
			}

		}
	}

	function getFileSize(_size) {
		var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
			i = 0;
		while (_size > 900) {
			_size /= 1024;
			i++;
		}
		var exactSize = (Math.round(_size * 100) / 100) + ' ' + fSExt[i];
		return exactSize;
	}

	function parameterize(obj) {
		let params = [];
		for (let i in obj) {
			params.push(i + '=' + obj[i]);
		}
		return "?" + params.join('&');
	}

	function exportExcel(table, url, filename) {
		let params = table.ajax.params();

		let data = {
			length: params.length,
			start: params.start,
			order: JSON.stringify(params.order),
			columns: {},
			// searchable
			sbls: [],
			// orderable
			ordbls: [],
		};
		for (let i in params.columns) {
			data.columns[i] = params.columns[i].search.value || 0;
			if (params.columns[i].searchable) {
				data.sbls.push(i);
			}
			if (params.columns[i].orderable) {
				data.ordbls.push(i);
			}
		}

		data.sbls = JSON.stringify(data.sbls);
		data.ordbls = JSON.stringify(data.ordbls);
		data.columns = JSON.stringify(data.columns);
		if (params.search.value)
			data.search = params.search.value

		// let data = flattenNestedObject(params, true);
		data.filename = filename;
		window.open(url + parameterize(data), '_blank');
	}

	function exportPDF(table, url, filename = '') {
		let params = table.ajax.params();

		let data = {
			length: params.length,
			start: params.start,
			order: JSON.stringify(params.order),
			columns: {},
			// searchable
			sbls: [],
			// orderable
			ordbls: [],
		};
		for (let i in params.columns) {
			data.columns[i] = params.columns[i].search.value || 0;
			if (params.columns[i].searchable) {
				data.sbls.push(i);
			}
			if (params.columns[i].orderable) {
				data.ordbls.push(i);
			}
		}

		data.sbls = JSON.stringify(data.sbls);
		data.ordbls = JSON.stringify(data.ordbls);
		data.columns = JSON.stringify(data.columns);
		if (params.search.value)
			data.search = params.search.value

		// let data = flattenNestedObject(params, true);
		data.filename = filename;
		window.open(url + parameterize(data), '_blank');
	}
</script>

<?php
echo '<script>';
if (isset($scripts) && is_array($scripts)) {
	foreach ($scripts as $script) {
		$this->load->view($script);
	}
}
echo '</script>';
?>
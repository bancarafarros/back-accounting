<style>
	.dynamic-added td input{
		width:50%;
		border:none;
	}
</style>	
<?php $this->load->view('pembelian/top_nav');?>
	<div class="container">
	<form action="<?=site_url('Pembelian/do_Orpembelian')?>" method="POST">
		<div class="row row justify-content-md-center">
			<div class="col-lg-12">
			    <div class="card">
			    	<div class="card-header" align="center">
			    		<h5>ORDER PEMBELIAN</h5>
			    	</div>
<!-- Main -->
			        <div class="card-body">
			        	<div class="row justify-content-md-center">
<!-- Sebelah kiri -->
			        		<div class="col justify-content-md-center">
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">No. Transaksi</label>
				        			<div class="row col-lg-6">
				        				<input type="text" class="form-control" name="n_transaksi" id="" value="<?=@$n_transaksi?>" readonly>
				        			</div>
			        			</div>
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Tanggal</label>
				        			<div class="row col-lg-6">
				        				<div class="input-group">
		                                    <input type="text" class="form-control" name="tanggal" id="datepicker-autoclose" value="<?=date("j-M-y")?>" placeholder="mm/dd/yyyy">
		                                    <div class="input-group-append">
		                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
		                                    </div>
		                                </div>
				        			</div>
			        			</div>
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Pemasok</label>
				        			<div class="row col-lg-3">
				        				<div class="input-group">
		                                    <input type="text" class="form-control d_noPemasok" name="no_pemasok" value="" readonly >
		                                </div>
				        			</div>
									<div class="row col-lg-5">
				        				<div class="input-group">
		                                    <input type="text" class="form-control d_namaPemasok" name="nama_pemasok" value="" readonly >
		                                    <div class="input-group-append">
												<a href="#myModalPemasok" data-toggle="modal">
													<button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
												</a>
		                                    </div>
		                                </div>
				        			</div>
			        			</div>
								<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Cara Bayar</label>
				        			<div class="row col-2">
				        				<div class="input-group">
										<select name="c_bayar" id="chs_bayar">
                                    		<option value="kas">Kas</option>
                                    		<option value="bank">Bank</option>
                                    		<option value="bg">BG</option>
                               		 	</select>
		                                </div>
				        			</div>
								</div>
								<div class="row mb-3">
									<label class="col-sm-4 text-left control-label col-form-label bank">Bank</label>
									<div class="row col-3">
										<div class="input-group">
		                            	    <input type="text" class="form-control bank" id="d_noBank" name="no_bank" value="" readonly >
										</div>
									</div>
									<div class="row col-5">
										<div class="input-group">
		                            		<input type="text" class="form-control bank" id="d_namaBank" name="nama_bank" value="" readonly >
		                            		<input type="hidden" class="form-control bank" id="d_akunBank" name="akun_bank" value="" readonly >
											<div class="input-group-append">
												<a href="#myModalBank" data-toggle="modal">
													<button class="btn btn-outline-secondary bank" type="button" ><i class="fa fa-search"></i></button>
												</a>
											</div>
										</div>
				        			</div>
			        			</div> 
								<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Reff</label>
				        			<div class="row col-lg-3">
				        				<div class="input-group">
		                                    <input type="text" class="form-control" name="reff" value="">
		                                </div>
				        			</div>
			        			</div>
			        		</div>
<!-- Sebelah Kanan -->
			        		<div class="col justify-content-md-center">
			        			<div class="row mb-3 justify-content-md-center">
	
			        			</div>
			        		</div>
			        	</div>
<!-- End Main -->
	        			<div class="row mb-3">
		        			<label class="col-md-2 col-lg-2 text-left control-label col-form-label">Keterangan</label>
		        			<div class="row col-lg-8">
		        				<input type="text" class="form-control" id="" name="keterangan">
		        			</div>
	        			</div>
						<div class="row mb-3 d-flex flex-row-reverse mr-5">
		        			<div class="row col-lg-2">
		        				<input type="text" class="form-control e_hargaSatuan" id="" placeholder="Harga Satuan" value="">
		        			</div>
							<div class="row col-2 input-group mr-3">
		        				<input type="number" class="form-control e_diskon" id="" max="100" placeholder="Disc" value="">
								<div class="input-group-append">
    								<span class="input-group-text" id="basic-addon2">%</span>
  								</div>
		        			</div>
							<div class="col-2">
							&nbsp;
						    </div>
	        			</div>
        				<div class="row mb-3">
						    <div class="col-2">
						      <input type="text" class="form-control e_noB" placeholder="Kode/Barcode" readonly>
						    </div>
						    <div class="col-3">
						      <input type="text" class="form-control e_namaB" placeholder="Nama Barang" readonly>
						    </div>
							<div class="col-2">
						      <select id="inputState" class="form-control convUnit">
						        <option value="nUnit" class="e_nUnit">PCS</option>
						        <option value="bUnit" class="e_bUnit"></option>
						      </select>
						    </div>
						    <div class="col-1">
						      <input type="text" class="form-control e_qtyB" placeholder="Qty">
						    </div>
						    <div class="col-2">
							<input type="text" class="form-control e_hargaTotal" placeholder="Harga Total" id="rupiah" readonly>
						    <input type="hidden" class="form-control e_hargaAsli" placeholder="Harga asli" id="rupiah" readonly>
						    <input type="hidden" class="form-control e_totDiskon" placeholder="Diskon" id="rupiah" readonly>
						    <input type="hidden" class="form-control e_perkiraan" placeholder="perkiraan" id="rupiah" readonly>
							  <input type="hidden" name="" class="e_convBunit">
						    </div>
						    <div class="col-2">
								<a href="#myModalBarang" data-toggle="modal">
									<button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
								</a>
						      <button type="button" class="btn btn-dark" id ="addRowBarang">+</button>
						    </div>
						</div>
	        			<div class="row mb-3">
	        				<div class="table-responsive">
		        				<table class="table" id="dynamic_field"> 
								  <thead class="thead-dark">
								    <tr>
								      <th scope="col">No.</th>
								      <th scope="col">Kode</th>
								      <th scope="col">Nama Barang</th>
								      <th scope="col">Jumlah</th>
								      <th scope="col">Satuan</th>
								      <th scope="col">Harga Satuan</th>
								      <th scope="col">Diskon</th>
								      <th scope="col">Total</th>
								      <th scope="col">*</th>
								    </tr>
								  </thead>
								  <tbody>
								    
								  </tbody>
								</table>
							</div>
	        			</div>
<!-- BAWAH -->
	        			<div class="row justify-content-md-center">
<!--KIRI BAWAH  -->
			        		<div class="col justify-content-md-center">
				        		<input type="text" class="form-control is-valid" id="jml_bayar" name="jml_bayar" value="0" hidden>
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Uang Muka</label>
				        			<div class="row col-lg-6">
				        				<input type="text" class="form-control" id="uang_muka" value="0" name="uang_muka">
				        			</div>
			        			</div>
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Sisa</label>
				        			<div class="row col-lg-6">
				        				<input type="text" class="form-control is-invalid" id="sisa_bayar" name="sisa_bayar" readonly>
				        			</div>
			        			</div>
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Tanggal Kirim</label>
				        			<div class="row col-lg-6">
				        				<div class="input-group">
		                                    <input type="text" class="form-control" id="datepicker-autoclose1" name="tanggal_kirim" placeholder="mm/dd/yyyy">
		                                    <div class="input-group-append">
		                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
		                                    </div>
		                                </div>
				        			</div>
			        			</div>
			        		</div>	



<!-- END KIRI BAWAH -->
							<div class="col-md-5 justify-content-md-center">
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Total</label>
				        			<div class="row col-lg-6">
				        				<input type="number" class="form-control" id="total_beli" value="0" readonly>
				        			</div>
			        			</div>
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Biaya Kirim</label>
				        			<div class="row col-lg-6">
				        				<input type="number" class="form-control" id="biaya_kirim" name="biaya_kirim" value="0">
				        			</div>
			        			</div>
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">PPN</label>
				        			<div class="row col-lg-6">
				        				<input type="number" class="form-control" id="ppn_beli" name="biaya_ppn" value="0">
				        			</div>
			        			</div>
			        			<div class="row mb-3">
				        			<label class="col-sm-4 text-left control-label col-form-label">Total Seluruhnya</label>
				        			<div class="row col-lg-6">
				        				<input type="number" class="form-control is-valid" id="total_all" name="total_all" value="0" readonly>
				        			</div>
			        			</div>
			        		</div>
						</div>
<!-- END BAWAH -->
		    			<div class="row mb-3 justify-content-md-center">
		        			<div class="row">
		        				<button type="submit" class="btn btn-primary">SIMPAN</button>
		        			</div>
	        			</div>
	        			</form>
			        </div>
			    </div>
			</div>
		</div>
	</div>

	<div id="myModalPemasok" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Pilih Pemasok</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="lookup" class="table lookup" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama Pemasok</th>
									<th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 0;
                            foreach ($d_pemasok as $key => $value) { ?>
                                <tr>
                                    <td><?=$value->n_pemasok?></td>
                                    <td><?=$value->nama?></td>
                                    <input type="hidden" class="no_pemasok<?=$no?>" value="<?=$value->n_pemasok?>">
                                    <input type="hidden" class="nama_pemasok<?=$no?>" value="<?=$value->nama?>">
                                    <td align="right"><button type="button" class="btn btn-sm btn-primary chs_pemasok<?=$no?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
                                </tr>
                            <?php $no++; } ?>
                            <input type="hidden" class="sum_pemasok" value="<?=$no?>">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div id="myModalBank" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Pilih Bank</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="lookup" class="table lookup" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama Bank</th>
									<th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 0;
                            foreach ($d_bank as $key => $value) { ?>
                                <tr>
                                    <td><?=$value->n_bank?></td>
                                    <td><?=$value->nama?></td>
                                    <input type="hidden" class="no_bank<?=$no?>" value="<?=$value->n_bank?>">
                                    <input type="hidden" class="nama_bank<?=$no?>" value="<?=$value->nama?>">
                                    <input type="hidden" class="akun_bank<?=$no?>" value="<?=$value->akun?>">
                                    <td align="right"><button type="button" class="btn btn-sm btn-primary chs_bank<?=$no?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
                                </tr>
                            <?php $no++; } ?>
                            <input type="hidden" class="sum_bank" value="<?=$no?>">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div id="myModalBarang" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Pilih Data Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="lookup" class="table lookup" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama</th>
									<th>Stok</th>
									<th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 0;
                            foreach ($d_barang as $key => $value) { ?>
                                <tr>
                                    <td><?=$value->n_barang?></td>
                                    <td><?=$value->nama?></td>
                                    <td><?=$value->stock_gudang?></td>
                                    <input type="hidden" class="no_barang<?=$no?>" value="<?=$value->n_barang?>">
                                    <input type="hidden" class="nama_barang<?=$no?>" value="<?=$value->nama?>">
                                    <input type="hidden" class="stock_gudang<?=$no?>" value="<?=$value->stock_gudang?>">
                                    <input type="hidden" class="n_unit<?=$no?>" value="<?=$value->n_unit?>">
                                    <input type="hidden" class="b_unit<?=$no?>" value="<?=$value->b_unit?>">
                                    <input type="hidden" class="harga_beli<?=$no?>" value="<?=$value->harga_beli?>">
                                    <input type="hidden" class="konversi_unit<?=$no?>" value="<?=$value->konversi_unit?>">
                                    <input type="hidden" class="n_unit<?=$no?>" value="<?=$value->n_unit?>">
                                    <input type="hidden" class="b_unit<?=$no?>" value="<?=$value->b_unit?>">
                                    <input type="hidden" class="b_perkiraan<?=$no?>" value="<?=$value->akun_persediaan?>">
                                    <td align="right"><button type="button" class="btn btn-sm btn-primary chs_barang<?=$no?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
                                </tr>
                            <?php $no++; } ?>
                            <input type="hidden" class="sum_barang" value="<?=$no?>">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	<script src="<?=base_url('assets/libs/jquery/dist/jquery.min.js'); ?>"></script>

	<script>
		for (let s=0;s<$(".sum_pemasok").val(); s++) {
			$(".chs_pemasok"+s).click(function(){
				$(".d_noPemasok").val($('.no_pemasok'+s).val());
				$(".d_namaPemasok").val($('.nama_pemasok'+s).val());
			});
		}

		$('.bank').hide();
		$('.bank').attr("disabled");
		$("#chs_bayar").on('change', function() {
			if ($('#chs_bayar option').filter(':selected').val() == "bank") {
				$('.bank').show();
				$('.bank').removeAttr("disabled");
			}
			if ($('#chs_bayar option').filter(':selected').val() == "kas") {
				$('.bank').hide();
				$('.bank').attr("disabled");
			} 
		});
		for (let s=0;s<$(".sum_bank").val(); s++) {
			$(".chs_bank"+s).click(function(){
				$("#d_noBank").val($('.no_bank'+s).val());
				$("#d_namaBank").val($('.nama_bank'+s).val());
				$("#d_akunBank").val($('.akun_bank'+s).val());
			});
		}

		var jml_diskon = 0;
		var unit = 0;
		for (let b=0;b<$(".sum_barang").val(); b++) {
			$(".chs_barang"+b).click(function(){
				$(".e_noB").val($('.no_barang'+b).val());
				$(".e_namaB").val($('.nama_barang'+b).val());
				$(".e_hargaSatuan").val($('.harga_beli'+b).val());
				$(".e_convBunit").val($('.konversi_unit'+b).val());
				$(".e_nUnit").text($('.n_unit'+b).val());
				$(".e_bUnit").text($('.b_unit'+b).val());
				$(".e_perkiraan").val($('.b_perkiraan'+b).val());
				$(".e_qtyB").val(1);
				$(".e_diskon").val(0);
				$(".e_totDiskon").val(0);
				$(".e_hargaTotal").val($('.harga_beli'+b).val());
				$(".e_hargaAsli").val($('.harga_beli'+b).val());
				if ($('.convUnit option').filter(':selected').val() == "nUnit") {
					unit = 1;
				}
				if ($('.convUnit option').filter(':selected').val() == "bUnit") {
					unit = $(".e_convBunit").val();
				} 
			});
		}
		$(".convUnit").on('change', function() {
			if ($('.convUnit option').filter(':selected').val() == "nUnit") {
				unit = 1;
				jml_diskon = parseInt($(".e_hargaSatuan").val() * ($('.e_diskon').val() / 100));
				$('.e_hargaTotal').val($('.e_qtyB').val() * ($('.e_hargaSatuan').val() - jml_diskon) * unit);
				$('.e_hargaAsli').val($('.e_hargaSatuan').val());
				$('.e_totDiskon').val($('.e_hargaAsli').val() - jml_diskon);
			}
			if ($('.convUnit option').filter(':selected').val() == "bUnit") {
				unit = $(".e_convBunit").val();
				jml_diskon = parseInt($(".e_hargaSatuan").val() * ($('.e_diskon').val() / 100));
				$('.e_hargaTotal').val($('.e_qtyB').val() * ($('.e_hargaSatuan').val() - jml_diskon) * unit);
				$('.e_hargaAsli').val($('.e_hargaSatuan').val());
				$('.e_totDiskon').val($('.e_hargaAsli').val() - jml_diskon);
			} 
		});
        $('.e_qtyB').keyup(function(){
			var qty = parseFloat($('.e_qtyB').val()) || 0;
			jml_diskon = parseInt($(".e_hargaSatuan").val() * ($('.e_diskon').val() / 100));
			$('.e_hargaTotal').val(qty * ($('.e_hargaSatuan').val() - jml_diskon) * unit);
			$('.e_hargaAsli').val($('.e_hargaSatuan').val());
			$('.e_totDiskon').val($('.e_hargaAsli').val() - jml_diskon);

		});
		$('.e_diskon').keyup(function(){
			var diskon = parseFloat($('.e_diskon').val()) || 0;
			if (diskon > 100) {
				diskon = 100;
				$('.e_diskon').val(100);
			}
			jml_diskon = parseInt($(".e_hargaSatuan").val() * (diskon / 100));
			$('.e_hargaTotal').val($('.e_qtyB').val() * ($('.e_hargaSatuan').val() - jml_diskon) * unit);
			$('.e_hargaAsli').val($('.e_hargaSatuan').val());
			$('.e_totDiskon').val($('.e_hargaAsli').val() - jml_diskon);

        });
		$('.e_hargaSatuan').keyup(function(){
			harga_satuan = parseFloat($('.e_hargaSatuan').val()) || 0;
			jml_diskon = parseInt($(".e_hargaSatuan").val() * ($('.e_diskon').val() / 100));
			$('.e_hargaTotal').val($('.e_qtyB').val() * (harga_satuan - jml_diskon) * unit);
			$('.e_hargaAsli').val(harga_satuan);
			$('.e_totDiskon').val($('.e_hargaAsli').val() - jml_diskon);

		});
		

		// tambah baris daftar barang
	      var i=0;  
		  var no=1;
		  var total=0;
		  var total_all = 0;
		  var ppn = parseInt($("#ppn_beli").val());
		  var kirim = parseInt($("#biaya_kirim").val());
		  var bayar = parseInt($("#jml_bayar").val());
		  var uangMuka = parseInt($("#uang_muka").val());
	      $('#addRowBarang').click(function(){
			  if ($('.e_noB').val() != "") {
				let satuan = $('.convUnit option').filter(':selected').text();
	           	$('#dynamic_field').append('<tr id="row'+i+'"class="dynamic-added"><td>'+no+'<input type="hidden" name="h_diskon'+i+'" value="'+ $(".e_totDiskon").val() +'" readonly><input type="hidden" name="perkiraan'+i+'" value="'+ $(".e_perkiraan").val() +'" readonly><input type="hidden" name="sum_barang" value="'+i+'" readonly><input type="hidden" name="harga_asli'+i+'" value="'+ $(".e_hargaAsli").val() +'" readonly><input type="hidden" name="diskon'+i+'" value="'+ $(".e_totDiskon").val() +'" readonly></td><td><input type="text" name="n_barang'+i+'" value="'+ $(".e_noB").val() +'" readonly></td><td><input type="text" name="nama_barang'+i+'" value="'+ $(".e_namaB").val() +'" readonly></td><td><input type="text" name="qty_barang'+i+'" value="'+ $(".e_qtyB").val() +'" readonly></td><td><input type="text" name="satuan_barang'+i+'" value="'+ satuan +'" readonly></td><td><input type="text" name="harga_barang'+i+'" value="'+ $(".e_hargaSatuan").val() +'" readonly></td><td><input type="text" name="diskon'+i+'" value="'+ $(".e_diskon").val() +'%" readonly></td><td><input type="text" id="totals'+i+'" name="total'+i+'" value="'+ $(".e_hargaTotal").val() +'" readonly></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" value="'+ $(".e_hargaTotal").val() +'" >X</button></td></tr>');  			   
				$("input[name=total"+i+"]").each(function(){
					total += parseInt($(this).val());
    				$('#total_beli').val(total);
					$('#total_all').val(total + ppn + kirim);
					$('#sisa_bayar').val(total + ppn + kirim - bayar - uangMuka);

  				});
				no++;
			   	i++; 
			  } 
			  if ($('.e_noB').val() == "") {
				  alert("Data Barang Belum Diisi");
			  }
		  });
		  $('#ppn_beli').keyup(function(){
            ppn = parseFloat($('#ppn_beli').val()) || 0;
			$('#total_all').val(total + ppn + kirim);
			$('#sisa_bayar').val(total + ppn + kirim - bayar - uangMuka);
          });
		  $('#biaya_kirim').keyup(function(){
            kirim = parseFloat($('#biaya_kirim').val()) || 0;
			$('#total_all').val(total + ppn + kirim);
			$('#sisa_bayar').val(total + ppn + kirim - bayar - uangMuka);
          });
		  $('#jml_bayar').keyup(function(){
            bayar = parseFloat($('#jml_bayar').val()) || 0;
			$('#total_all').val(total + ppn + kirim);
			$('#sisa_bayar').val(total + ppn + kirim - bayar - uangMuka);
          });
		  $('#uang_muka').keyup(function(){
            uangMuka = parseFloat($('#uang_muka').val()) || 0;
			$('#total_all').val(total + ppn + kirim);
			$('#sisa_bayar').val(total + ppn + kirim - bayar - uangMuka);
          });
	      $(document).on('click', '.btn_remove', function(){  
	           var button_id = $(this).attr("id");   
	           $('#row'+ button_id).remove();
				total -= parseInt($(this).attr("value"));
    			$('#total_beli').val(total);
				$('#total_all').val(total + ppn + kirim);
				$('#sisa_bayar').val(total + ppn + kirim - bayar - uangMuka);
			   i -= 1; 
	      });
		  
	</script>


	<script type="text/javascript">
		
		// var rupiah = document.getElementById('rupiah');
		// rupiah.addEventListener('keyup', function(e){
		// 	// tambahkan 'Rp.' pada saat form di ketik
		// 	// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		// 	rupiah.value = formatRupiah(this.value, 'Rp. ');
		// });

		// /* Fungsi formatRupiah */
		// function formatRupiah(angka, prefix){
		// 	var number_string = angka.replace(/[^,\d]/g, '').toString(),
		// 	split   		= number_string.split(','),
		// 	sisa     		= split[0].length % 3,
		// 	rupiah     		= split[0].substr(0, sisa),
		// 	ribuan     		= split[0].substr(sisa).match(/[-\d]{3}/gi);

		// 	// tambahkan titik jika yang di input sudah menjadi angka ribuan
		// 	if(ribuan){
		// 		separator = sisa ? '.' : '';
		// 		rupiah += separator + ribuan.join('.');
		// 	}

		// 	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		// 	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		// }
	</script> 
	<script>
        $(document).ready(function() {
            $('.lookup').DataTable(
            {
                "responsive": true
            });
            $('.lookup_filter input').focus()
            //$('.lookup_filter [type="search"]').focus()
            $('.lookup-edit').DataTable(
            {
                "responsive": true
            });
            $('.lookup_filter input').focus()
            //$('#lookup_filter [type="search"]').focus()
        });
    </script>


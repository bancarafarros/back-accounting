<div class="col justify-content-md-center">
	<form action="<?=site_url('Pembelian/do_pembelian')?>" id="formBarang" method="POST">
		<div class="row justify-content-md-center">
<!-- INFORMASI NOTA -->
					<div class="container col-md-6 col-lg-3 col-xlg-2">
						<div class="card">
					    	<h5 class="text-white bg-primary p-2">INFORMASI NOTA</h5>
					        <div class="card-body">
				        			<div class="row">
										<label class="col-sm-5 text-left control-label col-form-label">No. Nota</label>
									</div>
        							<div class="row">
										<input type="text" class="form-control" name="n_transaksi" id="" value="<?=@$n_transaksi?>" readonly>
				        			</div>
        							<div class="row">
	        							<label class="col-sm-5 text-left control-label col-form-label">Tanggal</label>
									</div>
									<div class="row">
        								<div class="input-group">
		                                    <input type="text" class="form-control" name="tanggal" id="datepicker-autoclose2" value="<?=date("d-M-Y")?>" placeholder="mm/dd/yyyy">
		                                    <div class="input-group-append">
		                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
		                                    </div>
		                                </div>
				        			</div>
			        				<div class="row">
	        							<label class="col-sm-5 text-left control-label col-form-label">Reff</label>
				        			</div>
									<div class="row">
										<div class="input-group">
		                                    <input type="text" class="form-control" name="reff" value="">
		                                </div>
									</div>
								</div>
							</div>
							<div class="card">
	    					<h5 class="text-white bg-primary p-2">INFORMASI PEMASOK</h5>
	        				<div class="card-body">
        							<div class="row">
	        							<label class="col-sm-6 text-left control-label col-form-label">Pemasok</label>
        							</div>
        							<div class="row">
        								<div class="input-group">
		                                    <input type="text" class="form-control d_Pemasok" name="n_pemasok" value="" required>
		                                    <div class="input-group-append">
												<a href="#myModalPemasok" data-toggle="modal">
													<button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
												</a>
		                                    </div>
		                                </div>
				        			</div>
									<div class="row">
	        							<label class="col-sm-8 text-left control-label col-form-label">Batas Kredit</label>
        							</div>
        							<div class="row">
        								<div class="input-group">
                    				        <input type="text" class="form-control text-right btn-success d_Batas" name="batas" value="" disabled>
                    				    </div>
        							</div>
									<div class="row">
	        							<label class="col-sm-8 text-left control-label col-form-label">Total Hutang</label>
        							</div>
        							<div class="row">
        								<div class="input-group">
                    				        <input type="text" class="form-control text-right btn-danger sum_sisa" name="sum_sisa" value="" disabled>
                    				    </div>
        							</div>
			        			</div>
			        		</div>
						</div>
<!-- DAFTAR BARANG -->
					<div class="container col-md-6 col-lg-9 col-xlg-2">
		   				<div class="row justify-content-md-center">
							   <div class="col-lg-12">
								   <div class="card">
									   <div class="card-body pt-0 pl-2 pr-2">
	        								<div class="row">
	        									<div class="table-responsive">
		        									<table class="table" id="dynamic_field"> 
													  <thead class="thead-dark">
													    <tr>
													      <th scope="col">Kode</th>
													      <th scope="col">Nama Barang</th>
													      <th scope="col">Jumlah</th>
													      <th scope="col">Satuan</th>
													      <th scope="col">Harga</th>
													      <th scope="col">Diskon(%)</th>
													      <th scope="col">Total</th>
													      <th scope="col">*</th>
													    </tr>
													  </thead>
													  <input type="hidden" name="sum_barang" class="sum_baris" value="0" readonly>
													  <tbody>
													  	<tr id="row0" class="dynamic-added">
															<input type="hidden" id="conv_unit0" name="conversiUnit0" value="" readonly>
															<input type="hidden" name="h_hpp0" id="h_hpp0" value="" readonly>
															<input type="hidden" name="h_diskon0" id="totDiskon0" value="" readonly>
															<input type="hidden" name="perkiraan0" id="perkiraan0" value="" readonly>
															<input type="hidden" name="harga_asli0" id="harga_asli0" value="" readonly>
															<input type="hidden" id="hargaT_asli0" name="hargaT_asli0" value="0" readonly>
															<td class="p-2">
																<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang0" id="n_barang0" data-index="0" value="">
															</td>
															<td class="p-2">
																<input type="text" class="form-control m-0 p-2 bg-white col w-auto" name="nama_barang0" id="nama_barang0" value="" readonly>
															</td>
															<td class="p-2">
																<input type="text" class="form-control m-0 p-2 bg-white col w-50 qtyB" name="qty_barang0" data-index="0" id="qty_barang0" value="">
															</td>
															<td class="p-2">
																<select class="form-control convUnit" name="satuan_barang0" id="satuan_barang0" data-index="0">
											      				  	<option value="1" id="e_nUnit0">PCS</option>
											      				  	<option value="0" id="e_bUnit0"></option>
											      				</select>
															</td>
															<td class="p-2">
																<input type="text" class="form-control m-0 p-2 bg-white col h_barang" name="harga_barang0" id="harga_barang0" value="" data-index="0">
															</td>
															<td class="p-2">
																<input type="text" class="form-control m-0 p-2 bg-white col diskon" name="diskon0" id="diskon0" value="" data-index="0">
															</td>
															<td class="p-2">
																<input type="text" class="form-control m-0 p-2 bg-white col totalsPb" id="total0" name="total0" data-index="0" value="" >
															</td>
															<td class="p-2" id="action0">
																
															</td>
													 	  </tr>
													  	</tbody>
													</table>
													<hr>
												</div>
	        								</div>
	        								<div class="row">
							        			<div class="row col-lg-6">
							        				<input type="textarea" class="form-control" id="" name="keterangan" placeholder="Catatan Transaksi (Jika Ada)">
							        			</div>
							        			<div class="row col-lg-2">

							        			</div>
												<div class="row col-lg-4 btn-danger">
							        				<label class="col-sm-4 text-right control-label col-form-label"><h5><b><i>TOTAL</i></b></h5></label>
							        				<div class="col-lg-8">
				        								<input type="text" class="form-control text-right border-0 bg-danger text-light" id="total_beli" value="0" readonly>
							        				</div>
							        			</div>
											</div>
	    					    			</div>
							
								    </div>
								</div>
<!-- Pembayaran -->
								<div class="col-lg-7">
									<div class="card">
			    						<h5 class="text-white bg-warning p-2">PEMBAYARAN</h5>
			    			  			<div class="card-body">
			    			    			<div class="row mb-3">
			    			    				<label class="col-sm-3 text-left control-label col-form-label">Cara Bayar</label>
												<div class="row col-lg-9">
													<div class="input-group">
														<div class="btn-group justify-content-md-center" role="group" aria-label="Basic example">
                              								<button type="button" class="btn btn-success" style="min-width:65px; max-width:65px" id="c_kas" value="kas" >KAS</button>
															<a href="#myModalBank" data-toggle="modal">
                              									<button type="button" class="btn btn-secondary" style="min-width:65px; max-width:65px" id="c_bank" value="bank">BANK</button>
															</a>
														<input type="text" class="form-control bank" id="d_Bank" name="no_bank" value="" readonly >
														<div class="input-group-append">
															<a href="#myModalBank" data-toggle="modal">
																<button class="btn btn-outline-secondary bank" type="button"><i class="fa fa-search"></i></button>
															</a>
		                            	        		</div>
                            						</div>
												</div>
												<input type="hidden" name="c_bayar" id="c_bayar" value="kas">
												<input type="hidden" name="akun_bank" id="d_akunBank" value="kas">
				        					</div>
										</div>
			        					<div class="row mb-3">
				        					<label class="col-sm-3 text-left control-label col-form-label">Jumlah Bayar</label>
				        					<div class="row col-lg-9">
				        						<input type="text" class="form-control is-valid" id="jml_bayar" name="jml_bayar" value="0">
				        					</div>
			        					</div>
			        				
				        					<input type="hidden" class="form-control" id="uang_muka" value="0" name="uang_muka" readonly>
				        				
			        					<div class="row mb-3">
				        					<label class="col-sm-3 text-left control-label col-form-label">Sisa</label>
				        					<div class="row col-lg-9">
				        						<input type="text" class="form-control is-invalid" id="sisa_bayar" name="sisa_bayar" value="0" readonly>
				        					</div>
			        					</div>
			        					<div class="row mb-3">
				        					<label class="col-sm-4 text-left control-label col-form-label">Jatuh Tempo</label>
				        					<div class="row col-lg-9">
				        						<div class="input-group">
		                        		            <input type="text" class="form-control" id="datepicker-autoclose1" name="jatuh_tempo"value="<?=date("d-M-Y")?>">
		                        		            <div class="input-group-append">
		                        		                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
		                        		            </div>
		                        		        </div>
				        					</div>
			        					</div>
										<div class="row mb-3 justify-content-md-center">
			        						<div class="row">
			        							<button type="submit" class="btn btn-primary" id="savePb">Simpan & Cetak</button>
			        						</div>
			    						</div>
			    		    		</div>
			    		    	</div>
							</div>
<!-- Rincian Total -->
					<div class="col-lg-5">
						<div class="card">
			    			<h5 class="text-white bg-success p-2">RINCIAN TOTAL</h5>
					        <div class="card-body">
								<div class="row mb-3">
					        		<label class="col-sm-4 text-left control-label col-form-label">Biaya Kirim</label>
					        		<div class="row col-lg-8">
					        			<input type="number" class="form-control" id="biaya_kirim" name="biaya_kirim" value="0">
					        		</div>
			    	    		</div>
								<div class="row mb-3">
					        		<label class="col-sm-4 text-left control-label col-form-label">PPN</label>
					        		<div class="row col-lg-8">
					        			<input type="number" class="form-control" id="ppn_beli" name="biaya_ppn" value="0">
					        		</div>
			    	    		</div>
					        		<input type="hidden" class="form-control" id="total_diskon" name="total_diskon" value="0" readonly>
								<div class="row mb-3">
					        		<label class="col-sm-4 text-left control-label col-form-label">Total Seluruhnya</label>
					        		<div class="row col-lg-8">
					        			<input type="number" class="form-control is-valid" id="total_all" name="total_all" value="0" readonly>
					        		</div>
			    	    		</div>
							</div>
			        	</div>
					</div>
			    </div>
			</div>
		</div>
	</form>
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
                                    <input type="hidden" class="akun_pemasok<?=$no?>" value="<?=$value->akun?>">
									<input type="hidden" class="batas_kredit<?=$no?>" value="<?=$value->batas?>">
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
				<input type="hidden" id="urut_barang">				
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
                                    <input type="hidden" class="harga_pokok<?=$no?>" value="<?=$value->harga_pokok?>">
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
	<div id="myModalPembelian" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="width:auto;">
  		<div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Pilih Data Order</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="row">
						<div class="col-6">
                    		<div class="table-responsive">
								<table id="lookup" class="table lookup" width="100%">
                    	    	    <thead class="thead-dark">
                    	    	        <tr>
                    	    	            <th>Kode Order</th>
                    	    	            <th>Tanggal</th>
											<th>Pemasok</th>
											<th>Pilih</th>
                    	    	        </tr>
                    	    	    </thead>
                    	    	    <tbody>
                    	    	    <?php $no = 0;
                    	    	    foreach ($d_order as $key => $value) { ?>
                    	    	        <tr>
                    	    	            <td><?=$value->n_opembelian?></td>
                    	    	            <td><?=date_format(date_create($value->tanggal),"d-M-y")?></td>
                    	    	            <td><?=$value->namaPemasok?></td>
                    	    	            <td align="right"><button type="button" class="btn btn-sm btn-primary<?=$no?> detail_order" data-order="<?=$value->n_opembelian?>"><i class="fa fa-check"></i></button></td>
                    	    	        </tr>
                    	    	    <?php $no++; } ?>
                    	    	    <input type="hidden" class="sum_barang" value="<?=$no?>">
                    	    	    </tbody>
                    	    	</table>
							</div>
                    	</div>
						<div class="col-6">
							<label class="col-2 text-left control-label col-form-label">Detail</label>
							<table id="lookup" class="table" width="100%">
                            	<thead class="thead-dark">
                            	    <tr>
                            	        <th>Kode</th>
                            	        <th>Barang</th>
										<th>Qty</th>
										<th>Terkirim</th>
                            	    </tr>
                            	</thead>
								<tbody id="show_detail">

								</tbody>
                        	</table>
							<label class="col-2 text-left control-label col-form-label">Total</label>
				        	<div class="row col-lg-6">
				        		<input type="text" class="form-control" id="totalOrder" value="0" readonly>
				        	</div>
                    	</div>
					</div>
                </div>
            </div>
        </div>
    </div>
	<script src="<?=base_url('assets/libs/jquery/dist/jquery.min.js'); ?>"></script>
	<script src="<?=base_url('assets/libs/autoNumeric/autoNumeric.js'); ?>"></script>

	<script>
	$("#savePb").click(function() {
		var sel = $('.sum_baris').val();
		$('#row'+sel).remove();
		$('.sum_baris').val(parseInt($('.sum_baris').val()) - 1);
    });
//tambah barang
	function tambahBaris(u) {
		$('#dynamic_field').append('<tr id="row'+u+'" "class="dynamic-added">'+
					'<input type="hidden" id="conv_unit'+u+'" name="conversiUnit'+u+'" value="" readonly>'+
					'<input type="hidden" name="h_hpp'+u+'" id="h_hpp'+u+'" value="" readonly>'+
					'<input type="hidden" name="h_diskon'+u+'" id="totDiskon'+u+'" value="" readonly>'+
					'<input type="hidden" name="perkiraan'+u+'" id="perkiraan'+u+'" value="" readonly>'+
					'<input type="hidden" name="harga_asli'+u+'" id="harga_asli'+u+'" value="" readonly>'+
					'<input type="hidden" id="hargaT_asli'+u+'" name="hargaT_asli'+u+'" value="0" readonly>'+
					'<td class="p-2">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang'+u+'" id="n_barang'+u+'" data-index="'+u+'" value="">'+
					'</td>'+
					'<td class="p-2">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col w-auto" name="nama_barang'+u+'" id="nama_barang'+u+'" value="" readonly>'+
					'</td>'+
					'<td class="p-2">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col w-50 qtyB" name="qty_barang'+u+'" data-index="'+u+'" id="qty_barang'+u+'" value="">'+
					'</td>'+
					'<td class="p-2">'+
						'<select id="inputState" class="form-control convUnit" name="satuan_barang'+u+'" id="satuan_barang'+u+'" data-index="'+u+'">'+
						  	'<option value="1" id="e_nUnit'+u+'">PCS</option>'+
						  	'<option value="0" id="e_bUnit'+u+'"></option>'+
						'</select>'+
					'</td>'+
					'<td class="p-2">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col h_barang" name="harga_barang'+u+'" id="harga_barang'+u+'" value="" data-index="'+u+'">'+
					'</td>'+
					'<td class="p-2">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col diskon" name="diskon'+u+'" id="diskon'+u+'" value="" data-index="'+u+'">'+
					'</td>'+
					'<td class="p-2">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col totalsPb" id="total'+u+'" name="total'+u+'" data-index="'+u+'" value="">'+
					'</td>'+
					'<td class="p-2" id="action'+u+'">'+
					'</td>'+
				'</tr>');  	
			var bef = parseInt(u - 1);
			$('#action'+bef).append('<button type="button" name="remove" data-index="'+bef+'" class="btn btn-danger btn_remove" value="" >X</button>');	
			$('#n_barang'+bef).attr('readonly',true);
			$('.sum_baris').val(parseInt($('.sum_baris').val()) + 1);
	}
//hitung total
	function hitungTotal(totalB) {
		var totalB = 0
		var total = 0;
		var totalD = 0;
		var totalBeli = $('#total_beli').val();
		var ppn = parseInt($("#ppn_beli").val());
		var kirim = parseInt($("#biaya_kirim").val());
		var bayar = parseInt($("#jml_bayar").val());
		var uangMuka = parseInt($("#uang_muka").val());
		for (let q = 0; q < $('.sum_baris').val(); q++) {
			if($('#total'+q).val()){
			total += parseInt($('#total'+q).val());
			totalD += parseInt($('#totDiskon'+q).val());
			}
			$('#total_beli').val(total);
			$('#total_diskon').val(totalD);
			$('#total_all').val(parseInt(total + ppn + kirim));
			$('#sisa_bayar').val(parseInt(total + ppn + kirim - bayar - uangMuka));
		}
	}
//format angka
	$(".money").on("click", function () {
		  $(this).select();
	});       
	$(".money").autoNumeric('init', {aSep: ',', aDec: '.', aSign: 'Rp '});
	number_format = function (number, decimals, dec_point, thousands_sep) {
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
	//pemasok
		for (let s=0;s<$(".sum_pemasok").val(); s++) {
			$(".chs_pemasok"+s).click(function(){
				 //tampil ajax Kartu
				 $.getJSON("<?=site_url('Hutang/getKartu?n_pemasok=')?>"+$('.no_pemasok'+s).val() , function(json){
                    console.log(json);
                    var html = '';
                    var i;
                    sum_sisa = 0;
                    for(i=0; i<json.length; i++){
                        sum_sisa = sum_sisa + parseFloat(json[i].sisa);
                        $(".sum_sisa").val(number_format(sum_sisa,2,'.',','));
                    }
                });
				$(".d_Pemasok").val($('.no_pemasok'+s).val()+" | "+$('.nama_pemasok'+s).val());
				$(".d_Batas").val(number_format(parseFloat($('.batas_kredit'+s).val()),2,'.',','));
			});
		}
		$(".d_Pemasok").keydown(function(e){
        	e.preventDefault();
    	});

// cara bayar
		$('.bank').hide();
		$('.bank').attr("disabled");
		$( "#c_kas" ).click(function() { 
    	      $("#c_bank").removeClass('btn-success');
    	      $("#c_bank").addClass('btn-secondary');
    	      $(this).removeClass('btn-secondary');  
    	      $(this).addClass('btn-success');
			  $("#c_bayar").val($(this).val());
			  $('.bank').hide();
			  $('.bank').attr("disabled");
			  $("#d_Bank").val("");
    	});
		$( "#c_bank" ).click(function() { 
    	      $("#c_kas").removeClass('btn-success');
    	      $("#c_kas").addClass('btn-secondary');  
    	      $(this).removeClass('btn-secondary');  
    	      $(this).addClass('btn-success');
			  $("#c_bayar").val($(this).val());
			  $('.bank').show();
			  $('.bank').removeAttr("disabled");
    	});
		for (let s=0;s<$(".sum_bank").val(); s++) {
			$(".chs_bank"+s).click(function(){
				$("#d_Bank").val($('.no_bank'+s).val()+" | "+$('.nama_bank'+s).val());
				$("#d_akunBank").val($('.akun_bank'+s).val());
			});
		}
// tambah baris daftar barang
	var total_all = 0;
	// $(document).on('keyup', '.sn_barang', function(){
	$(document).on('keyup', '.sn_barang', function(e){
		var index = $(this).data('index');
		var keyCode = (event.keyCode ? event.keyCode : event.which);
			if(keyCode == 13) {
				var detail = $(this).val();
          //tampil ajax barang
         	 $.getJSON("<?=site_url('Barang/getDetailMulti?n_barang=')?>"+detail , function(json){
					$("#n_barang"+index).val(json.n_barang);
					$("#nama_barang"+index).val(json.nama);
					$("#qty_barang"+index).val(1);
					$("#e_nUnit"+index).text(json.n_unit);
					$("#e_bUnit"+index).text(json.b_unit);
					$("#e_bUnit"+index).val(json.konversi_unit);
					$("#conv_unit"+index).val(1);
					$("#harga_barang"+index).val(json.harga_beli);
					$("#diskon"+index).val(0);
					$("#total"+index).val(json.harga_beli);
					$("#perkiraan"+index).val(json.akun_persediaan);
					$("#harga_asli"+index).val(json.harga_beli);
					$("#hargaT_asli"+index).val(json.harga_beli);
					$("#h_hpp"+index).val(json.harga_pokok);
					$("#totDiskon"+index).val(0);
					if (json == false) {
						$('#myModalBarang').modal('show');
						$('#urut_barang').val(index);
					}
					if (json != false) {
		
						hitungTotal();
						var next = parseInt(index) + 1; 
						tambahBaris(next);
					}
        		});
			}
	});
	for (let b=0;b<$(".sum_barang").val(); b++) {
		$(".chs_barang"+b).click(function(){
			var urut = $('#urut_barang').val()
			$("#n_barang"+urut).val($('.no_barang'+b).val());
			$("#nama_barang"+urut).val($('.nama_barang'+b).val());
			$("#qty_barang"+urut).val(1);
			$("#e_nUnit"+urut).text($('.n_unit'+b).val());
			$("#e_bUnit"+urut).text($('.b_unit'+b).val());
			$("#e_bUnit"+urut).val($('.konversi_unit'+b).val());
			$("#conv_unit"+urut).val(1);
			$("#harga_barang"+urut).val($('.harga_beli'+b).val());
			$("#diskon"+urut).val(0);
			$("#total"+urut).val($('.harga_beli'+b).val());
			$("#perkiraan"+urut).val($('.b_perkiraan'+b).val());
			$("#harga_asli"+urut).val($('.harga_beli'+b).val());
			$("#hargaT_asli"+urut).val($('.harga_beli'+b).val());
			$("#h_hpp"+urut).val($('.harga_pokok'+b).val());
			$("#totDiskon"+urut).val(0);
			var next = parseInt(urut) + 1; 
			tambahBaris(next);
			total = 0;
			totalD = 0;
			hitungTotal();
		});
	}
//olah data barang

	      $(document).on('click', '.btn_remove', function(){ 
			   var id = $(this).data("index");
	           $('#row'+id).remove();

			   hitungTotal();
	      });
		  $(document).on('keyup', '.qtyB', function(){  
			   qty = parseFloat($(this).val()) || 0;
			   var id = $(this).data("index");  
			   $("#hargaT_asli"+id).val($('#harga_barang'+id).val() * qty * $('#conv_unit'+id).val());
			   $('#totDiskon'+id).val(parseInt(($('#harga_barang'+id).val() * ($('#diskon'+id).val() / 100)) * qty * $('#conv_unit'+id).val()));
			   $('#total'+id).val(parseInt((qty * $('#conv_unit'+id).val() * $('#harga_barang'+id).val()) - $('#totDiskon'+id).val()));

			   hitungTotal();
	      });
		  $(document).on('change', '.convUnit', function(){ 
			var id = $(this).data("index");  
			var unit = $(this).val();
			$('#conv_unit'+id).val(unit);
			$("#hargaT_asli"+id).val($('#harga_barang'+id).val() * $('#qty_barang'+id).val() * unit)
			$('#totDiskon'+id).val(parseInt(($('#harga_barang'+id).val() * ($('#diskon'+id).val() / 100)) * $('#qty_barang'+id).val() * unit));
			$('#total'+id).val(parseInt(($('#qty_barang'+id).val() * unit * $('#harga_barang'+id).val()) - $('#totDiskon'+id).val()));
			   hitungTotal();
		});
		$(document).on('keyup', '.h_barang', function(){  
			   harga = parseFloat($(this).val()) || 0;
			   var id = $(this).data("index");  
			   $("#hargaT_asli"+id).val(harga * $('#qty_barang'+id).val() * $('#conv_unit'+id).val());
			   $('#totDiskon'+id).val(parseInt((harga * ($('#diskon'+id).val() / 100)) * $('#qty_barang'+id).val() * $('#conv_unit'+id).val()));
			   $('#total'+id).val(parseInt(($('#qty_barang'+id).val() * $('#conv_unit'+id).val() * harga) - $('#totDiskon'+id).val()));
			   hitungTotal();
	      });
		  $(document).on("click", '.diskon', function () {
      		 $(this).select();
    	  });   
		  $(document).on('keyup', '.diskon', function(){  
			   diskon = parseFloat($(this).val()) || 0;
				if (diskon > 100) {
					diskon = 100;
					$(this).val(100);
					$(this).select();
				}
				if (diskon < 0) {
					diskon = 0;
					$(this).val(0);
					$(this).select();
				}
				if (diskon == "") {
					diskon = 0;
					$(this).val(0);
					$(this).select();
				}
			   var id = $(this).data("index");  
			   $('#totDiskon'+id).val(parseInt(($('#harga_barang'+id).val() * (diskon / 100)) * $('#qty_barang'+id).val() * $('#conv_unit'+id).val()));
			   $('#total'+id).val(parseInt(($('#qty_barang'+id).val() * $('#conv_unit'+id).val() * $('#harga_barang'+id).val()) - $('#totDiskon'+id).val()));
			   hitungTotal();
	      });
		  $(document).on('keyup', '.totalsPb', function(){ 
			   totalB = parseFloat($(this).val()) || 0;
	           var id = $(this).data("index");   
			   $('#totDiskon'+id).val(0);
			   $('#diskon'+id).val(0)
			   $('#harga_barang'+id).val(parseInt((totalB / $('#qty_barang'+id).val()) * $('#conv_unit'+id).val()));
			   hitungTotal();
	      });
		
		  $('#ppn_beli').keyup(function(){
            ppn = parseFloat($(this).val()) || 0;
			hitungTotal()
          });
		  $('#biaya_kirim').keyup(function(){
            kirim = parseFloat($(this).val()) || 0;
			hitungTotal()
          });
		  $('#jml_bayar').keyup(function(){
            bayar = parseFloat($(this).val()) || 0;
			hitungTotal()
          });
		  
	$('#formBarang').on('keyup keypress', function(e) {
  		if (e.which == 13) { 
  		  e.preventDefault();
  		}
	});

//pembelian order
		$(document).ready(function() {
		  $(".detail_order").click(function(){
          var detail = $(this).data('order');
          //tampil ajax barang
          $.getJSON("<?=site_url('Pembelian/getOrder?n_order=')?>"+detail , function(json){
              console.log(json);
              var html = '';
              var i;
              for(i=0; i<json.length; i++){
                  html += '<tr>'+
                          '<td>'+json[i].n_barang+'</td>'+
                          '<td>'+json[i].namaBarang+'</td>'+
                          '<td>'+json[i].sisaOrder+'</td>'+
                          '<td>'+json[i].jumlahTrima+'</td>'+
                          '</tr>';
					$('#totalOrder').val(json[i].totalOrder);
              }
              	$('#show_detail').html(html);
        	});
    		});
		});
		  
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


<div class="col justify-content-md-center">
	<form action="<?=site_url('Penjualan/do_retpenjualan')?>" id="formPenj" method="POST">
		<div class="row justify-content-md-center">
<!-- INFORMASI NOTA -->
					<div class="container col-md-6 col-lg-3 col-xlg-2">
						<div class="card">
					    	<h5 class="text-white bg-danger p-2">INFORMASI NOTA</h5>
					        <div class="card-body">
				        			<div class="row">
										<label class="col-sm-5 text-left control-label col-form-label">No. Nota</label>
									</div>
        							<div class="row mb-2">
										<div class="input-group">
											<input type="text" class="form-control" name="n_transaksi" id="" value="<?=@$n_transaksi?>" readonly>
											<div class="input-group-append">
												<a href="#myModalPenjualan" data-toggle="modal">
													<button class="btn btn-outline-secondary" type="button"><i class="fa fa-search"></i></button>
												</a>
		                                	</div>
										</div>
				        			</div>
        							<div class="row">
	        							<label class="col-sm-5 text-left control-label col-form-label">Tanggal</label>
									</div>
									<div class="row mb-2">
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
									<div class="row mb-5">
										<div class="input-group">
		                                    <input type="text" class="form-control" name="reff" id="reff" placeholder="Reff" value="">
		                                </div>
									</div>
								</div>
							</div>
							<div class="card">
	    					<h5 class="text-white bg-danger p-2">INFORMASI PELANGGAN</h5>
	        				<div class="card-body">
        							<div class="row">
	        							<label class="col-sm-6 text-left control-label col-form-label">Pelanggan</label>
        							</div>
        							<div class="row">
        								<div class="input-group">
		                                    <input type="text" class="form-control d_Pelanggan" name="n_pelanggan" value="" required>
		                                    <div class="input-group-append">
												<a href="#myModalPelanggan" data-toggle="modal">
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
                    				        <input type="text" class="form-control text-right btn-success d_Batas" name="batas" value="0" disabled>
                    				    </div>
        							</div>
									<div class="row">
	        							<label class="col-sm-8 text-left control-label col-form-label">Total Piutang</label>
        							</div>
        							<div class="row">
        								<div class="input-group">
                    				        <input type="text" class="form-control text-right btn-danger sum_sisa" name="sum_sisa" value="0" disabled>
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
	        									<div class="table-responsive" style="overflow-y: scroll; height: 300px;">
		        									<table class="table" id="dynamic_field"> 
													  <thead class="thead-dark" style="position: sticky; top: 0; display:block; z-index:2;">
													    <tr>
													      <th scope="col" style="width:10%;">Kode</th>
													      <th scope="col" style="width:22%;">Nama Barang</th>
													      <th scope="col" style="width:8%;">Qty</th>
													      <th scope="col" style="width:11%;">Satuan</th>
													      <th scope="col" style="width:12%;">Harga</th>
													      <th scope="col" style="width:6%;">Diskon(%)</th>
													      <th scope="col" style="width:12%;">Total</th>
													      <th scope="col" style="width:5%;">*</th>
													    </tr>
													  </thead>
													  <input type="hidden" name="sum_barang" class="sum_baris" value="0" readonly>
													  <tbody style="display:block;">
													  	<tr id="row0" class="dynamic-added">
															<input type="hidden" id="conv_unit0" name="conversiUnit0" value="" readonly>
															<input type="hidden" name="h_diskon0" id="totDiskon0" value="" readonly>
															<input type="hidden" name="perkiraanPdpt0" id="e_perkiraanPdpt0" data-index="0" value="" readonly>
														    <input type="hidden" name="perkiraanHpp0" id="e_perkiraanHpp0" data-index="0" value=""readonly>
														    <input type="hidden" name="perkiraanPsd0" id="e_perkiraanPsd0" data-index="0" value=""readonly>
															<input type="hidden" name="harga_asli0" id="harga_asli0" value="" readonly>
															<input type="hidden" id="hargaT_asli0" name="hargaT_asli0" value="0" readonly>
															<td class="p-2" style="width:10%;">
																<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang0" id="n_barang0" data-index="0" value="">
															</td>
															<td class="p-2" style="width:14%;">
																<input type="text" class="form-control m-0 p-2 bg-white col" name="nama_barang0" id="nama_barang0" value="" readonly>
															</td>
															<td class="p-2" style="width:5%;">
																<input type="text" class="form-control m-0 p-2 bg-white col qtyB" name="qty_barang0" data-index="0" id="qty_barang0" value="">
															</td>
															<td class="p-2" style="width:11%;">
																<select class="form-control convUnit" name="satuan_barang0" id="satuan_barang0" data-index="0">
											      				  	<option value="1" id="e_nUnit0">PCS</option>
											      				  	<option value="0" id="e_bUnit0"></option>
											      				</select>
															</td>
															<td class="p-2" style="width:14%;">
																<input type="text" class="form-control m-0 p-2 bg-white col h_barang" name="harga_barang0" id="harga_barang0" value="" data-index="0">
																<input type="hidden" class="form-control m-0 p-2 bg-white col h_pokok" name="harga_hpp0" id="harga_hpp0" value="" data-index="0">
																<input type="hidden" name="hrg_diskon0" id="hrg_diskon0" data-index="0" value="">
															</td>
															<td class="p-2" style="width:6%;">
																<input type="text" class="form-control m-0 p-2 bg-white col diskon" name="diskon0" id="diskon0" value="" data-index="0">
															</td>
															<td class="p-2" style="width:14%;">
																<input type="text" class="form-control m-0 p-2 bg-white col totalsPj" id="total0" name="total0" data-index="0" value="" >
																<input type="hidden" class="form-control m-0 p-2 bg-white col totalsHpp" id="total_hpp0" name="total_hpp0" data-index="0" value="" >
															</td>
															<td class="p-2" style="width:0%;" id="action0">
																
															</td>
													 	  </tr>
													  	</tbody>
													</table>
													<hr>
												</div>
	        								</div>
	        								<div class="row">
							        			<div class="row col-lg-6">
							        				<input type="textarea" class="form-control" id="ketr" name="keterangan" placeholder="Catatan Transaksi (Jika Ada)">
							        			</div>
							        			<div class="row col-lg-2">

							        			</div>
												<div class="row col-lg- col-md-4 col-sm-5 btn-danger">
		        									<label class="col-sm-6 col-6 col-md-5 text-right control-label col-form-label pr-0"><h6><b><i>TOTAL</i></b></h6></label>
		        									<div class="col-sm-7 col-7 col-md-7">
    													<input type="text" class="form-control text-right border-0 bg-danger text-light h6 pl-0 pr-0" id="total_jual" name="totalJualbrg" value="0" readonly>
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
				        						<input type="text" class="form-control uang" id="jml_bayar" name="jml_bayar" value="0">
				        					</div>
			        					</div>
			        				
				        					<input type="hidden" class="form-control" id="uang_muka" value="0" name="uang_muka" readonly>
				        				
			        					<!-- <div class="row mb-3">
				        					<label class="col-sm-3 text-left control-label col-form-label">Sisa</label>
				        					<div class="row col-lg-9"> -->
				        						<input type="hidden" class="form-control is-invalid" id="sisa_bayar" name="sisa_bayar" value="0" readonly>
				        					<!-- </div> -->
			        					<!-- </div> -->
			        					<div class="row mb-3">
				        					<label class="col-sm-3 text-left control-label col-form-label">Jatuh Tempo</label>
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
			        							<button type="button" class="btn btn-primary" id="savePj">Simpan & Cetak</button>
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
					        			<input type="text" class="form-control" id="biaya_kirim" name="biaya_kirim" value="0">
					        		</div>
			    	    		</div>
								<div class="row mb-3">
					        		<label class="col-sm-4 text-left control-label col-form-label">PPN</label>
					        		<div class="row col-lg-8">
					        			<input type="text" class="form-control" id="ppn_jual" name="biaya_ppn" value="0">
					        		</div>
			    	    		</div>
					        		<input type="hidden" class="form-control" id="total_diskon" name="total_diskon" value="0" readonly>
								<div class="row mb-3">
					        		<label class="col-sm-4 text-left control-label col-form-label">Total Seluruhnya</label>
					        		<div class="row col-lg-8">
					        			<input type="text" class="form-control" id="total_all" name="total_all" value="0" readonly>
					        		</div>
					        		<input type="hidden" class="form-control text-right"  id="total_hppall" name="total_hppall" value="0" readonly>
			    	    		</div>
							</div>
			        	</div>
					</div>
			    </div>
			</div>
		</div>
	</form>
</div>
</section>
	<div id="myModalPelanggan" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Pilih Pelanggan</h4>
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
                                    <th>Nama Pelanggan</th>
									<th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 0;
                            foreach ($d_pelanggan as $key => $value) { ?>
                                <tr>
                                    <td><?=$value->n_pelanggan?></td>
                                    <td><?=$value->nama?></td>
                                    <input type="hidden" class="no_pelanggan<?=$no?>" value="<?=$value->n_pelanggan?>">
                                    <input type="hidden" class="nama_pelanggan<?=$no?>" value="<?=$value->nama?>">
                                    <input type="hidden" class="nama_sales<?=$no?>" value="<?=$value->nama_sales?>">
                                    <input type="hidden" class="n_sales<?=$no?>" value="<?=$value->n_sales?>">
                                    <input type="hidden" class="batas_kredit<?=$no?>" value="<?=$value->batas?>">
                                    <td align="right"><button type="button" class="btn btn-sm btn-primary chs_pel chs_pelanggan<?=$no?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
                                </tr>
                            <?php $no++; } ?>
                            <input type="hidden" class="sum_pelanggan" value="<?=$no?>">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="myModalSales" class="modal modal-child" data-backdrop-limit="1" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Pilih Salesman</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="lookup-1" class="table lookup" width="100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nama Sales</th>
									<th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 0;
                            foreach ($d_pelanggan as $key => $value) { ?>
                                <tr>
                                    <td><?=$value->n_sales?></td>
                                    <td><?=$value->nama_sales?></td>
                                    <input type="hidden" class="nama_sales<?=$no?>" value="<?=$value->nama_sales?>">
                                    <input type="hidden" class="n_sales<?=$no?>" value="<?=$value->n_sales?>">
                                    <td align="right"><button type="button" class="btn btn-sm btn-primary chs_sales<?=$no?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
                                </tr>
                            <?php $no++; } ?>
                            <input type="hidden" class="sum_sales" value="<?=$no?>">
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
                                    <td align="right"><button type="button" class="btn btn-sm btn-primary chs_bnk chs_bank<?=$no?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
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
                                    <input type="hidden" class="harga_jual1<?=$no?>" value="<?=$value->harga_jual1?>">
                                    <input type="hidden" class="harga_pokok<?=$no?>" value="<?=$value->harga_pokok?>">
                                    <input type="hidden" class="konversi_unit<?=$no?>" value="<?=$value->konversi_unit?>">
                                    <input type="hidden" class="n_unit<?=$no?>" value="<?=$value->n_unit?>">
                                    <input type="hidden" class="b_unit<?=$no?>" value="<?=$value->b_unit?>">
                                    <input type="hidden" class="b_perkiraanHpp<?=$no?>" value="<?=$value->akun_hpp?>">
                                    <input type="hidden" class="b_perkiraanPsd<?=$no?>" value="<?=$value->akun_persediaan?>">
                                    <input type="hidden" class="b_perkiraanPdpt<?=$no?>" value="<?=$value->akun_pendapatan?>">
                                    <td align="right"><button type="button" class="btn btn-sm btn-primary chs_brg chs_barang<?=$no?>" data-dismiss="modal"><i class="fa fa-check"></i></button></td>
                                </tr>
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
	<div id="myModalPenjualan" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<style>
		.tableFixHead          { overflow-y: auto; height: 500px; }
		.tableFixHead thead tr { position: sticky; top: 0; }
		</style>
  		<div class="modal-dialog modal-lg" style="min-width:80%;max-width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Pilih Data Penjualan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
					<div class="row">
						<div class="col-6">
                    		<div class="table-responsive tableFixHead">
								<table id="lookup" class="table lookup" width="100%">
                    	    	    <thead class="thead-dark">
                    	    	        <tr>
                    	    	            <th>Kode Order</th>
                    	    	            <th>Tanggal</th>
											<th>Pelanggan</th>
											<th>Pilih</th>
                    	    	        </tr>
                    	    	    </thead>
                    	    	    <tbody>
                    	    	    <?php $no = 0;
                    	    	    foreach ($d_penjualan as $key => $value) { ?>
                    	    	        <tr>
                    	    	            <td><?=$value->n_penjualan?></td>
                    	    	            <td><?=date_format(date_create($value->tanggal),"d-M-y")?></td>
                    	    	            <td><?=$value->nama_pelanggan?></td>
                    	    	            <td align="right"><button type="button" class="btn btn-info btn-sm detail_penjualan" data-pelanggan="<?=$value->n_pelanggan?> | <?=$value->nama_pelanggan?>" data-trans="<?=$value->n_penjualan?>"><i class="fa fa-check"></i></button></td>
                    	    	        </tr>
                    	    	    <?php $no++; } ?>
                    	    	    <input type="hidden" class="sum_barang" value="<?=$no?>">
                    	    	    </tbody>
                    	    	</table>
							</div>
                    	</div>
						<div class="col-6">
							<div class="row">
								<label class="col-12 text-left h4">Detail Penjualan :</label>
							</div>
							<div class="row" style="overflow-y: auto; height: 400px;">
								<input type="hidden" id="no_penjualan" class="form-control" placeholder="Transaksi Penjualan" readonly>
								<input type="hidden" id="dt_pelanggan" class="form-control" placeholder="No | Nama Pelanggan" readonly>
								<table id="lookup" class="table" style="position: sticky; top: 0;">
                            		<thead class="thead-dark">
                            		    <tr>
                            		        <th>Kode</th>
                            		        <th>Barang</th>
											<th>Qty</th>
											<th>Harga</th>
                            		    </tr>
                            		</thead>
									<tbody id="show_detail">

									</tbody>
                        		</table>
							</div>		
							<div class="row">
								<label class="col-2 text-left control-label col-form-label">Total :</label>
				        		<div class="row col-lg-6">
				        			<input type="text" class="form-control" id="totalPenjualan" value="0" readonly>
				        		</div>
							</div>
							<div class="row d-flex flex-row-reverse">
								<input type="hidden" name="" id="select_retur">		
								<button class="btn btn-success btn-lg ins_retur mr-4">Pilih</button>
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
	$("#savePj").on('click keypress',function() {
		var sel = $('.sum_baris').val();
		if ($('.d_Pelanggan').val()) {
			if ($('#sisa_bayar').val() == 0 || $('#sisa_bayar').val() == 0.00) {
				for (let br = 0; br < sel - 1; br++) {
					parseFloat($('#harga_barang'+br).val($('#harga_barang'+br).val().replace(/[^-.\d]/g, '')));
					parseFloat($('#total'+br).val($('#total'+br).val().replace(/[^-.\d]/g, '')));
				}
				$('#total_jual').val($('#total_jual').val().replace(/[^-.\d]/g, ''));
				$('#jml_bayar').val($('#jml_bayar').val().replace(/[^-.\d]/g, ''));
				$('#sisa_bayar').val($('#sisa_bayar').val().replace(/[^-.\d]/g, ''));
				$('#biaya_kirim').val($('#biaya_kirim').val().replace(/[^-.\d]/g, ''));
				$('#ppn_jual').val($('#ppn_jual').val().replace(/[^-.\d]/g, ''));
				$('#total_all').val($('#total_all').val().replace(/[^-.\d]/g, ''));

				$('#row'+sel).remove();
				$('.sum_baris').val(parseFloat($('.sum_baris').val()) - 1);
				$('#formPenj').submit();
			} else {
				alert('Transaksi Retur barang tidak dapat melalui pembayaran kredit');
			}
    	}
		else{
			alert("Data Pelanggan Belum diisi");
			$('.d_Pelanggan').focus()
		}
	});
//tambah barang
	function tambahBaris(u) {
		$('#dynamic_field').append('<tr id="row'+u+'" "class="dynamic-added">'+
					'<input type="hidden" id="conv_unit'+u+'" name="conversiUnit'+u+'" value="" readonly>'+
					'<input type="hidden" name="h_diskon'+u+'" id="totDiskon'+u+'" value="" readonly>'+
					'<input type="hidden" name="perkiraanPdpt'+u+'" id="e_perkiraanPdpt'+u+'" value="" readonly>'+
					'<input type="hidden" name="perkiraanHpp'+u+'" id="e_perkiraanHpp'+u+'" value="" readonly>'+
					'<input type="hidden" name="perkiraanPsd'+u+'" id="e_perkiraanPsd'+u+'" value="" readonly>'+
					'<input type="hidden" name="harga_asli'+u+'" id="harga_asli'+u+'" value="" readonly>'+
					'<input type="hidden" id="hargaT_asli'+u+'" name="hargaT_asli'+u+'" value="0" readonly>'+
					'<td class="p-2" style="width:10%;">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang'+u+'" id="n_barang'+u+'" data-index="'+u+'" value="">'+
					'</td>'+
					'<td class="p-2" style="width:25%;">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col" name="nama_barang'+u+'" id="nama_barang'+u+'" value="" readonly>'+
					'</td>'+
					'<td class="p-2" style="width:7%;">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col qtyB" name="qty_barang'+u+'" data-index="'+u+'" id="qty_barang'+u+'" value="">'+
					'</td>'+
					'<td class="p-2" style="width:13%;">'+
						'<select class="form-control convUnit" name="satuan_barang'+u+'" id="satuan_barang'+u+'" data-index="'+u+'">'+
						  	'<option value="1" id="e_nUnit'+u+'">PCS</option>'+
						  	'<option value="0" id="e_bUnit'+u+'"></option>'+
						'</select>'+
					'</td>'+
					'<td class="p-2" style="width:16%;">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col h_barang" name="harga_barang'+u+'" id="harga_barang'+u+'" value="" data-index="'+u+'">'+
						'<input type="hidden" class="form-control m-0 p-2 bg-white col h_pokok" name="harga_hpp'+u+'" id="harga_hpp'+u+'" value="" data-index="'+u+'">'+
						'<input type="hidden" name="hrg_diskon'+u+'" id="hrg_diskon'+u+'" data-index="'+u+'" value="">'+
					'</td>'+
					'<td class="p-2" style="width:10%;">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col diskon" name="diskon'+u+'" id="diskon'+u+'" value="" data-index="'+u+'">'+
					'</td>'+
					'<td class="p-2" style="width:16%;">'+
						'<input type="text" class="form-control m-0 p-2 bg-white col totalsPj" id="total'+u+'" name="total'+u+'" data-index="'+u+'" value="">'+
						'<input type="hidden" class="form-control m-0 p-2 bg-white col totalsHpp" id="total_hpp'+u+'" name="total_hpp'+u+'" data-index="'+u+'" value="">'+
					'</td>'+
					'<td class="p-2" id="action'+u+'" style="width:0%;">'+
					'</td>'+
				'</tr>');  	
			var bef = parseFloat(u - 1);
			$('#action'+bef).append('<button type="button" name="remove" data-index="'+bef+'" class="btn btn-danger btn_remove" value="" >X</button>');	
			$('#n_barang'+bef).attr('readonly',true);
			$('.sum_baris').val(parseFloat($('.sum_baris').val()) + 1);
	}
	//hitung total
	function hitungTotal(totalB) {
		var totalB = 0
		var total = 0;
		var totalD = 0;
		var totalJual = $('#total_jual').val();
		var ppn = parseFloat($("#ppn_jual").val().replace(/[^-.\d]/g, ''));
		var kirim = parseFloat($("#biaya_kirim").val().replace(/[^-.\d]/g, ''));
		var bayar = parseFloat($("#jml_bayar").val().replace(/[^-.\d]/g, ''));
		var uangMuka = parseFloat($("#uang_muka").val());
		for (let q = 0; q < $('.sum_baris').val(); q++) {
			if($('#total'+q).val()){
			total += parseFloat($('#total'+q).val().replace(/[^-.\d]/g, ''));
			totalD += parseFloat($('#totDiskon'+q).val());
			}
			$('#total_jual').val(number_format(total,2,'.',','));
			$('#total_diskon').val(totalD);
			$('#total_all').val(number_format(parseFloat(total + ppn + kirim),2,'.',','));
			$('#sisa_bayar').val(number_format(parseFloat(total + ppn + kirim - bayar - uangMuka),2,'.',','));
		}
	}

	function hitungTotalHpp(totalhpp) {
		var totalhpp = 0;
		for (let q = 0; q < $('.sum_baris').val(); q++) {
			if($('#total_hpp'+q).val()){
			totalhpp += parseFloat($('#total_hpp'+q).val());
			}
			$('#total_hppall').val(totalhpp);
		}
	}
//format angka
	$(".money").on("click", function () {
		  $(this).select();
	});
	
	// Format mata uang	
    number_format = function (numbers, decimals, dec_point, thousands_sep) {
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

	/* Fungsi formatRupiah */
	function formatRupiah(angka, prefix){
		var number_string = angka.replace(/[^-.\d]/g, '').toString(),
		split   		= number_string.split('.'),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/[-\d]{3}/gi);
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if(ribuan){
			separator = sisa ? ',' : '';
			rupiah += separator + ribuan.join(',');
		}

		rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
	}

		function getPiutang(pelanggan) {
			$.getJSON("<?=site_url('Piutang/getKartu?n_pelanggan=')?>"+pelanggan , function(json){
    	            console.log(json);
    	            var html = '';
    	            var i;
    	            sum_sisa = 0;
    	            for(i=0; i<json.length; i++){
    	                sum_sisa = sum_sisa + parseFloat(json[i].sisa);
    	                $(".sum_sisa").val(number_format(sum_sisa,2,'.',','));
						console.log(sum_sisa)
    	            }
    	        });
		}

		for (let s=0;s<$(".sum_pelanggan").val(); s++) {
    	    $(".chs_pelanggan"+s).on('click keypress',function(){
    	        $(".d_Pelanggan").val($('.no_pelanggan'+s).val() + " | " + $('.nama_pelanggan'+s).val());
				$(".d_Batas").val(number_format(parseFloat($('.batas_kredit'+s).val()),2,'.',','));
				getPiutang($('.no_pelanggan'+s).val());
    	    });
    	}
    	$(document).on('keypress', '.d_Pelanggan', function(e){
				if(e.keyCode == 13) {
					var detail = $(this).val();
    	      //tampil ajax barang
    	     	 $.getJSON("<?=site_url('Pelanggan/getPelanggan?n_pelanggan=')?>"+detail , function(json){
    	                var value = json.n_pelanggan + " | " + json.nama;
    	                $(".d_Pelanggan").val(value);
						$(".d_Batas").val(number_format(parseFloat(parseFloat(json.batas)),2,'.',','));
						if (json == false) {
							$(".d_Pelanggan").val("");
							$('#myModalPelanggan').modal('show');
						}
						if (json != false) {
    	                   getPiutang(detail);
						   $('#n_barang0').focus();
						}
    	    		});
				}
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
	$(document).on('keypress', '.sn_barang', function(e){
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
					$("#harga_barang"+index).val(number_format(json.harga_jual1,2,'.',','));
					$("#diskon"+index).val(0);
					$("#total"+index).val(number_format(json.harga_jual1,2,'.',','));
					$("#e_perkiraanPdpt"+index).val(json.akun_pendapatan);
					$("#e_perkiraanHpp"+index).val(json.akun_hpp);
					$("#e_perkiraanPsd"+index).val(json.akun_persediaan);
					$("#perkiraan"+index).val(json.akun_persediaan);
					$("#harga_asli"+index).val(json.harga_jual1);
					$("#hargaT_asli"+index).val(json.harga_jual1);
					$("#harga_hpp"+index).val(json.harga_pokok);
					$("#total_hpp"+index).val(json.harga_pokok);
					$("#totDiskon"+index).val(0);
					$("#hrg_diskon"+index).val(json.harga_jual1);
					if (json == false) {
						$('#myModalBarang').modal('show');
						$('#urut_barang').val(index);
					}
					if (json != false) {
						hitungTotal();
						hitungTotalHpp();
						var next = parseFloat(index) + 1; 
						tambahBaris(next);
						$('#qty_barang'+index).focus();
					}
        		});
			}
			if (e.which == 32) {
				$("#ketr").focus();
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
			$("#harga_barang"+urut).val($('.harga_jual1'+b).val(),2,'.',',');
			$("#diskon"+urut).val(0);
			$("#total"+urut).val($('.harga_jual1'+b).val(),2,'.',',');
			$("#e_perkiraanPdpt"+urut).val($('.b_perkiraanPdpt'+b).val());
			$("#e_perkiraanHpp"+urut).val($('.b_perkiraanHpp'+b).val());
			$("#e_perkiraanPsd"+urut).val($('.b_perkiraanPsd'+b).val());
			$("#harga_asli"+urut).val($('.harga_jual1'+b).val());
			$("#hargaT_asli"+urut).val($('.harga_jual1'+b).val());
			$("#harga_hpp"+urut).val($('.harga_pokok'+b).val());
			$("#total_hpp"+urut).val($('.harga_pokok'+b).val());
			$("#totDiskon"+urut).val(0);
			$("#hrg_diskon"+urut).val($('.harga_jual1'+b).val());
			var next = parseFloat(urut) + 1; 
			tambahBaris(next);
			total = 0;
			totalD = 0;
			totalhpp = 0;
			hitungTotal();
			hitungTotalHpp();
		});
	}
//olah data barang

	      $(document).on('click', '.btn_remove', function(){ 
			   var id = $(this).data("index");
	           $('#row'+id).remove();

			   hitungTotal();
			   hitungTotalHpp();
	      });
		  $(document).on('keyup', '.qtyB', function(){  
			   qty = parseFloat($(this).val()) || 0;
			   var id = $(this).data("index");  
			   $("#hargaT_asli"+id).val($('#harga_barang'+id).val().replace(/[^-.\d]/g, '') * qty);
			   $('#totDiskon'+id).val(parseFloat(($('#harga_barang'+id).val().replace(/[^-.\d]/g, '') * ($('#diskon'+id).val() / 100)) * qty * $('#conv_unit'+id).val()));
			   $('#total_hpp'+id).val(parseFloat($('#harga_hpp'+id).val() * qty));
			   $('#total'+id).val(parseFloat((qty * $('#conv_unit'+id).val() * $('#harga_barang'+id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon'+id).val()));
			   $('#total'+id).val(number_format($('#total'+id).val(),2,'.',','))

			   hitungTotal();
			   hitungTotalHpp();
	      });
		  $(document).on('change', '.convUnit', function(){ 
			var id = $(this).data("index");  
			var unit = $(this).val();
			$('#conv_unit'+id).val(unit);
			$('#harga_barang'+id).val(number_format(parseFloat($('#harga'+id).val() * unit),2,'.',','));
			$("#hargaT_asli"+id).val($('#harga_barang'+id).val().replace(/[^-.\d]/g, '') * $('#qty_barang'+id).val() * unit)
			$('#totDiskon'+id).val(parseFloat(($('#harga_barang'+id).val().replace(/[^-.\d]/g, '') * ($('#diskon'+id).val() / 100)) * $('#qty_barang'+id).val() * unit));
			$('#total'+id).val(parseFloat(($('#qty_barang'+id).val() * $('#harga_barang'+id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon'+id).val()));
			$('#total'+id).val(number_format($('#total'+id).val(),2,'.',','))
			$('#total_hpp'+id).val(parseFloat(($('#harga_hpp'+id).val() * $('#qty_barang'+id).val() * unit)));
			   hitungTotal();
			   hitungTotalHpp();
		});
		$(document).on('keyup', '.h_barang', function(){  
			$(this).val(formatRupiah(this.value))
			harga = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
			var id = $(this).data("index");  
			$("#hrg_diskon"+id).val(harga - (harga * ($('#diskon'+id).val() / 100)));
			$('#totDiskon'+id).val(parseFloat((harga * ($('#diskon'+id).val() / 100)) * $('#qty_barang'+id).val()));
			$('#total'+id).val(parseFloat(($('#qty_barang'+id).val() * harga) - $('#totDiskon'+id).val()));
			$('#total'+id).val(number_format($('#total'+id).val(),2,'.',','))
			hitungTotal();
	      });

		$(document).on('keyup', '.h_pokok', function(){  
			   hargah = parseFloat($(this).val()) || 0;
			   var id = $(this).data("index");  
			   $('#total_hpp'+id).val(parseFloat($('#qty_barang'+id).val() * $('#conv_unit'+id).val() * hargah));
			   hitungTotalHpp();
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
			   $('#hrg_diskon'+id).val(parseFloat($('#harga_barang'+id).val().replace(/[^-.\d]/g, '') - ($('#harga_barang'+id).val().replace(/[^-.\d]/g, '')  * (diskon / 100))));
			   $('#totDiskon'+id).val(parseFloat(($('#harga_barang'+id).val().replace(/[^-.\d]/g, '') * (diskon / 100)) * $('#qty_barang'+id).val()));
			   $('#total'+id).val(parseFloat(($('#qty_barang'+id).val() * $('#harga_barang'+id).val().replace(/[^-.\d]/g, '')) - $('#totDiskon'+id).val()));
			   $('#total'+id).val(number_format($('#total'+id).val(),2,'.',','))
			   hitungTotal();
	      });
		  $(document).on('keyup', '.totalsPj', function(e){ 
			    if (e.keyCode != 13) {
				$(this).val(formatRupiah(this.value))
				totalB = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
	           	var id = $(this).data("index");   
			   	$('#totDiskon'+id).val(0);
			   	$('#diskon'+id).val(0)
			   	$('#harga_barang'+id).val(parseFloat((totalB / $('#qty_barang'+id).val())));
				$('#harga_barang'+id).val(number_format($('#harga_barang'+id).val(),2,'.',','));
				$("#hrg_diskon"+id).val($('#harga_barang'+id).val().replace(/[^-.\d]/g, '') - ($('#harga_barang'+id).val().replace(/[^-.\d]/g, '') * ($('#diskon'+id).val() / 100)));
			   	hitungTotal();
			  }
	      });

	      $(document).on('keyup', '.totalsHpp', function(){ 
	      	totalH = parseFloat($(this).val()) || 0;
	           var id = $(this).data("index");   
			   $('#total_hpp'+id).val(0);
			   $('#harga_hpp'+id).val(0);
			   hitungTotalHpp();
	      });
		
		  $('#ppn_jual').keyup(function(){
            $(this).val(formatRupiah(this.value));
            ppn = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
			hitungTotal()
          });
		  $('#biaya_kirim').keyup(function(){
            $(this).val(formatRupiah(this.value));
            kirim = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
			hitungTotal()
          });
		  $('#jml_bayar').keyup(function(){
            $(this).val(formatRupiah(this.value));
            bayar = parseFloat($(this).val().replace(/[^-.\d]/g, '')) || 0;
			hitungTotal()
          });
		  
	$('#formPenj').on('keyup keypress', function(e) {
  		if (e.which == 13) { 
  		  e.preventDefault();
  		}
	});
//retur barang
$(".ins_retur").click(function(){
	var detail = $("#no_penjualan").val();
	$('#reff').val(detail)
	$('#myModalPenjualan').modal('hide');
	$('#row0').remove();
	$.getJSON("<?=site_url('Penjualan/getPenjualan?n_penjualan=')?>"+detail , function(json){
      var u;
      for(u=0; u<json.length; u++){
		$('#dynamic_field').append('<tr id="row'+u+'" "class="dynamic-added">'+
			'<input type="hidden" id="conv_unit'+u+'" name="conversiUnit'+u+'" value="'+json[u].conv_unit+'" readonly>'+
			'<input type="hidden" name="h_diskon'+u+'" id="totDiskon'+u+'" value="'+parseFloat((json[u].harga_asli * json[u].jumlah) - (json[u].harga * json[u].jumlah))+'" readonly>'+
			'<input type="hidden" name="perkiraanPdpt'+u+'" id="e_perkiraanPdpt'+u+'" value="'+json[u].akunpdpt+'" readonly>'+
			'<input type="hidden" name="perkiraanHpp'+u+'" id="e_perkiraanHpp'+u+'" value="'+json[u].akunhpp+'" readonly>'+
			'<input type="hidden" name="perkiraanPsd'+u+'" id="e_perkiraanPsd'+u+'" value="'+json[u].akunpsd+'" readonly>'+
			'<input type="hidden" name="hrg_diskon'+u+'" id="hrg_diskon'+u+'" value="'+json[u].harga+'" readonly>'+
			'<input type="hidden" id="hargaT_asli'+u+'" name="hargaT_asli'+u+'" value="'+parseFloat(json[u].harga_asli * json[u].jumlah)+'" readonly>'+
			'<input type="hidden" id="harga'+u+'" name="harga'+u+'" value="'+json[u].harga+'" readonly>'+
			'<td class="p-2" style="width:10%;">'+
				'<input type="text" class="form-control m-0 p-2 bg-white col sn_barang" name="n_barang'+u+'" id="n_barang'+u+'" data-index="'+u+'" value="'+json[u].n_barang+'" readonly>'+
			'</td>'+
			'<td class="p-2" style="width:25%;">'+
				'<input type="text" class="form-control m-0 p-2 bg-white col" name="nama_barang'+u+'" id="nama_barang'+u+'" value="'+json[u].namaBarang+'" readonly>'+
			'</td>'+
			'<td class="p-2" style="width:7%;">'+
				'<input type="text" class="form-control m-0 p-2 bg-white col qtyB" name="qty_barang'+u+'" data-index="'+u+'" id="qty_barang'+u+'" value="'+json[u].jumlah+'" readonly>'+
			'</td>'+
			'<td class="p-2" style="width:13%;">'+
				'<select class="form-control convUnit" name="satuan_barang'+u+'" id="satuan_barang'+u+'" data-index="'+u+'" readonly>'+
				  	'<option value="'+json[u].conv_unit+'" id="e_Unit'+u+'">'+json[u].satuan+'</option>'+
				'</select>'+
			'</td>'+
			'<td class="p-2" style="width:16%;">'+
				'<input type="text" class="form-control m-0 p-2 bg-white col h_barang" name="harga_barang'+u+'" id="harga_barang'+u+'" value="'+number_format(json[u].harga_asli,2,'.',',')+'" data-index="'+u+'" readonly>'+
				'<input type="hidden" class="form-control m-0 p-2 bg-white col h_pokok" name="harga_hpp'+u+'" id="harga_hpp'+u+'" value="'+number_format(json[u].hargapokok,2,'.',',')+'" data-index="'+u+'">'+
			'</td>'+
			'<td class="p-2" style="width:10%;">'+
				'<input type="text" class="form-control m-0 p-2 bg-white col diskon" name="diskon'+u+'" id="diskon'+u+'" value="'+json[u].disc+'" data-index="'+u+'" readonly>'+
			'</td>'+
			'<td class="p-2" style="width:16%;">'+
				'<input type="text" class="form-control m-0 p-2 bg-white col totalsPb" id="total'+u+'" name="total'+u+'" data-index="'+u+'" value="'+number_format(parseFloat(json[u].harga * json[u].jumlah),2,'.',',')+'" readonly>'+
				'<input type="hidden" class="form-control m-0 p-2 bg-white col totalsHpp" id="total_hpp'+u+'" name="total_hpp'+u+'" data-index="'+u+'" value="'+number_format(parseFloat(json[u].hargapokok * json[u].jumlah),2,'.',',')+'">'+
			'</td>'+
			'<td class="p-2" id="action'+u+'">'+
			'</td>'+
			'</tr>'
		);
	  }
	$('.d_Pelanggan').val($('#dt_pelanggan').val());
	$('.sum_baris').val(parseInt(json.length + 1));
	hitungTotal();
	hitungTotalHpp();
	});
	/*mulaisini*/
	var n_pelanggan = $('#dt_pelanggan').val().split(" | ");
	$.getJSON("<?=site_url('Pelanggan/getPelanggan?n_pelanggan=')?>"+n_pelanggan[0] , function(json){
		console.log(json);
		$(".d_Batas").val(number_format(json.batas,2,'.',','));
		if (json == false) {
			$(".d_Pelanggan").val("");
			$('#myModalPenjualan').modal('show');
		}
		if (json != false) {
    	   getPiutang(n_pelanggan[0]);
		   $('#n_barang0').focus();
		}
    });
});

$(".detail_penjualan").click(function(){
  var detail = $(this).data('trans');
  $("#no_penjualan").val($(this).data('trans'));
  $("#dt_pelanggan").val($(this).data('pelanggan'));
  $('#select_retur').val(detail);
  //tampil ajax barang
  $.getJSON("<?=site_url('Penjualan/getPenjualan?n_penjualan=')?>"+detail , function(json){
      var html = '';
      var i;
      for(i=0; i<json.length; i++){
          html += '<tr>'+
                  '<td>'+json[i].n_barang+'</td>'+
                  '<td>'+json[i].namaBarang+'</td>'+
                  '<td>'+json[i].jumlah+'</td>'+
                  '<td>'+number_format(json[i].harga,2,'.',',')+'</td>'+
                  '</tr>';
			$('#totalPenjualan').val(number_format(json[i].totalPenj,2,'.',','));
      }
      	$('#show_detail').html(html);
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

//focus 
	$(document).ready(function() {
		$('#reff').focus();
		$('.modal').on('shown.bs.modal', function () {
            $('input[type="search"]').val('')
            $('input[type="search"]').focus()
        });
		$('#myModalPelanggan input[type="search"]').keypress(function(e) {
  			if (e.which == 13) { 
        	    $('.chs_pel:first').focus();
  			}
    	});
		$('#myModalBarang input[type="search"]').keypress(function(e) {
			if (e.which == 13) { 
        		$('.chs_brg:first').focus();
  			}
    	});
		$('#myModalBank input[type="search"]').keypress(function(e) {
			if (e.which == 13) { 
        		$('.chs_bnk:first').focus();
  			}
    	});
		$('#myModalPelanggan').on('hidden.bs.modal', function () {
			$('#n_barang0').focus();
        });
		$('#myModalBarang').on('hidden.bs.modal', function () {
			var slct = $('#urut_barang').val()
			$('#qty_barang'+slct).focus();
        });
		$('#myModalBank').on('hidden.bs.modal', function () {
			$('#jml_bayar').focus();
        });
	});
	$('#reff').on('keypress', function(e) {
  		if (e.which == 13) { 
            $( ".d_Pelanggan" ).focus();
        }
    });
		$(document).on('keypress','.qtyB', function(e) {
			let index = $(this).data('index'); 
  			if (e.which == 13) { 
        	    $( "#satuan_barang"+index).focus();
        	}
    	});
		$(document).on('keypress','.convUnit', function(e) {
			let index = $(this).data('index'); 
  			if (e.which == 13) { 
    	        $( "#harga_barang"+index).focus();
    	    }
    	});
		$(document).on('keypress','.h_barang', function(e) {
			let index = $(this).data('index'); 
  			if (e.which == 13) { 
    	        $( "#diskon"+index).focus();
    	    }
    	});
		$(document).on('keypress','.diskon', function(e) {
			let index = $(this).data('index'); 
  			if (e.which == 13) { 
    	        $( "#total"+index).focus();
    	    }
    	});
		$(document).on('keypress','.totalsPj', function(e) {
			let index = $(this).data('index');
			index += 1 
  			if (e.which == 13) { 
    	        $("#n_barang"+index).focus();
    	    }
    	});
		$("#ketr").keypress(function(e) {
  			if (e.which == 13) { 
    	        $("#c_kas").focus();
    	    }
    	});
		$("#biaya_kirim").keypress(function(e) {
  			if (e.which == 13) { 
    	        $("#ppn_jual").focus();
    	    }
    	});
		$("#biaya_kirim").keypress(function(e) {
  			if (e.which == 13) { 
    	        $("#ppn_jual").focus();
    	    }
    	});
		$("#ppn_jual").keypress(function(e) {
  			if (e.which == 13) { 
    	        $("#c_kas").focus();
    	    }
    	});
		$( "#c_kas" ).on('keypress', function(e) {
        	if (e.which == 32) { 
        	    $(this).removeClass('btn-success');
        	    $(this).addClass('btn-secondary');  
        	    $("#c_bank").removeClass('btn-secondary');  
        	    $("#c_bank").addClass('btn-success');
			    $("#c_bayar").val($("#c_bank").val());
			    $('.bank').show();
        	    $('.bank').removeAttr("disabled");
        	    $('#myModalBank').modal('show');
        	}  
        	if (e.keyCode == 13) { 
        	    $('#jml_bayar').focus();
        	}
   		});
		$('#jml_bayar').keypress(function(e) {
  			if (e.which == 13) { 
    	        $('#savePj').focus();
    	    }
    	});

	$(document).on('click focus','input', function(){
		$(this).select();
    });
    </script>


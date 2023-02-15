<body>
	<div class="col justify-content-md-center pt-3">
		<div class="row mr-3 mb-0" style="margin-top:-7%;">
		     <!-- Column -->
			 <div class=" ml-auto">
			 	<div class="card card-hover mb-0"><a href="<?=site_url('pembelian')?>">
					<?php if ($judul_title == 'Transaksi Pembelian' ) {
			       			echo '<div class="btn btn-primary">
							 	<span class="">Transaksi Pembelian</span>';
							};
							if ($judul_title == 'Transaksi Retur Pembelian' ) {
								echo '<div class="btn btn-outline-primary">
							 		   <span class="">Transaksi Pembelian</span>';
							};
					?>
			        </div></a>
			    </div>
			</div>
			<!-- Column -->
			<div class="ml-2">
			    <div class="card card-hover mb-0"><a href="<?=site_url('pembelian/ret_beli')?>">
						<?php if ($judul_title == 'Transaksi Pembelian' ) {
			        				echo '<div class="btn btn-outline-danger">
										<span class="">Retur Pembelian</span>';
								};
								if ($judul_title == 'Transaksi Retur Pembelian' ) {
									echo '<div class="btn btn-danger">
										<span class="">Retur Pembelian</span>';
								};
						?>
			        </div></a>
			    </div>
			</div>		
		</div>
	</div>
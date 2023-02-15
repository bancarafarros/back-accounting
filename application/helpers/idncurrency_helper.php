<?php
defined('BASEPATH') or exit('No direct script access allowed');

function currencyIDR($nominal, $symbol = true)
{
	$val = "";
	if ($symbol) {
		$val .= "Rp. ";
	}

	$val .= number_format($nominal, 0, ",", ".");
	return $val;
}

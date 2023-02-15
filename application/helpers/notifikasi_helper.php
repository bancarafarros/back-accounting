<?php
function sendEmail($recipient, $subyek, $message)
{
	$ci = &get_instance();
	date_default_timezone_set('Asia/Jakarta');
	$ci->config->load('email');
	$sender = $ci->config->item('smtp_user');
	$ci->email->from($sender, 'Admin BG Skin');
	$ci->email->to($recipient);
	$ci->email->subject($subyek);
	$ci->email->message($message);
	return $ci->email->send();
}

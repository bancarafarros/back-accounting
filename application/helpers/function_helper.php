<?php

$ci = &get_instance();


function active_page($page, $class)
{
	$_this = &get_instance();
	if ($page == $_this->uri->segment(1)) {
		return $class;
	}
}
function active_subpage($pages)
{
	$_this = &get_instance();
	$active = '';

	if ((count($pages) == 1 && $pages[0] == $_this->uri->segment(1)) && $_this->uri->segment(2) == null) {
		$active = 'active';
	} else {
		foreach ($pages as $key => $page) {
			if ($page == $_this->uri->segment($key + 1) && count($pages) > 1) {
				$active = 'active';
			} else {
				$active = '';
			}
		}
	}

	return $active;
}

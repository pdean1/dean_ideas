<?php
/**
 * This function checks the supplied parameter for a valid uwg email in the format of @westga.edu
 * or @my.westga.edu
 * 
 * @param String $email Email to check if it is valid
 * @return boolean True if passed, False if not
 * @deprecated
 */
function is_valid_uwg_email($email) {
	$at = strpos($email, '@');
	if ($at) {
		$email_parts = explode('@', $email);
		$domain_parts = explode('.', $email_parts[1]);
		if ($domain_parts[0] == 'westga') {
			if ($domain_parts[1] == 'edu') {
				return true;
			} else { return false; }
		} else if ($domain_parts[0] == 'my') {
			if ($domain_parts[1] == 'westga') {
				if ($domain_parts[2] == 'edu') {
					return true;
				} else { return false; }
			} else { return false; }
		} else { return false; }
	} else { return false; }
}
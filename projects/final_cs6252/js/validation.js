/**
 * This file contains JavaScript validation to re-enforce data validitity 
 * @author Patrick Dean
 * @version 04.07.2015
 */

/**
 * This function checks an email to ensure it is a UWG email.
 * 
 * @param input
 *            This is the input to check
 * @returns Boolean true if valid false if not
 */
function checkEmail(input) {
	var controlClass = "form-control";
	input.className = controlClass;
	var email = input.value.toLowerCase();
	var at = email.indexOf("@");
	if (at === -1) {
		input.className += " input-error";
		return false;
	} else {
		var domain = email.slice(at + 1);
		var dot = domain.indexOf(".");
		if (dot === -1) {
			input.className += " input-error";
			return false;
		} else {
			domainParts = domain.split(".");
			if (domainParts[0] === "my") {
				if (domainParts[1] === "westga") {
					if (domainParts[2] === "edu") {
						input.className += " input-success";
						return true;
					} else {
						input.className += " input-error";
						return false;
					}
				} else {
					input.className += " input-error";
					return false;
				}
			} else if (domainParts[0] === "westga") {
				if (domainParts[1] === "edu") {
					input.className += " input-success";
					return true;
				} else {
					input.className += " input-error";
					return false;
				}
			} else {
				input.className += " input-error";
				return false;
			}
		}
	}
}
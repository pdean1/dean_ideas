<?php
/**
 * This class represents html input field objects. It creates an abject associated with the 
 * name of the html input and can attach a message to the input.
 * @author Patrick Dean
 * @version 04.07.2015
 */
class Field {
	private $name;
	private $message = '';
	private $hasError = false;
	
	/**
	 * This is the constructor for field objects
	 *
	 * @param string $name
	 *        	The name of the html input
	 * @param string $message
	 *        	The message to be shown near the field
	 */
	public function __construct($name, $message = '') {
		$this->name = $name;
		$this->message = $message;
	}
	
	/**
	 * Returns the fields name
	 *
	 * @return string Field's name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Returns the message associated with the field object
	 *
	 * @return string The objects associated message
	 */
	public function getMessage() {
		return $this->message;
	}
	
	/**
	 * Checks to see if the field has an error
	 *
	 * @return boolean True = error present, false otherwise
	 */
	public function hasError() {
		return $this->hasError;
	}
	
	/**
	 * This function sets an error message and the hasError Boolean to true
	 *
	 * @param string $message
	 *        	An Error Message
	 */
	public function setErrorMessage($message) {
		$this->message = $message;
		$this->hasError = true;
	}
	
	/**
	 * Resets the message and sets the hasError Boolean to false
	 */
	public function clearErrorMessage() {
		$this->message = '';
		$this->hasError = false;
	}
	
	/**
	 * Gets html markup associated with the field.
	 * If the field contains an error,
	 * the span class will represent it as such.
	 *
	 * @return string A message indicating a normal message or an error message
	 */
	public function getHTML() {
		$message = htmlspecialchars ( $this->message );
		if ($this->hasError ()) {
			return $message;
		} else {
			return $message;
		}
	}
}

/**
 * This class represents a collection of field objects
 *
 * @author Patrick Dean
 * @version 04.07.2015
 */
class Fields {
	private $fieldsCollection = array ();
	/**
	 * Adds a field to the collection based on the params passed to the function
	 *
	 * @param string $name
	 *        	Name of the html input
	 * @param string $message
	 *        	Message associated with the input
	 */
	public function addField($name, $message = '') {
		$field = new Field ( $name, $message );
		$this->fieldsCollection [$field->getName ()] = $field;
	}
	/**
	 * Takes the name of the index in the field collection and returns the object from the array
	 *
	 * @param string $name
	 *        	Name of the index in the Field Collection
	 * @return Field Returns a Field object
	 */
	public function getField($name) {
		return $this->fieldsCollection[$name];
	}
	/**
	 * Checks the Field Collection Array and scans it for errors.
	 *
	 * @return boolean True if error is present, false otherwise
	 */
	public function hasErrors() {
		foreach ( $this->fieldsCollection as $field ) {
			if ($field->hasError ()) {
				return true;
			}
		}
		return false;
	}
}
?>
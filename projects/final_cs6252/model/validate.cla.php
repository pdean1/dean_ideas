<?php
/**
 * This is the OO approach for HTML Input Validation.
 *
 * @author Patrick Dean
 * @version 04.07.2015
 */
class Validate {
  private $fieldCollection;
  
  /**
   * Initializes the instance variables
   */
  public function __construct() {
    $this->fieldCollection = new Fields();
  }
  
  /**
   * Returns a reference to the instance
   *
   * @return The collection fields
   */
  public function getFields() {
    return $this->fieldCollection;
  }
  
  /**
   * This function validates a text field
   *
   * @param string $name
   *          Name of the field
   * @param string $value
   *          Value of the field
   * @param boolean $required
   *          true if the field is required false if not
   * @param number $min
   *          Minimum amount for $value
   * @param number $max
   *          Maximum amount for $value
   */
  public function text($name, $value, $required = true, $min = 1, $max = 255) {
    // Get Field object
    $field = $this->fieldCollection->getField($name);
    // If field is not required and empty, remove errors and exit
    if (! $required && empty($value)) {
      $field->clearErrorMessage();
      return;
    }
    // Check field and set or clear error message
    if ($required && empty($value)) {
      $field->setErrorMessage('Required.');
    } else if (strlen($value) < $min) {
      $field->setErrorMessage('Too short.');
    } else if (strlen($value) > $max) {
      $field->setErrorMessage('Too long.');
    } else {
      $field->clearErrorMessage();
    }
  }
  
  /**
   * Validates a field based on the supplied $pattern
   *
   * @param string $name
   *          Name of the field elements index
   * @param string $value
   *          The value the pattern will be checking
   * @param regex $pattern
   *          The pattern to check the value with
   * @param string $message
   *          Message display if error is present
   * @param string $required
   *          Optional, required if true, false otherwise
   */
  public function pattern($name, $value, $pattern, $message, $required = true) {
    // Get Field object
    $field = $this->fieldCollection->getField($name);
    // If field is not required and empty, remove errors and exit
    if (! $required && empty($value)) {
      $field->clearErrorMessage();
      return;
    }
    // Check field and set or clear error message
    $match = preg_match($pattern, $value);
    if ($match === false) {
      $field->setErrorMessage('Error testing field.');
    } else if ($match != 1) {
      $field->setErrorMessage($message);
    } else {
      $field->clearErrorMessage();
    }
  }
  
  /**
   * Checks the $value for a valid phone number
   *
   * @param string $name
   *          Name of the field elements index
   * @param string $value
   *          Value to be checked
   * @param string $required
   *          Required if true, otherwise false
   */
  public function phone($name, $value, $required = false) {
    $field = $this->fieldCollection->getField($name);
    // Call the text method and exit if it yields an error
    $this->text($name, $value, $required);
    if ($field->hasError()) {
      return;
    }
    // Call the pattern method to validate a phone number 000-000-0000
    $pattern = '/^[[:digit:]]{3}-[[:digit:]]{3}-[[:digit:]]{4}$/';
    $message = 'Invalid phone number. Format must be: 111-111-1111';
    $this->pattern($name, $value, $pattern, $message, $required);
  }
  
  /**
   * Checks the $value for a valid email
   *
   * @param string $name
   *          Name of the field elements index
   * @param string $value
   *          Value to be checked
   * @param string $required
   *          Required if true, otherwise false
   */
  public function email($name, $value, $required = true) {
    $field = $this->fieldCollection->getField($name);
    // If field is not required and empty, remove errors and exit
    if (! $required && empty($value)) {
      $field->clearErrorMessage();
      return;
    }
    // Call the text method and exit if it yields an error
    $this->text($name, $value, $required);
    if ($field->hasError()) {
      return;
    }
    // Split email address on @ sign and check parts
    $parts = explode('@', $value);
    if (count($parts) < 2) {
      $field->setErrorMessage('At sign required.');
      return;
    }
    if (count($parts) > 2) {
      $field->setErrorMessage('Only one at sign allowed.');
      return;
    }
    $local = $parts [0];
    $domain = $parts [1];
    // Check lengths of local and domain parts
    if (strlen($local) > 64) {
      $field->setErrorMessage('Username part too long.');
      return;
    }
    if (strlen($domain) > 255) {
      $field->setErrorMessage('Domain name part too long.');
      return;
    }
    // Patterns for address formatted local part
    $atom = '[[:alnum:]_!#$%&\'*+\/=?^`{|}~-]+';
    $dotatom = '(\.' . $atom . ')*';
    $address = '(^' . $atom . $dotatom . '$)';
    // Patterns for quoted text formatted local part
    $char = '([^\\\\"])';
    $esc = '(\\\\[\\\\"])';
    $text = '(' . $char . '|' . $esc . ')+';
    $quoted = '(^"' . $text . '"$)';
    // Combined pattern for testing local part
    $localPattern = '/' . $address . '|' . $quoted . '/';
    // Call the pattern method and exit if it yields an error
    $this->pattern($name, $local, $localPattern, 'Invalid username part.');
    if ($field->hasError()) {
      return;
    }
    // Patterns for domain part
    $hostname = '([[:alnum:]]([-[:alnum:]]{0,62}[[:alnum:]])?)';
    $hostnames = '(' . $hostname . '(\.' . $hostname . ')*)';
    $top = '\.[[:alnum:]]{2,6}';
    $domainPattern = '/^' . $hostnames . $top . '$/';
    // Call the pattern method
    $this->pattern($name, $domain, $domainPattern, 'Invalid domain name part.');
  }
  
  /**
   * Checks the $value for a valid uwg email - my.westga.edu - or - westga.edu
   *
   * @param string $name
   *          Name of the field elements index
   * @param string $value
   *          Value to be checked
   * @param string $required
   *          Required if true, otherwise false
   */
  public function uwgEmail($name, $value, $required = true) {
    $field = $this->fieldCollection->getField($name);
    // If field is not required and empty, remove errors and exit
    if (! $required && empty($value)) {
      $field->clearErrorMessage();
      return;
    }
    // Call the text method and exit if it yields an error
    $this->text($name, $value, $required);
    if ($field->hasError()) {
      return;
    }
    // Split email address on @ sign and check parts
    $parts = explode('@', $value);
    if (count($parts) < 2) {
      $field->setErrorMessage('At sign required.');
      return;
    }
    if (count($parts) > 2) {
      $field->setErrorMessage('Only one at sign allowed.');
      return;
    }
    $user = $parts [0];
    if (strlen($user) > 64) {
      $field->setErrorMessage('Username part too long.');
      return;
    }
    if ($this->is_valid_uwg_email($value)) {
      $field->clearErrorMessage();
      return;
    } else {
      $field->setErrorMessage('Email is not a valid UWG email.');
    }
  }
  
  /**
   * Validates a password.
   * Must be longer than 6 characters.
   *
   * @param string $name
   *          Name of the field elements index
   * @param unknown $password
   *          Value to be checked
   * @param string $required
   *          Required if true, otherwise false
   */
  public function password($name, $password, $required = true) {
    $field = $this->fieldCollection->getField($name);
    if (! $required && empty($password)) {
      $field->clearErrorMessage();
      return;
    }
    $this->text($name, $password, $required, 6);
    if ($field->hasError()) {
      return;
    }
    // Patterns to validate password
    $charClasses = array();
    $charClasses [] = '[:digit:]';
    $charClasses [] = '[:upper:]';
    $charClasses [] = '[:lower:]';
    $charClasses [] = '[:punct:]';
    $pw = '/^';
    $valid = '[';
    foreach ($charClasses as $charClass) {
      $pw .= '(?=.*[' . $charClass . '])';
      $valid .= $charClass;
    }
    $valid .= ']{6,}';
    $pw .= $valid . '$/';
    $pwMatch = preg_match($pw, $password);
    if ($pwMatch === false) {
      $field->setErrorMessage('Error testing password.');
      return;
    } else if ($pwMatch != 1) {
      $field->setErrorMessage('Must have one each of uppercase and lowercase letter, a digit, and a special character (! $ % @ #).');
      return;
    }
  }
  
  /**
   * Checks for money values
   *
   * @param string $name
   *          Name of the field
   * @param string $value
   *          Value to check against
   */
  public function money($name, $value) {
    $field = $this->fieldCollection->getField($name);
    $checkAgainst = "/^(?:[1-9]\d+|\d)(?:\.\d\d)?$/";
    $match = preg_match($checkAgainst, $value);
    if ($match === false) {
      $field->setErrorMessage('Error testing money value.');
      return;
    } else if ($match != 1) {
      $field->setErrorMessage('Money must be formated like (containing no letters): 1,024.24.');
      return;
    } else {
      $field->clearErrorMessage();
      return;
    }
  }
  
  /**
   * This function checks the supplied parameter for a valid uwg email in the format of @westga.edu
   * or @my.westga.edu
   *
   * @param String $email
   *          Email to check if it is valid
   * @return boolean True if passed, False if not
   */
  private function is_valid_uwg_email($email) {
    $at = strpos($email, '@');
    if ($at) {
      $email_parts = explode('@', $email);
      $domain_parts = explode('.', $email_parts [1]);
      if ($domain_parts [0] == 'westga') {
        if ($domain_parts [1] == 'edu') {
          return true;
        } else {
          return false;
        }
      } else if ($domain_parts [0] == 'my') {
        if ($domain_parts [1] == 'westga') {
          if ($domain_parts [2] == 'edu') {
            return true;
          } else {
            return false;
          }
        } else {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}
?>
<?php
/**
 * This file aids in sending email messages to a user
 */
require_once 'Mail-1.3.0/Mail.php';
require_once 'Mail-1.3.0/Mail/RFC822.php';

/**
 * This function helps send email messages
 *
 * @param mixed $to
 *          Who the email is sent to
 * @param mixed $from
 *          Who sent the email
 * @param string $subject
 *          Subject of the email
 * @param string $body
 *          Body of the Message
 * @param boolean $is_body_html
 *          True if the body contains html, false other wise
 * @throws Exception
 */
function send_email($to, $from, $subject, $body, $is_body_html = false) {
  // This was added to remove the issue with the program being unable to find files - Patrick Dean
  restore_include_path();
  if (! valid_email($to)) {
    throw new Exception('This To address is invalid: ' . htmlspecialchars($to));
  }
  if (! valid_email($from)) {
    throw new Exception('This From address is invalid: ' . htmlspecialchars($from));
  }
  
  $smtp = array();
  // **** You must change the following to match your
  // **** SMTP server and account information.
  $smtp ['host'] = 'ssl://smtp.gmail.com';
  $smtp ['port'] = 465;
  $smtp ['auth'] = true;
  $smtp ['username'] = 'uwg.marketplace@gmail.com';
  $smtp ['password'] = 'sup3s3cr3t';
  
  $mailer = Mail::factory('smtp', $smtp);
  if (PEAR::isError($mailer)) {
    throw new Exception('Could not create mailer.');
  }
  
  // Add the email address to the list of all recipients
  $recipients = array();
  $recipients [] = $to;
  
  // Set the headers
  $headers = array();
  $headers ['From'] = $from;
  $headers ['To'] = $to;
  $headers ['Subject'] = $subject;
  if ($is_body_html) {
    $headers ['Content-type'] = 'text/html';
  }
  
  // Send the email
  $result = $mailer->send($recipients, $headers, $body);
  
  // Check the result and throw an error if one exists
  if (PEAR::isError($result)) {
    throw new Exception('Error sending email: ' . htmlspecialchars($result->getMessage()));
  }
}
/**
 * Method accepts a email as an arguement and validates it agains parseAddressList
 *
 * @param mixed $email
 *          Email to validate and parse
 * @return boolean true if valid, false otherwise
 */
function valid_email($email) {
  $emailObjects = Mail_RFC822::parseAddressList($email);
  if (PEAR::isError($emailObjects)) {
    return false;
  }
  // Get the mailbox and host parts of the email object
  $mailbox = $emailObjects [0]->mailbox;
  $host = $emailObjects [0]->host;
  // Make sure the mailbox and host parts aren't too long
  if (strlen($mailbox) > 64) {
    return false;
  }
  if (strlen($host) > 255) {
    return false;
  }
  // Validate the mailbox
  $atom = '[[:alnum:]_!#$%&\'*+\/=?^`{|}~-]+';
  $dotatom = '(\.' . $atom . ')*';
  $address = '(^' . $atom . $dotatom . '$)';
  $char = '([^\\\\"])';
  $esc = '(\\\\[\\\\"])';
  $text = '(' . $char . '|' . $esc . ')+';
  $quoted = '(^"' . $text . '"$)';
  $localPart = '/' . $address . '|' . $quoted . '/';
  $localMatch = preg_match($localPart, $mailbox);
  if ($localMatch === false || $localMatch != 1) {
    return false;
  }
  // Validate the host
  $hostname = '([[:alnum:]]([-[:alnum:]]{0,62}[[:alnum:]])?)';
  $hostnames = '(' . $hostname . '(\.' . $hostname . ')*)';
  $top = '\.[[:alnum:]]{2,6}';
  $domainPart = '/^' . $hostnames . $top . '$/';
  $domainMatch = preg_match($domainPart, $host);
  if ($domainMatch === false || $domainMatch != 1) {
    return false;
  }
  return true;
}
function createRegisterEmailBody($userName, $userEmail) {
  $email = <<<EMAIL
<div style='font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;'>
<h1>
  <span style="font-weight:bold; letter-spacing:-.1em"><span style="color:#051DA8;">UWG</span>
  <span style="color:#57A9EB;">Marketplace</span></span>
</h1>
<p>Thanks, <strong>$userName</strong> for registering with UWG Marketplace, your one stop shop to sell you new and used items in a<br>
   safe, familiar, and friendly enviornment!
</p>
<p>Your registered values are:</p>
<ul>
<li>$userName</li>
<li>$userEmail</li>
</ul>
<p>Using UWG Marketplace is fairly easy and straight forward, however, if you are still lost you may refer to the help section<br>
   on the site for FAQs.
</p>
<p>Though no transactions will take place over the site we still take your security very seriously. Your data is insured to be sent<br>
   over a secure (https) connection. So surf the site rest-assured that you are safe and secure.
</p>
<p>If you have any questions you may contact the program admin, <a href="mailto:pdean@westga.edu">Patrick Dean</a>, for any concerns you may have.<p>
<p>Thanks again for using UWG Marketplace and have a terrific day!</p>
</div>
EMAIL;
  return $email;
}

/**
 * Creates an email for inquiring about a listing
 * 
 * @param string $pName
 *          Product Name
 * @param string $owner
 *          Name of the listing owner
 * @param string $body
 *          Body to be included in the message
 */
function createListingEmail($pName, $owner, $body) {
  $sessUserName = getUserFullName();
  $sessUserEmail = getUserEmail();
  $email = <<<EMAIL
<div style='font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;'>
<h1>
  <span style="font-weight:bold; letter-spacing:-.1em"><span style="color:#051DA8;">UWG</span>
  <span style="color:#57A9EB;">Marketplace</span></span>
</h1>
<p>Greetings, $owner, $sessUserName ($sessUserEmail) has inquired about your item '$pName'</p>
<p>--</p>
$body
<p>--</p>
<p>Thanks again for using UWG Marketplace and have a terrific day!</p>
</div>  
EMAIL;
  return $email;
}

// echo createRegisterEmailBody('Patrick Dean', 'patrickdean92@gmail.com');
// exit;
?>
<?php

include_once dirname(__FILE__)."/../../conf/config.inc.php";
include_once dirname(__FILE__)."/swift/lib/swift_required.php";
include_once dirname(__FILE__)."/swift/lib/SmtpApiHeader.php";

class Mail {
	
	static public function send($from, $fromName, $to, $subject, $html, $category=null){
		// Setup Swift mailer parameters
		$transport = Swift_SmtpTransport::newInstance('smtp.sendgrid.net', 25);
		$transport->setUsername(MAIL_USERNAME);
		$transport->setPassword(MAIL_PASSWORD);
		$swift = Swift_Mailer::newInstance($transport);
		
		$hdr = new SmtpApiHeader();
		if($category)
			$hdr->setCategory($category);
		 
		// Create a message (subject)
		$message = new Swift_Message($subject);
		// add SMTPAPI header to the message
		$headers = $message->getHeaders();
		$headers->addTextHeader('X-SMTPAPI', $hdr->asJSON());
		// attach the body of the email
		$message->setFrom(array($from => $fromName));
		$message->setBody($html, 'text/html');
		$message->setTo($to);
		if($text)
			$message->addPart($text, 'text/plain');
		 
		// send message 
		if ($recipients = $swift->send($message, $failures))
			return true;
		else
			return false;
	}
}

?>
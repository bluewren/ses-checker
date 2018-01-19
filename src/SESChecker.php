<?php

namespace Bluewren\SESChecker;

use Event;
use GuzzleHttp\Client;

class SESChecker implements \Swift_Events_SendListener {


	/**
	* Hook into the Sending event
	*/
	public function beforeSendPerformed(\Swift_Events_SendEvent $event)
	{
		// Retrieve the me
		$message = $event->getMessage();

		// If the message fails the API checks then abort sending
		if(!$this->checkIfCanSend($message)){
			$event->cancelBubble();
		}
	}

	public function sendPerformed(\Swift_Events_SendEvent $event)
	{
		//
	}

	/**
	*
	* Check if mail can be sent to the recipients
	* @param  Swift_Mime_Message $message
	* @return void
	*/
	protected function checkIfCanSend($message)
	{
		$canSend = false;
		$validToRecipients = [];
		$validCcRecipients = [];
		$validBccRecipients = [];
		$sender_email = key($message->getFrom());

		if($message->getTo()){
			// Check the To property
			foreach($message->getTo() as $to_recipient_email => $to_recipient_name) {
				if($this->performAPICheck($sender_email,$to_recipient_email)){
					array_push($validToRecipients, $to_recipient_email);
				}
			}
		}

		if($message->getCc()){
			// Check the CC property
			foreach($message->getCc() as $cc_recipient_email => $cc_recipient_name) {
				if($this->performAPICheck($sender_email,$cc_recipient_email)){
					array_push($validCcRecipients, $cc_recipient_email);
				}
			}
		}

		if($message->getBcc()){
			// Check the BCC property
			foreach($message->getBcc() as $bcc_recipient_email => $bcc_recipient_name) {
				if($this->performAPICheck($sender_email,$bcc_recipient_email)){
					array_push($validBccRecipients, $bcc_recipient_email);
				}
			}
		}

		// Set the valid To/Cc/Bcc recipients
		// Even if these are empty
		$message->setTo($validToRecipients);
		$message->setCc($validCcRecipients);
		$message->setBcc($validBccRecipients);

		// If there is at least one recipient (or you love her) let it go.
		return (count($message->getTo()) > 0 ||
		count($message->getCc()) > 0 ||
		count($message->getBcc()) > 0);
	}

	protected function performAPICheck($sender,$recipient)
	{
		$client = new Client([
			'base_uri' => config('ses-checker.api-url'),
			'headers' => [
				'Content-Type' => 'application/json',
				"token" => config('ses-checker.application-token')
			]
		]);

		$response = $client->request('POST', '/api', [
			'json' => [
				"recipient" => $recipient,
				"sender" =>  $sender
			]
		]);

		$data = json_decode($response->getBody());

		if($data){
			return $data->can_send;
		} else return false;
	}
}

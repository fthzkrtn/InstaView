<?php

namespace System\Core;

abstract class ClientAbstract extends \System\Core\ObjectAbstract {

	protected $client;

	public function setProxy( \System\Core\Client $client ) {
		$this->client = $client;
	}

}
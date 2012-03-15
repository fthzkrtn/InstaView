<?php

namespace System\Include;

class LocationStaff extends \System\Include\Collection {

	public function setData( $raw_data ) {
		$this->data = $raw_data->data;
		$this->convertData( '\Library\Location' );
	}

}
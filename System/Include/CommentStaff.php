<?php

namespace System\Include;

class CommentStaff extends \System\Include\Collection {

	public function setData( $raw_data ) {
		$this->data = $raw_data->data;
		$this->convertData( '\Library\Comment' );
	}

}
<?php

namespace System\Include;

class MediaStaff extends \System\Include\Collection {

	public function setData( $raw_data ) {
		$this->data = $raw_data->data;
		$this->pagination = isset( $raw_data->pagination ) ? $raw_data->pagination : null;
		$this->convertData( '\Library\Media' );
	}

	public function getNextMaxId() {
		return isset( $this->pagination->next_max_id ) ? $this->pagination->next_max_id : null;
	}

	public function getNextUrl() {
		return isset( $this->pagination->next_url ) ? $this->pagination->next_url : null;
	}

	public function getNext() {
		return $this->getNextMaxId();
	}

}
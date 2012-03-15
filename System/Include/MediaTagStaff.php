<?php

namespace System\Include;

class MediaTagStaff extends \System\Include\MediaStaff {

	public function getNextMaxTagId() {
		return isset( $this->pagination->next_max_tag_id ) ? $this->pagination->next_max_tag_id : null;
	}

	public function getNext() {
		return $this->getNextMaxTagId();
	}

}
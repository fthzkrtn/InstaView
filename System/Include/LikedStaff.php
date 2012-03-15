<?php

namespace System\Include;

class LikedStaff extends \System\Collection\MediaStaff {

	public function getNextMaxLikeId() {
		return isset( $this->pagination->next_max_like_id ) ? $this->pagination->next_max_like_id : null;
	}

	public function getNext() {
		return $this->getNextMaxLikeId();
	}

}
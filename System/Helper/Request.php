<?php

namespace System\Helper;

class Request {

	protected $request;

	function __construct( $raw_request ){
		$this->response = json_decode( $raw_request );
		if ( !$this->isValidApiRequest() ) {
			$this->request = new \StdClass;
			$this->request->meta = new \StdClass;
			$this->request->meta->error_type = 'InvalidAPIUrlError';
			$this->request->meta->code = 444;
			$this->request->meta->error_message = 'invalid api url';
		}
	}

	function isValid() {
		return $this->request instanceof \StdClass && !isset( $this->request->meta->error_type ) && !isset( $this->request->error_type );
	}

	public function getData() {
		return isset( $this->request->data ) ? $this->request->data : null;
	}

	public function getRawData() {
		return isset( $this->request ) ? $this->request : null;
	}

	public function isValidApiRequest() {
		return $this->request instanceof \StdClass;
	}

	public function getErrorMessage() {
		if ( isset( $this->request->error_message ) ) {
			return $this->request->error_message;
		}
		elseif( isset( $this->request->meta->error_message ) ) {
			return $this->request->meta->error_message;
		}
		else {
			return null;
		}
	}

	public function getErrorCode() {
		if ( isset( $this->request->code ) ) {
			return $this->request->code;
		}
		elseif( isset( $this->request->meta->code ) ) {
			return $this->request->meta->code;
		}
		else {
			return null;
		}
	}

	public function getErrorType() {
		if ( isset( $this->request->error_type ) ) {
			return $this->request->error_type;
		}
		elseif( isset( $this->request->meta->error_type ) ) {
			return $this->request->meta->error_type;
		}
		else {
			return null;
		}
	}

	public function __toString() {
		return json_encode( $this->request );
	}

}
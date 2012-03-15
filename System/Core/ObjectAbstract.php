<?php

namespace System\Core;

abstract class ObjectAbstract {

	protected $data;

	public function __construct( $data ) { $this->setData( $data ); }
	public function getId() { return $this->data->id; }
	public function getApiId() { return $this->getId(); }
	public function setData( $data ) { $this->data = $data; }
	public function getData() { return $this->data; }

}
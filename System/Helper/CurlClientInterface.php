<?php

namespace System\Helper;

interface CurlClientInterface {

	function get( $url, array $data = null );
	function post( $url, array $data = null );
	function put( $url, array $data = null );
	function delete( $url, array $data = null );

}
<?php

/**
* InstaView
*
* A PHP framework for accessing Instagram API.
*
*
* InstaView is a small PHP library to access Instagram API. 
* It's main goal was to be easy to use, lightweight and have as few dependencies as possible.
*
*
* @author Melih buyuk <melihbuyuk@gmail.com>
* @copyright 2012, melih buyukbayram
* @license http://www.codecanyon.net
* @package helper
*/

namespace System\Helper;

class Curl implements CurlClientInterface {
	
	protected $curl = null;
	
	/**
	 * Constructor Method
	 *
	 * @access public
	 */
	function __construct(){
		$this->initializeCurl();
	}

	function reset() {}


	/**
	 * Curl Get data
	 *
	 * @param $url array $data Configuration array
	 * @return $this->fetch();
	 * @access public
	 */
	function get( $url, array $data = null ){
		curl_setopt( $this->curl, CURLOPT_CUSTOMREQUEST, 'GET' );
		curl_setopt( $this->curl, CURLOPT_URL, sprintf( "%s?%s", $url, http_build_query( $data ) ) );
		return $this->fetch();
	}
	
	/**
	 * Curl Post data
	 *
	 * @param $url array $data Configuration array
	 * @return $this->fetch();
	 * @access public
	 */
	function post( $url, array $data = null ) {
		curl_setopt( $this->curl, CURLOPT_CUSTOMREQUEST, 'POST' );
		curl_setopt( $this->curl, CURLOPT_URL, $url );
		curl_setopt( $this->curl, CURLOPT_POSTFIELDS, http_build_query( $data ) );
		return $this->fetch();
	}
	
	/**
	 * Curl Put data
	 *
	 * @param $url array $data Configuration array
	 * @access public
	 */
	function put( $url, array $data = null  ){
		curl_setopt( $this->curl, CURLOPT_CUSTOMREQUEST, 'PUT' );
	}

	/**
	 * Curl Delete data
	 *
	 * @param $url array $data Configuration array
	 * @return $this->fetch();
	 * @access public
	 */
	function delete( $url, array $data = null  ){
		$this->reset();
		curl_setopt( $this->curl, CURLOPT_URL, sprintf( "%s?%s", $url, http_build_query( $data ) ) );
		curl_setopt( $this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE' );
		return $this->fetch();
	}
	
	/**
	 * Curl Installiation data
	 *
	 * @param $url array $data Configuration array
	 * @access public
	 */
	function initializeCurl() {
		$this->curl = curl_init();
		curl_setopt( $this->curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $this->curl, CURLOPT_SSL_VERIFYPEER, false );
	}
	
	/**
	 * Curl Fetch data
	 *
	 * @return \Instagram\Helper\Request
	 * @access public
	 */
	function fetch() {
		$raw_request = curl_exec( $this->curl );
		$error = curl_error( $this->curl );
		if ( $error ) {
			throw new \System\Exception\ApiException( curl_error( $this->curl ), 666, 'CurlError' );
		}
		return new \System\Helper\Request( $raw_request );
	}
	
}
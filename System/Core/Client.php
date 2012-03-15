<?php

namespace System\Core;

class Client {

	protected $client;
	protected $access_token;

	protected $api_url = 'https://api.instagram.com/v1';

	function __construct( \System\Helper\CurlClientInterface $client, $access_token = null ) {
		$this->client = $client;
		$this->access_token = $access_token;
	}

	public function getAccessToken( array $data ) {
		$request = $this->apiCall( 'post', 'https://api.instagram.com/oauth/access_token', $data );
		return $request;
	}

	private function getObjectMedia( $api_endpoint, $id, array $params = null ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/%s/%s/media/recent', $this->api_url, strtolower( $api_endpoint ), $id  ),
			$params
		);
		return $request->getRawData();
	}

	public function getLocationMedia( $id, array $params = null ) {
		return $this->getObjectMedia( 'Locations', $id, $params );
	}

	public function getTagMedia( $id, array $params = null ) {
		return $this->getObjectMedia( 'Tags', $id, $params );
	}

	public function getUserMedia( $id, array $params = null ) {
		return $this->getObjectMedia( 'Users', $id, $params );
	}

	public function getUser( $id ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/users/%s', $this->api_url, $id )
		);
		return $request->getData();
	}

	public function getUserFollows( $id, array $params = null ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/users/%s/follows', $this->api_url, $id ),
			$params
		);
		return $request->getRawData();
	}

	public function getUserFollowers( $id, array $params = null ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/users/%s/followed-by', $this->api_url, $id ),
			$params
		);
		return $request->getRawData();
	}

	public function getMediaComments( $id ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/media/%s/comments', $this->api_url, $id )
		);
		return $request->getRawData();
	}

	public function getMediaLikes( $id ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/media/%s/likes', $this->api_url, $id )
		);
		return $request->getRawData();
	}

	public function getCurrentUser() {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/users/self', $this->api_url )
		);
		return $request->getData();
	}

	public function getMedia( $id ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/media/%s', $this->api_url, $id )
		);
		return $request->getData();
	}

	public function getTag( $tag ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/tags/%s', $this->api_url, $tag )
		);
		return $request->getData();
	}

	public function getLocation( $id ) {
		$request = $this->apiCall(
			'get',
			sprintf( '%s/locations/%s', $this->api_url, $id )
		);
		return $request->getData();
	}

	public function searchUsers( array $params = null ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . '/users/search',
			$params
		);
		return $request->getRawData();
	}

	public function searchTags( array $params = null ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . '/tags/search',
			$params
		);
		return $request->getRawData();
	}

	public function searchMedia( array $params = null ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . '/media/search',
			$params
		);
		return $request->getRawData();
	}

	public function searchLocations( array $params = null ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . '/locations/search',
			$params
		);
		return $request->getRawData();
	}

	public function getPopularMedia( array $params = null ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . '/media/popular',
			$params
		);
		return $request->getRawData();
	}

	public function getFeed( array $params = null ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . '/users/self/feed',
			$params
		);
		return $request->getRawData();
	}

	public function getFollowRequests( array $params = null ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . '/users/self/requested-by',
			$params
		);
		return $request->getRawData();
	}

	public function getLikedMedia( array $params = null ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . '/users/self/media/liked',
			$params
		);
		return $request->getRawData();
	}

	public function getRelationshipToCurrentUser( $user_id ) {
		$request = $this->apiCall(
			'get',
			$this->api_url . sprintf( '/users/%s/relationship', $user_id )
		);
		return $request->getData();
	}

	public function modifyRelationship( $user_id, $relationship ) {
		$request = $this->apiCall(
			'post',
			$this->api_url . sprintf( '/users/%s/relationship', $user_id ),
			array( 'action'	=> $relationship )
		);
		return $request->getData();
	}

	public function like( $media_id ) {
		$this->apiCall(
			'post',
			$this->api_url . sprintf( '/media/%s/likes', $media_id )
		);
	}

	public function unLike( $media_id ) {
		$this->apiCall(
			'delete',
			$this->api_url . sprintf( '/media/%s/likes', $media_id )
		);
	}

	public function addMediaComment( $media_id, $text ) {
		$this->apiCall(
			'post',
			$this->api_url . sprintf( '/media/%s/comments', $media_id ),
			array( 'text' => $text )
		);
	}

	public function deleteMediaComment( $media_id, $comment_id ) {
		$this->apiCall(
			'delete',
			$this->api_url . sprintf( '/media/%s/comments/%s', $media_id, $comment_id )
		);
	}

	private function apiCall( $method, $url, array $params = null, $throw_exception = true ){
		$request = $this->client->$method(
			$url,
			array(
				'access_token'	=> $this->access_token
			) + (array) $params
		);
		if ( !$request->isValid() ) {
			if ( $throw_exception ) {
				if ( $request->getErrorType() == 'OAuthAccessTokenException' ) {
					throw new \System\Exception\ApiAuthException( $request->getErrorMessage(), $request->getErrorCode(), $request->getErrorType() );
				}
				else {
					throw new \System\Exception\ApiException( $request->getErrorMessage(), $request->getErrorCode(), $request->getErrorType() );
				}
			}
			else {
				return false;
			}
		}
		return $request;
	}


}
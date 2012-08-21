<?php

require_once('OAuth.php');


class OverBlogException extends Exception {}


/*
 * Class OverBlogBase defines a raw access to the OverBlog API.
 *
 * If you do not need a specific behavior, you will probably
 * be happier to play with the methods provided by the OverBlog
 * class (see later in this file).
 *
 */

abstract class OverBlogBase
{
	const OB_SDK_USER_AGENT					= 'OverBlog PHP SDK client 0.1';

	const OB_API_SERVER						= 'http://developer.over-blog-staging.com/';

	const OB_API_ENDPOINT_REQUEST_TOKEN 	= '/oauth/request_token';
	const OB_API_ENDPOINT_ACCESS_TOKEN 		= '/oauth/access_token';

	const OB_API_BASE_URL 					= '/public/0.1/';

	const OB_API_AUTHENTICATION_NONE		= 'none';
	const OB_API_AUTHENTICATION_KEY			= 'key';
	const OB_API_AUTHENTICATION_OAUTH		= 'oauth';

	const OB_API_STATUS_DRAFT				= 1;
	const OB_API_STATUS_PUBLISHED			= 2;
	const OB_API_STATUS_SUBMITTED			= 3;

	const OB_API_CONTENTFORMAT_NONE			= 0;
	const OB_API_CONTENTFORMAT_HTML			= 1;
	const OB_API_CONTENTFORMAT_RAWJSON		= 2;

	const OB_API_RICHTEXTFORMAT_RAW			= 0;
	const OB_API_RICHTEXTFORMAT_HTML		= 1;


	/*
	 * Definition of all API methods
	 *
	 * array with key = method name
	 *       and value = method definition
	 *
	 * method definition is an array with
	 *  - mparams : array of mandatory params
	 *  - oparams : array of optional params
	 *  - method : HTTP method to use when calling the API
	 *  - url : the relative URL (see constant OB_API_BASE_URL)
	 *          of the method to call on the API server
	 *  - authentication : whether to use no authentication, or
	 *          an api key, or a full OAuth 1.0a challenge
	 */

	protected static $_api = array (

		// BLOG
		'getBlogInfo' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/info',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'updateBlogInfo' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'name',
				'description',
				'avatar',
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/update',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getSocialNetworksForPush' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/push_networks',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'uploadImage' => array (
			'mparams'			=> array (
				'blog_hostname',
				'file',
			),
			'method'			=> 'PUT',
			'url'				=> '/blog/%blog_hostname/image/upload',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

        'uploadVideo' => array (
            'mparams'			=> array (
                'blog_hostname',
                'file',
            ),
            'method'			=> 'PUT',
            'url'				=> '/blog/%blog_hostname/video/upload',
            'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
        ),

		// POSTS

		'getPost' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'oparams'			=> array (
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/post/%id/get',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'editPost' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'oparams'			=> array (
				'sections',
				'status',
				'tags',
				'social',
				'date',
				'title',
				'author',
				'cover',
				'richTextFormat',
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/post/%id/edit',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'deletePost' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/post/%id/delete',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getPublishedPosts' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'offset',
				'limit',
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/posts',
			'authentication'	=> self::OB_API_AUTHENTICATION_KEY,
		),

		'getDraftPosts' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'offset',
				'limit',
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/posts/drafts',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getPendingPosts' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'offset',
				'limit',
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/posts/pending',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getSubmittedPosts' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'offset',
				'limit',
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/posts/submitted',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'createPost' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'title',
				'sections',
				'status',
				'tags',
				'social',
				'date',
				'author',
				'cover',
				'richTextFormat',
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/post/create',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		// PAGES

		'getPage' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'oparams'			=> array (
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/page/%id/get',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'editPage' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'oparams'			=> array (
				'sections',
				'status',
				'tags',
				'title',
				'author',
				'cover',
				'richTextFormat',
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/page/%id/edit',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'deletePage' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/page/%id/delete',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getPublishedPages' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'offset',
				'limit',
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/pages',
			'authentication'	=> self::OB_API_AUTHENTICATION_KEY,
		),

		'getDraftPages' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'offset',
				'limit',
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/pages/drafts',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getPendingPages' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'offset',
				'limit',
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/pages/pending',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getSubmittedPages' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'offset',
				'limit',
				'contentFormat',
				'richTextFormat',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/pages/submitted',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'createPage' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'title',
				'sections',
				'status',
				'tags',
				'author',
				'cover',
				'richTextFormat',
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/page/create',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		// USER

		'createBlog' => array (
			// not implemented
		),

		'getUserInfo' => array (
			'method'			=> 'GET',
			'url'				=> '/user/info',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'updateUserInfo' => array (
			'oparams'			=> array (
				'nickname',
				'bio',
				'string',
				'avatar',
			),
			'method'			=> 'POST',
			'url'				=> '/user/edit',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getUserBlogs' => array (
			'method'			=> 'GET',
			'url'				=> '/user/blogs',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'retrieveUserPassword' => array (
			'mparams'			=> array (
				'email',
			),
			'method'			=> 'POST',
			'url'				=> '/user/recover/password',
			'authentication'	=> self::OB_API_AUTHENTICATION_KEY,
		),

		// COMMENTS

		'getBlogComments' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'state',
				'limit',
				'offset',
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/comments',
			'authentication'	=> self::OB_API_AUTHENTICATION_KEY,
		),

		'getPostComments' => array (
			'mparams'			=> array (
				'id_post',
			),
			'oparams'			=> array (
				'limit',
				'offset',
			),
			'method'			=> 'GET',
			'url'				=> '/post/%id_post/comments',
			'authentication'	=> self::OB_API_AUTHENTICATION_KEY,
		),

		'deleteComment' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'oparams'			=> array (
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/comment/delete',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'approveComment' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'oparams'			=> array (
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/comment/approve',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'unapproveComment' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'oparams'			=> array (
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/comment/unapprove',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'markCommentAsSpam' => array (
			'mparams'			=> array (
				'blog_hostname',
				'id',
			),
			'oparams'			=> array (
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/comment/markasspam',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'createComment' => array (
			'mparams'			=> array (
				'id_post',
				'text',
			),
			'oparams'			=> array (
			),
			'method'			=> 'POST',
			'url'				=> '/post/%id_post/comment/create',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'replyToComment' => array (
			'mparams'			=> array (
				'id_comment',
				'text',
			),
			'oparams'			=> array (
			),
			'method'			=> 'POST',
			'url'				=> '/comment/%id_comment/reply/create',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		// STATS
		'getStats' => array (
			'mparams'			=> array (
				'blog_hostname',
				'start',
				'end',
			),
			'oparams'			=> array (
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/stats/get',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getMostPopularPagesStats' => array (
			'mparams'			=> array (
				'blog_hostname',
				'month',
			),
			'oparams'			=> array (
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/stats/most_popular_pages',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		'getTotalStats' => array (
			'mparams'			=> array (
				'blog_hostname',
				'start',
				'end',
			),
			'oparams'			=> array (
			),
			'method'			=> 'GET',
			'url'				=> '/blog/%blog_hostname/stats/total',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),


		// REVENUES - not implemented


		// LIVESTREAM

		'createLiveStreamPost' => array (
			'mparams'			=> array (
				'blog_hostname',
			),
			'oparams'			=> array (
				'title',
				'author',
				'tags',
				'desc',
				'social',
			),
			'method'			=> 'POST',
			'url'				=> '/blog/%blog_hostname/livestream/create',
			'authentication'	=> self::OB_API_AUTHENTICATION_OAUTH,
		),

		// SEARCH - not implemented
	);

	/*
	 * a OAuthConsumer objet holding the key/secret values
	 */
	protected $_consumerKeySecretPair;

	/*
	 * a OAuthToken objet holding the token/secret values
	 * may be null before obtained from the server
	 */
	protected $_accessTokenSecretPair;

	/*
	 * a OAuthSignatureMethod objet representing
	 * the signature method used in OAuth protocol
	 */
	protected $_signature_method;



	/**
	* Init the class
	* @param $params array()
	*
	* Mandatory params:
	* - string consumerKey
	* - string consumerSecret
	*
	* Can be provided
	* - string accessToken
	* - string accessSecret
*/
	function __construct( $params = array() )
	{
		//--------------------------------------------------------------------------
		// Check format
		//--------------------------------------------------------------------------
		if (!is_array($params))
		{
			throw new OverBlogException(
				'OverBlog::__construct() : ' .
				'first parameter must be an array.');
		}

		//--------------------------------------------------------------------------
		// Mandatory params
		//--------------------------------------------------------------------------
		if (!isset($params['consumerKey']) ||
		    !isset($params['consumerSecret']))
		{
			throw new OverBlogException(
				'OverBlog::__construct() : ' .
				'consumerKey & consumerSecret parameterss are mandatory');
		}

		$this->_consumerKeySecretPair = new OAuthConsumer (
			$params['consumerKey'],
			$params['consumerSecret']
		);

		//--------------------------------------------------------------------------
		// Other params
		//--------------------------------------------------------------------------
		if (isset($params['accessToken']) &&
			isset($params['accessSecret']))
		{
			$this->_accessTokenSecretPair = new OAuthToken (
				$params['accessToken'],
				$params['accessSecret']
			);
		}
		else
		{
			$this->_accessTokenSecretPair = null;
		}

		//--------------------------------------------------------------------------
		// HMAC-SHA1 is the only signature used with OverBlog API
		//--------------------------------------------------------------------------
		$this->_signature_method = new OAuthSignatureMethod_HMAC_SHA1();
	}


	/**
	 * setAccessTokenAndSecret
	 *
	 * @param string $token a user access token
	 * @param string $secret a user access token secret
	 *
	 * Use this method when you have constructed the object
	 * with no access token and want to add it afterwards
	 */
	public function setAccessTokenAndSecret ($token, $secret)
	{
		$this->_accessTokenSecretPair = new OAuthToken (
			$token,
			$secret
		);
	}

	/**
	 * getRequestTokenAndAuthorizeUrl
	 *
	 * @param string $callbackUrl the callback url to redirect to
	 *                 when the request token has been authorized
	 *
	 * @return array array made of the request token, the verifier and
	 *                 the authorization URL to redirect to
	 *
	 * Use this method when you want to obtain an access token for the
	 * first time and when you want to renew an access token
	 */

	public function getRequestTokenAndAuthorizeUrl ($callbackUrl = null)
	{
		//--------------------------------------------------------------------------
		// Check format
		//--------------------------------------------------------------------------
		if (!$callbackUrl)
		{
			throw new OverBlogException(
				'OverBlog::getRequestToken() : ' .
				'callback url not provided.');
		}

		//--------------------------------------------------------------------------
		// Build request token request
		//--------------------------------------------------------------------------
		$reqToken = OAuthRequest::from_consumer_and_token(
			$this->_consumerKeySecretPair,
			null,
			'GET',
			rtrim(self::OB_API_SERVER, '/') .
				'/' .
				ltrim(self::OB_API_ENDPOINT_REQUEST_TOKEN, '/'),
			array (
				'oauth_callback' => $callbackUrl
			)
		);

		$reqToken->sign_request(
			$this->_signature_method,
			$this->_consumerKeySecretPair,
			null
		);

		//--------------------------------------------------------------------------
		// Execute request and retrieve authorize url
		//--------------------------------------------------------------------------
		$reqTokenResults = @file_get_contents($reqToken->to_url());

		if (!$reqTokenResults)
		{
			throw new OverBlogException(
				'OverBlog::getRequestToken() : ' .
				'error while requesting request token.');
		}

		parse_str($reqTokenResults, $reqTokenResults);

		return $reqTokenResults;
	}

	/**
	 * getAccessTokenFromRequestTokenAndVerifier
	 *
	 * @param string $token the request token obtained at previous step
	 * @param string $secret the request token secret obtained at previous step
	 * @param string $verifier the verifier provided by the API server as a
	 *                 parameter of the callback URL
	 *
	 * @return array array made of the access token, the access token secret
	 *                 and the user id
	 *
	 * Use this method when you want to exchange a request token with an
	 * access token, just after the authorization of the request token
	 */

	public function getAccessTokenFromRequestTokenAndVerifier ($token, $secret, $verifier)
	{
		$reqToken = new OAuthToken (
			$token,
			$secret
		);

		$accToken = OAuthRequest::from_consumer_and_token(
			$this->_consumerKeySecretPair,
			$reqToken,
			'GET',
			rtrim(self::OB_API_SERVER, '/') .
				'/' .
				ltrim(self::OB_API_ENDPOINT_ACCESS_TOKEN, '/'),
			array (
				'oauth_token' 		=> $token,
				'oauth_verifier'	=> $verifier,
			)
		);

		$accToken->sign_request(
			$this->_signature_method,
			$this->_consumerKeySecretPair,
			$reqToken
		);

		//--------------------------------------------------------------------------
		// Execute request and retrieve access token
		//--------------------------------------------------------------------------
		$accTokenResults = @file_get_contents($accToken->to_url());

		if (!$accTokenResults)
		{
			throw new OverBlogException(
				'OverBlog::getAccessTokenFromOAuthTokenAndVerifier() : ' .
				'error while requesting access token.');
		}

		parse_str($accTokenResults, $accTokenResults);

		return $accTokenResults;
	}

	/**
	* Generic method to call the OverBlog API Methods
	*
	* The behavior of this method is base on the protected $_api array
	* defined in this class.
	*/
	public function __call($name, $args)
	{
		//--------------------------------------------------------------------------
		// Check that the method called is fully registered in API
		//--------------------------------------------------------------------------
		if (!isset(self::$_api[$name]))
		{
			throw new OverBlogException(
				'OverBlog::__call() : ' .
				'"'.$name.'" is not registered as an API function');
		}

		if (!is_array(self::$_api[$name]) || !count(self::$_api[$name]))
		{
			throw new OverBlogException(
				'OverBlog::'.$name.'() : ' .
				'not implemented yet.');
		}

		//--------------------------------------------------------------------------
		// Check that the definition of the method is complete
		//--------------------------------------------------------------------------
		if (!isset(self::$_api[$name]['url']))
		{
			throw new OverBlogException(
				'OverBlog::'.$name.'() : ' .
				'param "url" is not provided in the API definition');
		}

		if (!isset(self::$_api[$name]['method']))
		{
			throw new OverBlogException(
				'OverBlog::'.$name.'() : ' .
				'param "method" is not provided in the API definition');
		}

		if (!isset(self::$_api[$name]['authentication']))
		{
			throw new OverBlogException(
				'OverBlog::'.$name.'() : ' .
				'param "authentication" is not provided in the API definition');
		}

		if ((self::$_api[$name]['authentication'] == self::OB_API_AUTHENTICATION_OAUTH) &&
		    ($this->_accessTokenSecretPair == null))
		{
			throw new OverBlogException(
				'OverBlog::'.$name.'() : ' .
				'OAuth authentication is used, but access token is not set.');
		}


		//--------------------------------------------------------------------------
		// Check that all the mandatory params have been populated
		//--------------------------------------------------------------------------
		$params = isset($args[0]) ? $args[0] : array();

		if (!isset(self::$_api[$name]['mparams']))
		{
			self::$_api[$name]['mparams'] = array();
		}

		foreach (self::$_api[$name]['mparams'] as $mparam)
		{
			if (!isset($params[$mparam]))
			{
				throw new OverBlogException(
					'OverBlog::'.$name.'() : ' .
					'missing mandatory param "'.$mparam.'"');
			}
		}

		//--------------------------------------------------------------------------
		// Drop all params that are not listed as mandatory or optional
		// and convert objects to JSON strings
		//--------------------------------------------------------------------------
		if (!isset(self::$_api[$name]['oparams']))
		{
			self::$_api[$name]['oparams'] = array();
		}

		foreach ($params as $param=>$value)
		{
			if ((!in_array($param, self::$_api[$name]['mparams'])) &&
			    (!in_array($param, self::$_api[$name]['oparams'])))
			{
				throw new OverBlogException(
					'OverBlog::'.$name.'() : ' .
					'param "'.$param.'" is not allowed');
			}
			else
			{
				if (!is_string($value))
				{
					$params[$param] = json_encode($value);
				}
			}
		}

		//--------------------------------------------------------------------------
		// Ok let's prepare the URL we gonna hit
		//--------------------------------------------------------------------------

		$url = rtrim(self::OB_API_SERVER, '/') .
			'/' .
			trim(self::OB_API_BASE_URL, '/') .
			'/' .
			ltrim(self::$_api[$name]['url'], '/');

		// Replace parameters in URL
		foreach ($params as $param => $value)
		{
			if (strpos($url, '%'.$param) !== false)
			{
				$url = str_replace('%'.$param, urlencode($value), $url, $replaced);
				unset($params[$param]);
			}
		}

		// For GET requests, append remaining params to the URL
		if (self::$_api[$name]['method'] == 'GET' && count($params))
		{
			if (strpos($url, '?') !== false)
			{
				$url .= '&';
			}
			else
			{
				$url .= '?';
			}

			$url .= http_build_query($params);
		}

		// For POST requests, set POST data with the remaining params
		if (self::$_api[$name]['method'] == 'POST')
		{
			$postData = $params;
		}

		// For PUT requests, only consider a 'file' param
		// This parameter must be a file path
		if (self::$_api[$name]['method'] == 'PUT')
		{
			$putData = '';
			if (isset($params['file']))
			{
				$putData = base64_encode(
					file_get_contents(
						$params['file']
					)
				);

				unset($params['file']);
			}
		}

		//--------------------------------------------------------------------------
		// Add authentication data to URL
		//--------------------------------------------------------------------------
		if (self::$_api[$name]['authentication'] == self::OB_API_AUTHENTICATION_OAUTH)
		{
			$request = OAuthRequest::from_consumer_and_token(
				$this->_consumerKeySecretPair,
				$this->_accessTokenSecretPair,
				self::$_api[$name]['method'],
				$url,
				$params
			);

			$request->sign_request(
				$this->_signature_method,
				$this->_consumerKeySecretPair,
				$this->_accessTokenSecretPair
			);

			if (self::$_api[$name]['method'] == 'POST')
			{
				$postData = $request->to_postdata();
			}
			else
			{
				$url = $request->to_url();
			}
		}

		if (self::$_api[$name]['authentication'] == self::OB_API_AUTHENTICATION_KEY)
		{
			if (strpos($url, '?') !== false)
			{
				$url .= '&';
			}
			else
			{
				$url .= '?';
			}

			$url .= 'api_key=' . $this->_consumerKeySecretPair->key;
		}

		//--------------------------------------------------------------------------
		// Execute query
		//--------------------------------------------------------------------------
		$ch = curl_init($url);

		curl_setopt($ch, CURLOPT_USERAGENT, self::OB_SDK_USER_AGENT);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);

		switch (self::$_api[$name]['method'])
		{
			case 'GET' :
				curl_setopt($ch, CURLOPT_HTTPGET, true);
				break;

			case 'POST' :
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
				break;

			case 'PUT' :
				$fp = fopen('php://temp', 'w');
				fwrite($fp, $putData);
				fseek($fp, 0);

				curl_setopt($ch, CURLOPT_PUT, true);
				curl_setopt($ch, CURLOPT_INFILE, $fp);
				curl_setopt($ch, CURLOPT_INFILESIZE, strlen($putData));
				curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-type: application/octet-stream'));

				fclose($fp);
				break;

			case 'DELETE' :
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
		}

		$curlOut = curl_exec($ch);

		if (!$curlOut)
		{
			return false;
		}

		curl_close($ch);

		$json = json_decode($curlOut);

		if ($json)
		{
			return $json;
		}

		return false;
	}

}














/*
 * Class OverBlog inherits from OverBlogBase
 *
 * This class defines functional usages of the raw API methods
 * and provides simpler methods signatures for a quicker implementation.
 *
 * If you need specific behaviors, that are not offered by this class
 * you should have a look at all the raw methods offered by the parent class,
 * all API methods are available there.
 *
 */


class OverBlog extends OverBlogBase
{

}


 
<?php
/**
* FacebookAuthenticate handler that works with AuthComponent
*
* By default, uses a User model and requires that the database table has added
* email, name, facebook_user_id, & facebook_access_token fields. See README for detailed
* installation and usage instructions
*
* @author Moz Morris <moz@earthview.co.uk>
* @link http://www.earthview.co.uk
* @copyright (c) 2011 Moz Morris
* @license MIT License - http://www.opensource.org/licenses/mit-license.php
 */

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

/**
 * Facebook Authentication class
 *
 * @package FacebookAuth.Controller.Component.Auth.FacebookAuthenticate
 */
class FacebookAuthenticate extends BaseAuthenticate {

  /**
   * Settings for this object.
   *
   * @var array
   */
  public $settings = array(
    'application' => array(
      'id'     => null,
      'secret' => null
    ),
    'fields' => array(
      'id'                    => 'id',
      'email'                 => 'email',
      'name'                  => 'name',
      'password'              => 'password',
      'facebook_user_id'      => 'facebook_user_id',
      'facebook_username'     => 'facebook_username',
      'facebook_access_token' => 'facebook_access_token',
      'facebook_token_expires'=> 'facebook_token_expires'
    ),
    'scope' => array(),
    'urls' => array(
      'api'          => 'https://graph.facebook.com',
      'access_token' => '/oauth/access_token',
      'user'         => '/me'
    ),
    'userModel' => 'User'
  );

  /**
   * A Component collection, used to get more components.
   *
   * @var ComponentCollection
   */
  protected $_Collection;

  /**
   * request object
   *
   * @var CakeRequest
   */
  protected $_Request;

  /**
   * result object
   *
   * @var CakeResponse
   */
  protected $_Reponse;

  /**
   * Constructor
   *
   * @param ComponentCollection $collection The Component collection used on this request.
   * @param array $settings Array of settings to use.
   */
  public function __construct(ComponentCollection $collection, $settings) {
    $this->_Collection = $collection;
    $this->_Request = $this->_Collection->getController()->request;
    $this->_Response = $this->_Collection->getController()->response;
    $this->settings = Set::merge($this->settings, $settings);

    if (empty($this->settings['application']['id'])) {
      throw new InternalErrorException(__('Facebook application ID not configured.'));
    }

    if (empty($this->settings['application']['secret'])) {
      throw new InternalErrorException(__('Facebook application secret not configured.'));
    }
  }

  /**
   * Authenticate a user based on the request information.
   *
   * @param CakeRequest $request Request to get authentication information from.
   * @param CakeResponse $response A response object that can have headers added.
   * @return mixed Either false on failure, or an array of user data on success.
   */
  public function authenticate(CakeRequest $request, CakeResponse $response) {
    /**
     * Check if the Facebook response code is present in the request
     */
    if ((!empty($this->_Request->query['code']) && !empty($this->_Request->query['state']))
      && (CakeSession::read('FacebookAuthCSRF') == $this->_Request->query['state'])) {

      /**
       * Create a token request url from the settings and the returned 'code'
       */
      $tokenRequest = $this->settings['urls']['api']
                      . $this->settings['urls']['access_token']
                      . "?client_id=" . $this->settings['application']['id']
                      . "&redirect_uri=" . urlencode(Router::url(false, true))
                      . "&client_secret=" . $this->settings['application']['secret']
                      . "&code=" . $this->_Request->query['code'];

      /**
       * Call to Facebook to get access token
       */
      if (($response = $this->_connect($tokenRequest)) !== false) {
        parse_str($response, $response);
      }

      /**
       * Something went wrong! todo
       */
      if (empty($response['access_token'])) {
        return false;
      }

      /**
       * Find, (update|create), & return the user
       */
      return $this->_findUser($response);

    } elseif (!empty($this->_Request->query['error_reason'])) {
      /*
        TODO Handle Don't Allow
      */
    }

    /**
     * CSRF value - used when a 'code' is returned from Facebook
     */
    if (!CakeSession::check('FacebookAuthCSRF')) {
    	CakeSession::write('FacebookAuthCSRF', md5(uniqid(rand(), TRUE)));
    }
    
    return false;
  }

  /**
   * Find a user record using the standard options.
   *
   * @param string $tokenData Facebook Access token and expires
   * @return Mixed Either false on failure, or an array of user data.
   */
  protected function _findUser($tokenData, $pass = null) {
  	
  	$tokenData['expires'] = date('Y-m-d H:i:s', time() + $tokenData['expires']);

    $userRequest =  $this->settings['urls']['api']
                    . $this->settings['urls']['user']
                    . "?access_token="
                    . $tokenData['access_token'];
    /**
     * Make request to Facebook
     */
    $response = $this->_connect($userRequest);

    if (!$response) {
      return false;
    }

    $user = json_decode($response, true);

    /**
     * Check that the user exists
     * A user's details are updated if they exist
     * else they are created
     */
    if (($existingUser = $this->_checkUser($user)) !== false) {
      return $this->_updateUser($existingUser, $user, $tokenData);
    } else {
      return $this->_createUser($user, $tokenData);
    }
  }

  /**
   * Check to see if the user exists
   *
   * @param array $user
   * @return Mixed Either false on failure, or an array of user data.
   */
  protected function _checkUser($user)
  {
    /**
     * Some of this is lifted from BaseAuthenticate
     */
    $userModel = $this->settings['userModel'];
    list($plugin, $model) = pluginSplit($userModel);
    $fields = $this->settings['fields'];

    /**
     * We use the OR clause. This ensures we return a User who may already
     * exist in the database but has not previously authenticated with Facebook.
     */
    $conditions = array(
      'OR' => array(
        array($model . '.' . $fields['facebook_user_id'] => $user['id']),
        array($model . '.' . $fields['email'] => $user['email']),
      )
    );

    if (!empty($this->settings['scope'])) {
      $conditions = array_merge($conditions, $this->settings['scope']);
    }

    $result = ClassRegistry::init($userModel)->find('first', array(
      'conditions' => $conditions,
      'recursive' => 0
    ));

    if (empty($result) || empty($result[$model])) {
      return false;
    }

    unset($result[$model][$fields['password']]);
    return $result[$model];

  }

  /**
   * Creates a user with Facebook email, id & token
   *
   * @param array $user
   * @param string $tokenData
   * @return Mixed Either false on failure, or an array of user data.
   */
  protected function _createUser($user, $tokenData)
  {
    $userModel = $this->settings['userModel'];
    list($plugin, $model) = pluginSplit($userModel);
    $fields = $this->settings['fields'];

    $modelInstance = ClassRegistry::init($userModel);

	// fix: test fb users have no username
	if (!isset($user['username'])) {
		$user['username'] = '';
	}

    $modelInstance->create();
    $newUser = array(
        $fields['email']                  => $user['email'],
        $fields['name']                   => $user['name'],
        $fields['facebook_user_id']       => $user['id'],
        $fields['facebook_username']      => $user['username'],
        $fields['facebook_access_token']  => $tokenData['access_token'],
        $fields['facebook_token_expires'] => $tokenData['expires']
    );
    $result = $modelInstance->save(array($userModel => $newUser, false));

    $userId = $modelInstance->getInsertID();

    if (empty($result) || empty($result[$model])) {
      return false;
    }

    return $result[$model];
  }

  /**
   * Update an existing user with Facebook email, id & token
   *
   * @param array $user
   * @param` array $fbDetails
   * @param string $tokenData
   * @return Mixed Either false on failure, or an array of user data.
   */
  protected function _updateUser($user, $fbDetails, $tokenData)
  {
    $userModel = $this->settings['userModel'];
    list($plugin, $model) = pluginSplit($userModel);
    $fields = $this->settings['fields'];

    $result = ClassRegistry::init($userModel)->save(array(
      $userModel => array(
        $fields['id']                    => $user[$fields['id']],
        $fields['email']                 => $fbDetails['email'],
        $fields['name']                  => $fbDetails['name'],
        $fields['facebook_user_id']      => $fbDetails['id'],
		$fields['facebook_username']     => $fbDetails['username'],
        $fields['facebook_access_token'] => $tokenData['access_token'],
        $fields['facebook_token_expires']=> $tokenData['expires']
      )
    ), false);
    

    
    if (empty($result) || empty($result[$model])) {
      return false;
    }

    return $result[$model];
  }
  /**
   * Make a connection to given url using cURL if enabled.
   * Falls back to file_get_contents if cURL isn't enabled.
   *
   * @param string $url
   * @return Mixed Either false on failure, or string of returned page
   */
  public function _connect($url)
  {
    $response = false;
    /**
     * Check to see if cURL is enabled
     */
    if (is_callable('curl_init')) {

      $curl = curl_init($url);

      if (is_resource($curl) === true) {
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        // Disable SSL verification for testing: 
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        // Production:
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CAINFO, App::pluginPath('FacebookAuth') . 'Vendor' .DS. 'facebook-php-sdk' .DS. 'src' .DS. 'fb_ca_chain_bundle.crt');

        /**
         * Attempt to execute the session until we get a result OR
         * the number of maximum attempts has been reached
         */
        $attempts = 3;
        while (($response === false) && (--$attempts > 0)) {
          $response = curl_exec($curl);
        }

        curl_close($curl);
      } else {
        return false;
      }

    /**
     * If cURL is not enabled, we use file_get_contents
     */
    } else {
      $response = @file_get_contents($url);
    }

    return $response;
  }

}

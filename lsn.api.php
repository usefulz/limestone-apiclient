<?PHP

/**
 * @name   Limestone Client API
 * @doc    https://rw.limestonenetworks.com/administrative/api.html
 * @doc    https://rw.limestonenetworks.com/administrative/api/documentation.html
 * @author https://github.com/usefulz
 * @prereq cURL, cURLSSL, SimpleXML
 */

require_once 'lsn.tickets.php';
require_once 'lsn.servers.php';
require_once 'lsn.billing.php';
require_once 'lsn.dns.php';
require_once 'lsn.users.php';
 
class LSN
{

  public $url		= "https://one.limestonenetworks.com/webservices/clientapi.php?";
  public $version	= '1.02';
  public $api_key	= '';
  public $module;
  public $action;

  public function __construct($api_key, $url = null)
  {
	if (empty($api_key)) throw new Exception('OnePortal API Key must be provided.');
    if (empty($url)) $url = 'https://one.limestonenetworks.com/webservices/clientapi.php';
    $this->url = $url . '?';
    $this->api_key = $api_key;
    return true;
  }

  public function APIQuery($module, $action, $method = 'GET', $args = FALSE)
  {

    $this->module = $module;
    $this->action = $action;
    $apiurl = $this->url .
              "key="     . $this->api_key .
              "&mod="    . $module .
              "&action=" . $action;
    if ($method == 'GET' && $args !== FALSE) $apiurl .= "&" . http_build_query($args);

    /* Initialize cURL Session */
    $apisess = curl_init();

    /* Set generic options */
    curl_setopt($apisess, CURLOPT_URL, $apiurl);
    curl_setopt($apisess, CURLOPT_USERAGENT, 'Limestone PHP-API/' . $this->version);
    curl_setopt($apisess, CURLOPT_HEADER, 0);
    curl_setopt($apisess, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($apisess, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($apisess, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($apisess, CURLOPT_TIMEOUT, 30);
    curl_setopt($apisess, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($apisess, CURLOPT_VERBOSE, 0);
    curl_setopt($apisess, CURLOPT_HTTP_VERSION, '1.0');

    /* SSL Options */
    curl_setopt($apisess, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($apisess, CURLOPT_SSL_VERIFYHOST, 1);

    /* POST method options */
    if ($method == 'POST')
    {
      curl_setopt($apisess, CURLOPT_POST, 1);
      curl_setopt($apisess, CURLOPT_POSTFIELDS, http_build_query($args));
    }

    $response = curl_exec($apisess);

    /* Error handling */
    if (!$response || strlen($response)>25)
    {
      return FALSE;
    }

    curl_close($apisess);

    /* Handle Bandwidth graphs */
    if ($module == 'servers' && $action == 'bwgraph')
    {
      $final = sprintf("<img src='data:image/png;base64,%s'>", base64_encode($response));
    } else {
      $final = new SimpleXMLElement($response);
    }

    return $final;
  }
}
?>

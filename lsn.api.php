<?PHP

/**
 * Limestone Client API
 * https://rw.limestonenetworks.com/administrative/api.html
 * https://rw.limestonenetworks.com/administrative/api/documentation.html
 */

class LSN
{

  public $url		= "https://one.limestonenetworks.com/webservices/clientapi.php?";
  public $version	= '1.01';
  public $api_key	= '';

  public $module;
  public $action;

  /* Blind functions */
  public function __construct()
  {
    return TRUE;
  }
  public function get_balance()
  {
    return $this->APIQuery('billing', 'getbalance',	'GET', FALSE);
  }
  public function unpaid()
  {
    return $this->APIQuery('billing', 'unpaid',	'GET', FALSE);
  }
  public function sources()
  {
    return $this->APIQuery('billing', 'sources', 'GET', FALSE);
  }
  public function getprobtypes()
  {
    return $this->APIQuery('support', 'getprobtypes', 'GET', FALSE);
  }
  public function getOperatingSystems()
  {
    return $this->APIQuery('servers', 'getOperatingSystems', 'GET', FALSE);
  }
  public function phishingstatus()
  {
    return $this->APIQuery('servers', 'phishingstatus', 'GET', FALSE);
  }


  /* Functions with optional arguments */

  public function serverlist($server_id = FALSE)
  {
    if (isset($server_id)) $filter['server_id'] = $server_id;
    return $this->APIQuery('servers', 'list', 'GET', (sizeof($filter) ? $filter : FALSE));
  }

  public function history($limit = 100) { return $this->APIQuery('billing', 'history', 'GET', (isset($limit) ? array('limit' => $limit) : FALSE) ); }

  public function ipaddresses($ipaddress = FALSE, $server_id = FALSE, $network = FALSE, $type = 'public')
  {
    if (isset($ipaddress) || $ipaddress !== FALSE) $filter['ipaddress'] = $ipaddress;
    if (isset($server_id) || $server_id !== FALSE) $filter['server_id'] = $server_id;
    if (isset($network)   || $network !== FALSE)   $filter['network']   = $network;
    if (isset($type) || $type !== FALSE)           $filter['type']      = $type;
    $ips = $this->APIQuery('ipaddresses', 'list', 'GET', (sizeof($filter) ? $filter : FALSE) );
    return $ips;
  }

  /* Functions with required arguments */

  public function portcontrol($serverid, $port, $set)
  {
   $filter['serverid'] = $serverid; // LSN-D####
   $filter['port'] = $port;         // private|public
   $filter['set'] = $set;           // on|off
   return $this->APIQuery('servers', 'portcontrol', 'POST', $filter);
  }

  public function pay($invoiceid, $sourceid, $amount = FALSE)
  {
    $filter['invoiceid'] = $invoiceid;
    $filter['sourceid']  = $sourceid;
    if (isset($amount) && $amount !== FALSE) $filter['amount'] = $amount;
    return $this->APIQuery('billing', 'pay', 'POST', $filter);
  }

  public function dns_setreverse($ipaddress, $value)
  {
    $filter['ipaddress'] = $ipaddress;
    $filter['value']     = $value;
    $setrdns = $this->APIQuery('dns', 'setreverse', 'POST', $filter);
    return $setrdns;
  }

  public function gethardware($server_id)
  {
    $filter['server_id'] = $server_id;
    return $this->APIQuery('servers', 'gethardware', 'GET', $filter);
  }

  public function reload($server_id, $os, $password)
  {
    $filter['server_id'] = $server_id;
    $filter['os']	 = $os;  // available from $lsn->getOperatingSystems->attributes()->id
    $filter['password']	 = $password; // Please change this!
    return $this->APIQuery('servers', 'reload', 'GET', $filter);
  }

  public function rename($newname, $server_id)
  {
    $filter['serverid'] = $server_id;
    $filter['newname']	 = $newname;
    return $this->APIQuery('servers', 'rename', 'GET', $filter);
  }

  public function restart($server_id)
  {
    $filter['serverid'] = $server_id;
    return $this->APIQuery('servers', 'restart', 'GET', $filter);
  }

  public function turnoff($server_id)
  {
    $filter['serverid'] = $server_id;
    return $this->APIQuery('servers', 'turnoff', 'GET', $filter);
  }

  public function turnon($server_id)
  {
    $filter['serverid'] = $server_id;
    return $this->APIQuery('servers', 'turnon', 'GET', $filter);
  }

  public function bwgraph($server_id, $start = time()-3600, $stop = time())
  {
    $filter['server_id'] = $server_id;
    if (isset($start) || $start !== FALSE)		$filter['start'] = $start;
    if (isset($stop) || $stop !== FALSE)		$filter['stop'] = $stop;
    return $this->APIQuery('servers', 'bwgraph', 'GET', (sizeof($filter) ? $filter : FALSE));
  }

  public function addticket($probtype, $summary, $description, $user_id, $server = FALSE, $admin_user = FALSE, $admin_pass = FALSE)
  {
    $filter['probtype']    = $probtype;
    $filter['summary']     = $summary;
    $filter['description'] = $description;
    $filter['user_id']     = $user_id;
    if (isset($server) && $server !== FALSE) $filter['server'] = $server;
    if (isset($admin_user) && $admin_user !== FALSE) $filter['admin_user'] = $admin_user;
    if (isset($admin_pass) && $admin_pass !== FALSE) $filter['admin_pass'] = $admin_pass;
    return $this->APIQuery('billing', 'pay', 'POST', $filter);
  }

  public function listtickets($status = 'open')
  {
    if (isset($status)) $filter['status'] = $status;
    return $this->APIQuery('support', 'listtickets', 'GET', $filter);
  }

  public function setstatus($ticket, $user_id, $status)
  {
    $filter['ticket'] = $ticket;
    $filter['user_id']= $user_id;
    $filter['status'] = $status;
    return $this->APIQuery('support', 'setstatus', 'POST', $filter);
  }

  public function updateticket($ticket, $user_id, $message)
  {
    $filter['ticket'] = $ticket;
    $filter['user_id']= $user_id;
    $filter['message'] = $message;
    return $this->APIQuery('support', 'updateticket', 'POST', $filter);
  }

  public function viewticket($ticket)
  {
    $filter['ticket'] = $ticket;
    return $this->APIQuery('support', 'viewticket', 'GET', $filter);
  }

  public function userlist()
  {
    return $this->APIQuery('users', 'list', 'GET', FALSE);
  }

  /* API Call Function */

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
    if (!$response)
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

$lsn = new LSN;

?>

<?php
class Servers extends LSN
{
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

  
  public function portcontrol($serverid, $port, $set)
  {
   $filter['serverid'] = $serverid; // LSN-D####
   $filter['port'] = $port;         // private|public
   $filter['set'] = $set;           // on|off
   return $this->APIQuery('servers', 'portcontrol', 'POST', $filter);
  }
  
    public function serverlist($server_id = FALSE)
  {
    if (isset($server_id)) $filter['server_id'] = $server_id;
    return $this->APIQuery('servers', 'list', 'GET', (sizeof($filter) ? $filter : FALSE));
  }
  public function getOperatingSystems()
  {
    return $this->APIQuery('servers', 'getOperatingSystems', 'GET', FALSE);
  }
  public function phishingstatus()
  {
    return $this->APIQuery('servers', 'phishingstatus', 'GET', FALSE);
  }
  public function bwgraph($server_id, $start = time()-3600, $stop = time())
  {
    $filter['server_id'] = $server_id;
    if (isset($start) || $start !== FALSE)		$filter['start'] = $start;
    if (isset($stop) || $stop !== FALSE)		$filter['stop'] = $stop;
    return $this->APIQuery('servers', 'bwgraph', 'GET', (sizeof($filter) ? $filter : FALSE));
  }
}
?>
<?php
class Tickets extends LSN
{
  public function addticket($probtype, $summary, $description, $user_id, $server = FALSE, $admin_user = FALSE, $admin_pass = FALSE)
  {
    $filter['probtype']    = $probtype;
    $filter['summary']     = $summary;
    $filter['description'] = $description;
    $filter['user_id']     = $user_id;
    if (isset($server) && $server !== FALSE) $filter['server'] = $server;
    if (isset($admin_user) && $admin_user !== FALSE) $filter['admin_user'] = $admin_user;
    if (isset($admin_pass) && $admin_pass !== FALSE) $filter['admin_pass'] = $admin_pass;
    return $this->APIQuery('support', 'addticket', 'POST', $filter);
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
  
  public function getprobtypes()
  {
    return $this->APIQuery('support', 'getprobtypes', 'GET', FALSE);
  }
}
?>
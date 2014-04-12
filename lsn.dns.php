<?php
class DNS extends LSN
{
  public function dns_setreverse($ipaddress, $value)
  {
    $filter['ipaddress'] = $ipaddress;
    $filter['value']     = $value;
    $setrdns = $this->APIQuery('dns', 'setreverse', 'POST', $filter);
    return $setrdns;
  }
}
?>
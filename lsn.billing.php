<?php
class Billing extends LSN
{
  public function pay($invoiceid, $sourceid, $amount = FALSE)
  {
    $filter['invoiceid'] = $invoiceid;
    $filter['sourceid']  = $sourceid;
    if (isset($amount) && $amount !== FALSE) $filter['amount'] = $amount;
    return $this->APIQuery('billing', 'pay', 'POST', $filter);
  }
}
?>
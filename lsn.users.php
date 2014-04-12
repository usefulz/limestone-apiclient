<?php
class Users extends LSN
{
  public function userlist()
  {
    return $this->APIQuery('users', 'list', 'GET', FALSE);
  }
}
?>
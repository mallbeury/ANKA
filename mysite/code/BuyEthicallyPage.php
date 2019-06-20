<?php
class BuyEthicallyPage extends Page {

  private static $db = array(
  );

  private static $has_many = array(
  );

  private static $has_one = array(
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    return $fields;
  }

}
class BuyEthicallyPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

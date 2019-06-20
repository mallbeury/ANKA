<?php
class ArtCentresPage extends Page {
  static $allowed_children = array("ArtCentrePage");

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
class ArtCentresPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

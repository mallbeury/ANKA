<?php
class FeedPage extends Page {

  private static $db = array(
    'FeedURL' => 'Text'
  );

  private static $has_many = array(
  );

  private static $has_one = array(
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    $fields->addFieldToTab('Root.Main', new TextField('FeedURL', 'Juicer URL'));

    // remove fields
    $fields->removeFieldFromTab('Root.Main', 'Content');

    return $fields;
  }

}
class FeedPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();

    $this->HomePage = DataObject::get_one("HomePage");
  }
}

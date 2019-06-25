<?php
class ArtCentrePage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text',
    'MainImageCredit' => 'Text', 
    'LocationLat' => 'Text',
    'LocationLng' => 'Text'
  );

  private static $has_many = array(
  );

  private static $has_one = array(
    'MainImage' => 'Image'
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    $fields->addFieldToTab('Root.Main', new TextareaField('TitleTextFormatted', 'Formatted Title'), 'Content');

    $uploadField1 = new UploadField($name = 'MainImage', $title = 'Main Image');
    $uploadField1->setCanUpload(false);
    $fields->addFieldToTab('Root.Main', $uploadField1, 'Content');

    $fields->addFieldToTab('Root.Main', new TextField('MainImageCredit', 'Main Image Credit'), 'Content');  

    $fields->addFieldToTab('Root.Location', new TextField('LocationLat', 'Latitude'));  
    $fields->addFieldToTab('Root.Location', new TextField('LocationLng', 'Longitude'));  

    return $fields;
  }

}
class ArtCentrePage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

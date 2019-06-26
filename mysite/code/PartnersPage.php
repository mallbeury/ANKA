<?php
class PartnersPage extends Page {

  private static $db = array(
    'PartnerText' => 'HTMLText',
    'PartnerImageCredit' => 'Text',
    'ArtText' => 'HTMLText',
    'ArtImageCredit' => 'Text',
    'IndustryText' => 'HTMLText'
  );

  private static $has_many = array(
  );

  private static $has_one = array(
    'PartnerImage' => 'Image', 
    'ArtImage' => 'Image'
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    // remove fields
    $fields->removeFieldFromTab('Root.Main', 'Content');

    // partners
    $fields->addFieldToTab('Root.Main', new LiteralField ('literalfield', '<strong>Funding Partners</strong>')); 
    $fields->addFieldToTab('Root.Main', new HtmlEditorField('PartnerText', 'Text')); 

    $uploadField1 = new UploadField($name = 'PartnerImage', $title = 'Image');
    $uploadField1->setCanUpload(false);
    $fields->addFieldToTab('Root.Main', $uploadField1);
    $fields->addFieldToTab('Root.Main', new TextField('PartnerImageCredit', 'Credit'));  

    // art
    $fields->addFieldToTab('Root.Main', new LiteralField ('literalfield', '<strong>Art Bodies</strong>')); 
    $fields->addFieldToTab('Root.Main', new HtmlEditorField('ArtText', 'Text')); 

    $uploadField2 = new UploadField($name = 'ArtImage', $title = 'Image');
    $uploadField2->setCanUpload(false);
    $fields->addFieldToTab('Root.Main', $uploadField2);
    $fields->addFieldToTab('Root.Main', new TextField('ArtImageCredit', 'Credit'));  
      
    // industry
    $fields->addFieldToTab('Root.Main', new LiteralField ('literalfield', '<strong>Industry Partners</strong>')); 
    $fields->addFieldToTab('Root.Main', new HtmlEditorField('IndustryText', 'Text')); 

    return $fields;
  }

}
class PartnersPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

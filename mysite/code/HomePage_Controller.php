<?php
class HomePage extends Page {

  private static $db = array(
    'HeroTextFormatted' => 'Text',
    'HeroTextSmallFormatted' => 'Text',
    'MsgTextFormatted' => 'Text',
    'WhoContent' => 'HTMLText',
    'WhoImageCredit' => 'Text',
    'HowContent' => 'HTMLText',
    'HowImageCredit' => 'Text',
    'KeepUpImageCredit' => 'Text',
    'ImpactImageCredit' => 'Text'
  );

  private static $has_many = array(
  );

  private static $has_one = array(
    'WhoImage' => 'Image',
    'HowImage' => 'Image',
    'KeepUpImage' => 'Image',
    'ImpactImage' => 'Image'
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    // remove fields
    $fields->removeFieldFromTab('Root.Main', 'Content');

    $fields->addFieldToTab('Root.Main', new LiteralField ('literalfield', '<strong>Hero</strong>'));
    $fields->addFieldToTab('Root.Main', new TextareaField('HeroTextFormatted', 'Text'));
    $fields->addFieldToTab('Root.Main', new TextareaField('HeroTextSmallFormatted', 'Text (Mobile)'));
    
    $fields->addFieldToTab('Root.Main', new LiteralField ('literalfield', '<strong>Message</strong>'));
    $fields->addFieldToTab('Root.Main', new TextareaField('MsgTextFormatted', 'Text'));

    // who we are
    $fields->addFieldToTab('Root.WhoWeAre', new HtmlEditorField('WhoContent', 'Text'));

    $uploadField1 = new UploadField($name = 'WhoImage', $title = 'Image');
    $uploadField1->setCanUpload(false);
    $fields->addFieldToTab('Root.WhoWeAre', $uploadField1);
    $fields->addFieldToTab('Root.WhoWeAre', new TextField('WhoImageCredit', 'Credit'));

    // how
    $fields->addFieldToTab('Root.WhatWeDo', new HtmlEditorField('HowContent', 'Text'));

    $uploadField2 = new UploadField($name = 'HowImage', $title = 'Image');
    $uploadField2->setCanUpload(false);
    $fields->addFieldToTab('Root.WhatWeDo', $uploadField2);
    $fields->addFieldToTab('Root.WhatWeDo', new TextField('HowImageCredit', 'Credit'));

    // keep up
    $uploadField3 = new UploadField($name = 'KeepUpImage', $title = 'Image');
    $uploadField3->setCanUpload(false);
    $fields->addFieldToTab('Root.KeepUp', $uploadField3);
    $fields->addFieldToTab('Root.KeepUp', new TextField('KeepUpImageCredit', 'Credit'));

    // impact
    $uploadField4 = new UploadField($name = 'ImpactImage', $title = 'Image');
    $uploadField4->setCanUpload(false);
    $fields->addFieldToTab('Root.Impact', $uploadField4);
    $fields->addFieldToTab('Root.Impact', new TextField('ImpactImageCredit', 'Credit'));

    return $fields;
  }

}
class HomePage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

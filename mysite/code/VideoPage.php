<?php
class VideoPage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text',
    'SubTitleText' => 'Text'
  );

  private static $has_many = array(
    'VideoElements' => 'VideoElement'
  );

  private static $has_one = array(
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    // remove fields
    $fields->removeFieldFromTab('Root.Main', 'Content');

    $fields->addFieldToTab('Root.Main', new TextareaField('TitleTextFormatted', 'Formatted Title'), 'Content');

    $config = GridFieldConfig_RelationEditor::create();
    $config->removeComponentsByType('GridFieldPaginator');
    $config->removeComponentsByType('GridFieldPageCount');
    $config->addComponent(new GridFieldSortableRows('SortID'));

    $videoElementField = new GridField(
      'VideoElements', // Field name
      'Video Element', // Field title
      $this->VideoElements(),
      $config
    );
    $fields->addFieldToTab('Root.Main', $videoElementField); 

    return $fields;
  }

}
class VideoPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

<?php
class ProgramPage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text'
  );

  private static $has_many = array(
    'ProgramPhotoElements' => 'ProgramPhotoElement',
  );

  private static $has_one = array(
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    $fields->addFieldToTab('Root.Main', new TextareaField('TitleTextFormatted', 'Formatted Title'), 'Content');

    // images
    $config = GridFieldConfig_RelationEditor::create();
    $config->removeComponentsByType('GridFieldPaginator');
    $config->removeComponentsByType('GridFieldPageCount');
    $config->addComponent(new GridFieldSortableRows('SortID'));

    $photoElementField = new GridField(
      'ProgramPhotoElements', // Field name
      'Photo Element', // Field title
      $this->ProgramPhotoElements(),
      $config
    );
    $fields->addFieldToTab('Root.Gallery', $photoElementField); 

    return $fields;
  }

}
class ProgramPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

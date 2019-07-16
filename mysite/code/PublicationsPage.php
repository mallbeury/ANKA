<?php
class PublicationsPage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text',
    'SubTitleText' => 'Text'
  );

  private static $has_many = array(
    'PublicationDownloadElements' => 'PublicationDownloadElement'
  );

  private static $has_one = array(
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    // remove fields
    $fields->removeFieldFromTab('Root.Main', 'Content');

    $fields->addFieldToTab('Root.Main', new TextareaField('TitleTextFormatted', 'Formatted Title'));
    $fields->addFieldToTab('Root.Main', new TextField('SubTitleText', 'Subtitle'));

    $config = GridFieldConfig_RelationEditor::create();
    $config->removeComponentsByType('GridFieldPaginator');
    $config->removeComponentsByType('GridFieldPageCount');
    $config->addComponent(new GridFieldSortableRows('SortID'));

    $publicationElementField = new GridField(
      'PublicationDownloadElements', // Field name
      'Publication Download Element', // Field title
      $this->PublicationDownloadElements(),
      $config
    );
    $fields->addFieldToTab('Root.Main', $publicationElementField); 

    return $fields;
  }

}
class PublicationsPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

<?php
class ProjectPage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text'
  );

  private static $has_many = array(
    'ProjectElements' => 'ProjectElement',
    'ProjectDownloadElements' => 'ProjectDownloadElement',
  );

  private static $has_one = array(
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    // remove fields
    $fields->removeFieldFromTab('Root.Main', 'Content');

    $fields->addFieldToTab('Root.Main', new TextareaField('TitleTextFormatted', 'Formatted Title'));

    $config = GridFieldConfig_RelationEditor::create();
    $config->removeComponentsByType('GridFieldPaginator');
    $config->removeComponentsByType('GridFieldPageCount');
    $config->addComponent(new GridFieldSortableRows('SortID'));

    $projectElementField = new GridField(
      'ProjectElements', // Field name
      'Project Element', // Field title
      $this->ProjectElements(),
      $config
    );
    $fields->addFieldToTab('Root.Main', $projectElementField); 

    // Downloads
    $config2 = GridFieldConfig_RelationEditor::create();
    $config2->removeComponentsByType('GridFieldPaginator');
    $config2->removeComponentsByType('GridFieldPageCount');
    $config2->addComponent(new GridFieldSortableRows('SortID'));

    $pojectDownloadElementField = new GridField(
      'ProjectDownloadElements', // Field name
      'Download Element', // Field title
      $this->ProjectDownloadElements(),
      $config2
    );
    $fields->addFieldToTab('Root.Downloads', $pojectDownloadElementField); 

    return $fields;
  }

}
class ProjectPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();

    $this->HomePage = DataObject::get_one("HomePage");

    $this->Projects = DataObject::get( 
      $callerClass = "ProjectPage", 
      $filter = "", 
      $sort = "",
      $join = "",
      $limit = "" 
      );
  }
}

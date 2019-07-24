<?php
class StandardPage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text'
  );

  private static $has_many = array(
    'PageElements' => 'PageElement',
    'GalleryElements' => 'GalleryElement',
    'DownloadElements' => 'DownloadElement',
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

    $pageElementField = new GridField(
      'PageElements', // Field name
      'Page Element', // Field title
      $this->PageElements(),
      $config
    );
    $fields->addFieldToTab('Root.Main', $pageElementField); 

    // Gallery
    $config2 = GridFieldConfig_RelationEditor::create();
    $config2->removeComponentsByType('GridFieldPaginator');
    $config2->removeComponentsByType('GridFieldPageCount');
    $config2->addComponent(new GridFieldSortableRows('SortID'));

    $galleryElementField = new GridField(
      'GalleryElements', // Field name
      'Gallery Element', // Field title
      $this->GalleryElements(),
      $config2
    );
    $fields->addFieldToTab('Root.Gallery', $galleryElementField); 

    // Downloads
    $config3 = GridFieldConfig_RelationEditor::create();
    $config3->removeComponentsByType('GridFieldPaginator');
    $config3->removeComponentsByType('GridFieldPageCount');
    $config3->addComponent(new GridFieldSortableRows('SortID'));

    $downloadElementField = new GridField(
      'DownloadElements', // Field name
      'Download Element', // Field title
      $this->DownloadElements(),
      $config3
    );
    $fields->addFieldToTab('Root.Downloads', $downloadElementField); 

    return $fields;
  }

}
class StandardPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
  }
}

<?php
class ArtCentrePage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text',
    'Synopsis' => 'Text',
    'MainImageCredit' => 'Text', 
    'LocationLat' => 'Text',
    'LocationLng' => 'Text',
    'ContactWebsite' => 'Varchar',
    'ContactAddress' => 'Text',
    'ContactPhone' => 'Varchar',
    'ContactEmail' => 'Varchar',
    'ContactSocial' => 'Text',
    'ContactHours' => 'Text',
    'ContactManager' => 'Varchar',
    'InfoRegion' => 'Varchar',
    'InfoLanguages' => 'Varchar',
    'InfoFounded' => 'Varchar',
    'InfoMediums' => 'Varchar'
  );

  private static $has_many = array(
    'ArtCentrePhotoElements' => 'ArtCentrePhotoElement',
  );

  private static $has_one = array(
    'MainImage' => 'Image'
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    $fields->addFieldToTab('Root.Main', new TextareaField('TitleTextFormatted', 'Formatted Title'), 'Content');

    $fields->addFieldToTab('Root.Main', new TextareaField('Synopsis', 'Synopsis'), 'Content');

    $uploadField1 = new UploadField($name = 'MainImage', $title = 'Main Image');
    $uploadField1->setCanUpload(false);
    $fields->addFieldToTab('Root.Main', $uploadField1, 'Content');

    $fields->addFieldToTab('Root.Main', new TextField('MainImageCredit', 'Main Image Credit'), 'Content');  

    $fields->addFieldToTab('Root.Location', new TextField('LocationLat', 'Latitude'));  
    $fields->addFieldToTab('Root.Location', new TextField('LocationLng', 'Longitude'));  

    // contact
    $fields->addFieldToTab('Root.Contact', new TextField('ContactWebsite', 'Website'));  
    $fields->addFieldToTab('Root.Contact', new TextareaField('ContactAddress', 'Address'));
    $fields->addFieldToTab('Root.Contact', new TextField('ContactPhone', 'Phone'));  
    $fields->addFieldToTab('Root.Contact', new TextField('ContactEmail', 'Email'));  
    $fields->addFieldToTab('Root.Contact', new TextareaField('ContactSocial', 'Social'));
    $fields->addFieldToTab('Root.Contact', new TextareaField('ContactHours', 'Hours'));
    $fields->addFieldToTab('Root.Contact', new TextField('ContactManager', 'Manager'));  

    // info
    $fields->addFieldToTab('Root.Information', new TextField('InfoRegion', 'Region'));  
    $fields->addFieldToTab('Root.Information', new TextField('InfoLanguages', 'Languages'));  
    $fields->addFieldToTab('Root.Information', new TextField('InfoFounded', 'Founded'));  
    $fields->addFieldToTab('Root.Information', new TextField('InfoMediums', 'Mediums'));  

    // images
    $config = GridFieldConfig_RelationEditor::create();
    $config->removeComponentsByType('GridFieldPaginator');
    $config->removeComponentsByType('GridFieldPageCount');
    $config->addComponent(new GridFieldSortableRows('SortID'));

    $photoElementField = new GridField(
      'ArtCentrePhotoElements', // Field name
      'Photo Element', // Field title
      $this->ArtCentrePhotoElements(),
      $config
    );
    $fields->addFieldToTab('Root.Gallery', $photoElementField); 

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

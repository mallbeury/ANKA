<?php
class BoardProfileElement extends DataObject {
  private static $db = array(
    'Name' => 'Text',
    'SortID'=>'Int',
    'Title' => 'Text',
    'Region' => 'Text',
    'ProfileInfo' => 'HTMLText',
    'RegionWebsite' => 'Varchar',
    'RegionWebsiteURL' => 'Varchar',
    'ArtWebsite' => 'Varchar',
    'ArtWebsiteURL' => 'Varchar',
    'Country' => 'Varchar',
    'Languages' => 'Text',
    'BoardTime' => 'Varchar',
    'Qualifications' => 'Text'
  );

  private static $has_one = array(
    'HeroImage' => 'Image', 
    'Board' => 'BoardPage'
  );
  
  // this function creates the thumbnail for the summary fields to use 
  public function ImageThumbnail() { 
    return $this->HeroImage()->SetHeight(100); 
  }

  public static $summary_fields = array( 
    'Name' => 'Name',
    'ImageThumbnail' => 'Thumbnail' 
  );
  
  private static $default_sort = "SortID ASC";
  
  function getCMSFields() {
    $uploadField = new UploadField($name = 'HeroImage', $title = 'Image');
    $uploadField->setCanUpload(false);
  
    $fields = new FieldList (
      new TextField('Name', 'Name'), 
      new TextField('Title', 'Title'), 
      new TextField('Region', 'Region'), 
      $uploadField,
      new HtmlEditorField('ProfileInfo', 'Profile'),
      new LiteralField ('literalfield', '<strong>Region</strong>'),
      new TextField('RegionWebsite', 'Website'),
      new TextField('RegionWebsiteURL', 'URL'),
      new LiteralField ('literalfield', '<strong>Art Centre</strong>'),
      new TextField('ArtWebsite', 'Website'),
      new TextField('ArtWebsiteURL', 'URL'),
      new TextField('Country', 'Country'),
      new TextField('Languages', 'Languages'),
      new TextField('BoardTime', 'Time on board'),
      new TextareaField('Qualifications', 'Qualifications')
    );

    return $fields; 
  }
}

<?php
class SupporterElement extends DataObject {
  private static $db = array(
    'Name' => 'Text',
    'SortID'=>'Int',
    'SupporterURL' => 'Text'
  );

  private static $has_one = array(
    'HeroImage' => 'Image', 
    'Page' => 'HomePage'
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
      new TextField('SupporterURL', 'URL'), 
      $uploadField
    );

    return $fields; 
  }
}

<?php
class ProgramPhotoElement extends DataObject {
  private static $db = array(
    'Name' => 'Text',
    'SortID'=>'Int'
  );

  private static $has_one = array(
    'MainImage' => 'Image', 
    'Page' => 'ProgramPage'
  );    

  public function ImageThumbnail() { 
    return $this->MainImage()->SetHeight(100); 
  }
    
  public static $summary_fields = array( 
    'Name' => 'Name',
    'ImageThumbnail' => 'Thumbnail' 
  );
  
  private static $default_sort = "SortID ASC";
  
  function getCMSFields() {   
    $uploadField = new UploadField('MainImage', 'Image');
    $uploadField->setCanUpload(false);

    $fields = new FieldList (
      new TextField('Name', 'Name'),
      $uploadField
    );

    return $fields; 
 }  
}

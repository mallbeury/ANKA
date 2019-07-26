<?php
class ProgramPhotoElement extends DataObject {
  private static $db = array(
    'Name' => 'Text',
    'SortID'=>'Int',
    'HeroImageCredit' => 'Text',
    'ImageSize'=>'Int'
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
    $imageSizeField = new OptionsetField(
      $name = "ImageSize",
      $title = "Size",
      $source = array("50%", "75%", "75% - RIGHT"),
        $value = 0
    );    

    $uploadField = new UploadField('MainImage', 'Image');
    $uploadField->setCanUpload(false);

    $fields = new FieldList (
      new TextField('Name', 'Name'),
      $uploadField,
      new TextField('HeroImageCredit', 'Credit'),
      $imageSizeField      
    );

    return $fields; 
 }  
}

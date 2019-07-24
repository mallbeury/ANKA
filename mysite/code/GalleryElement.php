<?php
class GalleryElement extends DataObject {
  private static $db = array(
    'Name' => 'Varchar',
    'SortID'=>'Int',
    'HeroImageCredit' => 'Text',
    'ImageSize'=>'Int'
  );

  private static $has_one = array(
    'HeroImage' => 'Image', 
    'Page' => 'StandardPage'
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
    $imageSizeField = new OptionsetField(
      $name = "ImageSize",
      $title = "Size",
      $source = array("50%", "75%", "75% - RIGHT"),
        $value = 0
    );    

    $uploadField = new UploadField($name = 'HeroImage', $title = 'Image');
    $uploadField->setCanUpload(false);
  
    $fields = new FieldList (
      new TextField('Name', 'Name'), 
      new LiteralField ('literalfield', '<strong>Image Element</strong>'), 
      $uploadField,
      new TextField('HeroImageCredit', 'Credit'),
      $imageSizeField
    );

    return $fields; 
 }  
}

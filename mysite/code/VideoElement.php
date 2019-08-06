<?php
class VideoElement extends DataObject {
  private static $db = array(
    'Name' => 'Text',
    'SortID'=>'Int',
    'Description' => 'HTMLText',
    'VideoSize'=>'Int'
  );

  private static $has_one = array(
    'VideoImage' => 'Image', 
    'VideoFile' => 'File', 
    'Page' => 'VideoPage'
  );    
    
  public static $summary_fields = array( 
    'Name' => 'Name'
  );
  
  private static $default_sort = "SortID ASC";
  
  function getCMSFields() {
    $videoSizeField = new OptionsetField(
      $name = "VideoSize",
      $title = "Size",
      $source = array("50%", "75%", "75% - RIGHT"),
        $value = 0
    );    

    $uploadFieldVideo = new UploadField('VideoFile', 'Video');
    $uploadFieldVideo->setAllowedExtensions(array('m4v', 'mp4'));
    $uploadFieldVideo->setCanUpload(false);

    $uploadImageField = new UploadField($name = 'VideoImage', $title = 'Poster Image');
    $uploadImageField->setCanUpload(false);

    $fields = new FieldList (
      new TextField('Name', 'Name'),
      new TextareaField('Description', 'Description'),
      $uploadImageField,
      $uploadFieldVideo,
      $videoSizeField
    );

    return $fields; 
 }  
}

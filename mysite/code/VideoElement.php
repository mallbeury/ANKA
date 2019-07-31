<?php
class VideoElement extends DataObject {
  private static $db = array(
    'Name' => 'Varchar',
    'SortID'=>'Int',
    'Description' => 'HTMLText',
    'VideoSize'=>'Int'
  );

  private static $has_one = array(
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
    $uploadFieldVideo->setAllowedExtensions(array('m4v'));
    $uploadFieldVideo->setCanUpload(false);

    $fields = new FieldList (
      new TextField('Name', 'Name'),
      new TextareaField('Description', 'Description'),
      $uploadFieldVideo,
      $videoSizeField
    );

    return $fields; 
 }  
}

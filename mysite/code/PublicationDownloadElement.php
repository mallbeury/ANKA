<?php
class PublicationDownloadElement extends DataObject {
  private static $db = array(
    'Name' => 'Varchar',
    'SortID'=>'Int',
    'Description' => 'HTMLText',
  );

  private static $has_one = array(
    'HeroImage' => 'Image', 
    'PDFFile' => 'File', 
    'Page' => 'PublicationsPage'
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

    $uploadFieldPDF = new UploadField('PDFFile', 'PDF File');
    $uploadFieldPDF->setAllowedExtensions(array('pdf'));
    $uploadFieldPDF->setCanUpload(false);

    $fields = new FieldList (
      new TextField('Name', 'Name'),
      new TextareaField('Description', 'Description'),
      $uploadField,
      $uploadFieldPDF
    );

    return $fields; 
 }  
}

<?php
class DownloadElement extends DataObject {
  private static $db = array(
    'Name' => 'Text',
    'SortID'=>'Int'
  );

  private static $has_one = array(
    'PDFFile' => 'File', 
    'Page' => 'StandardPage'
  );    
    
  public static $summary_fields = array( 
    'Name' => 'Name'
  );
  
  private static $default_sort = "SortID ASC";
  
  function getCMSFields() {   
    $uploadFieldPDF = new UploadField('PDFFile', 'PDF File');
    $uploadFieldPDF->setAllowedExtensions(array('pdf'));
    $uploadFieldPDF->setCanUpload(false);

    $fields = new FieldList (
      new TextField('Name', 'Name'),
      $uploadFieldPDF
    );

    return $fields; 
 }  
}

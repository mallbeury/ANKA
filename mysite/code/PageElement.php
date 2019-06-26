<?php
class PageElement extends DataObject {
  private static $db = array(
    'Name' => 'Varchar',
    'SortID'=>'Int',
    'Content' => 'HTMLText',
    'QuoteCredit' => 'Text',
    'Quote' => 'HTMLText',
    'FeatureTitle' => 'Text',
    'Feature' => 'HTMLText',
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

  public function FormatContent() {
    $obj= HTMLText::create();
    $obj->setValue($this->Content);
     
    return $obj->FirstSentence(); 
  }
  
  public static $summary_fields = array( 
    'Name' => 'Name',
    'FormatContent' => 'Content',     
    'ImageThumbnail' => 'Thumbnail' 
  );
  
  private static $default_sort = "SortID ASC";
  
  function getCMSFields() {   
    $imageSizeField = new OptionsetField(
      $name = "ImageSize",
      $title = "Size",
      $source = array("60%", "90%", "FULL"),
        $value = 0
    );    

    $uploadField = new UploadField($name = 'HeroImage', $title = 'Image');
    $uploadField->setCanUpload(false);
  
    $fields = new FieldList (
      new TextField('Name', 'Name'), 
      new LiteralField ('literalfield', '<strong>Text Element</strong>'),
      new HtmlEditorField('Content', 'Content'),
      new LiteralField ('literalfield', '<strong>Quote Element</strong>'),
      new TextareaField('Quote', 'Text'),
      new TextField('QuoteCredit', 'Credit'),
      new LiteralField ('literalfield', '<strong>Feature Element</strong>'),
      new TextField('FeatureTitle', 'Title'),
      new TextareaField('Feature', 'Text'),
      new LiteralField ('literalfield', '<strong>Image Element</strong>'), 
      $uploadField,
      $imageSizeField
    );

    return $fields; 
 }  
}

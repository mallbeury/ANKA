<?php
class BoardPage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text'
  );

  private static $has_many = array(
    'BoardProfileElements' => 'BoardProfileElement'
  );

  private static $has_one = array(
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    $fields->addFieldToTab('Root.Main', new TextareaField('TitleTextFormatted', 'Formatted Title'), 'Content');

    $config1 = GridFieldConfig_RelationEditor::create();
    $config1->removeComponentsByType('GridFieldPaginator');
    $config1->removeComponentsByType('GridFieldPageCount');
    $config1->addComponent(new GridFieldSortableRows('SortID'));

    $boardProfileElementField = new GridField(
      'BoardProfileElements', // Field name
      'Board Profile Element', // Field title
      $this->BoardProfileElements(),
      $config1
    );
    $fields->addFieldToTab('Root.Main', $boardProfileElementField); 

    return $fields;
  }

}
class BoardPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
    
    function buildProfiles($ProfileElements) {
      $ProfileElementsEdited = new ArrayList();
      $nCols = 3;
      $nCol = 0;
      foreach($ProfileElements as $item) {
        switch ($nCol) {
          case 0:
            $strAlign = 'left';
            break;
          case 1:
            $strAlign = 'middle';
            break;
          case 2:
            $strAlign = 'right';
            break;
        }
        $item->Align = $strAlign;

        if ($nCol == $nCols-1) {
          $nCol = 0;
          $item->Break = true;
        }
        else {
          $nCol++;
        }
        $ProfileElementsEdited->push($item);
      }
      // we have a remainder so add another break
      if ($nCol < $nCols-1) {
        $item->Break = true;
      }
      return $ProfileElementsEdited;
    }

    $this->BoardProfileElementsEdited = buildProfiles($this->BoardProfileElements());
  }
}

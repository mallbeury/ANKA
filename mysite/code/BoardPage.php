<?php
class BoardPage extends Page {

  private static $db = array(
    'TitleTextFormatted' => 'Text'
  );

  private static $has_many = array(
    'BoardProfileElements' => 'BoardProfileElement',
    'AdvisorProfileElements' => 'AdvisorProfileElement',
    'StaffProfileElements' => 'StaffProfileElement'
  );

  private static $has_one = array(
  );

  function getCMSFields() {
    $fields = parent::getCMSFields();

    $fields->addFieldToTab('Root.Main', new TextareaField('TitleTextFormatted', 'Formatted Title'), 'Content');

    // Board
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

    // Advisors
    $config2 = GridFieldConfig_RelationEditor::create();
    $config2->removeComponentsByType('GridFieldPaginator');
    $config2->removeComponentsByType('GridFieldPageCount');
    $config2->addComponent(new GridFieldSortableRows('SortID'));

    $advisorProfileElementField = new GridField(
      'AdvisorProfileElements', // Field name
      'Advisor Profile Element', // Field title
      $this->AdvisorProfileElements(),
      $config1
    );
    $fields->addFieldToTab('Root.Main', $advisorProfileElementField); 

    // Staff
    $config3 = GridFieldConfig_RelationEditor::create();
    $config3->removeComponentsByType('GridFieldPaginator');
    $config3->removeComponentsByType('GridFieldPageCount');
    $config3->addComponent(new GridFieldSortableRows('SortID'));

    $staffProfileElementField = new GridField(
      'StaffProfileElements', // Field name
      'Staff Profile Element', // Field title
      $this->StaffProfileElements(),
      $config1
    );
    $fields->addFieldToTab('Root.Main', $staffProfileElementField); 

    return $fields;
  }

}
class BoardPage_Controller extends Page_Controller {
  private static $allowed_actions = array (
  );

  public function init() {
    parent::init();
    
    $this->HomePage = DataObject::get_one("HomePage");

    function buildProfiles($ProfileElements) {
      $ProfileElementsEdited = new ArrayList();
      $nCols = 4;
      $nCol = 0;
      foreach($ProfileElements as $item) {
        switch ($nCol) {
          case 0:
            $strAlign = 'left';
            break;
          case 1:
            $strAlign = 'middle1';
            break;
          case 2:
            $strAlign = 'middle2';
            break;
          case 3:
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
      if ($nCol <= $nCols-1) {
        $item->Break = true;
      }
      return $ProfileElementsEdited;
    }

    $this->BoardProfileElementsEdited = buildProfiles($this->BoardProfileElements());
    $this->AdvisorProfileElementsEdited = buildProfiles($this->AdvisorProfileElements());
    $this->StaffProfileElementsEdited = buildProfiles($this->StaffProfileElements());
  }
}

<?php

class Content_Controller extends Controller {
	private static $allowed_actions = array('filter');
    public function filter(SS_HTTPRequest $request) {
  		$param = $request->allParams();

      switch ($param["Filter"]) {
        case 'all':
          $this->Results = DataObject::get(
            $callerClass = "ArtCentrePage",
            $filter = "", 
            $sort = "Title asc"
          );
          break;

        default:
          $this->Results = DataObject::get( 
            $callerClass = "ArtCentrePage", 
            $filter = "ParentID = " . $param["Filter"], 
            $sort = "Title asc",
            $join = "",
            $limit = "" 
            );
          break;
      }

  		$output = $this->renderWith('AjaxArtRegionFilter');
  		echo $output;
    }	
}

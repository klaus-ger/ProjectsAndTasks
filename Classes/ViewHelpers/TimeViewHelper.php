<?php
namespace T3developer\ProjectsAndTasks\ViewHelpers;


class TimeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper  {
 
    /**
     * Tx_Fluid_Core_ViewHelper_AbstractViewHelper
     * View Helper tcalculate time
     * 
     * @param int $time
     * 

     */       
        
  
    /**
     * Main method of the View Helper
     * 
     * @param int $time
     * 
      */
    public function render($time) {
        
        $time = $time/3600;
        
        return $time . ' h';
       
    }
 
}
?>
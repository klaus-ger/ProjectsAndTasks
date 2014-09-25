<?php

namespace T3developer\ProjectsAndTasks\ViewHelpers;

class SelectoptgroupViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {


    /**
     * Main method of the View Helper
     * 
     * @param array $options The option Array
     * @param string $fieldname  The fieldname
     * @param int $actual The actual value
     * @param string $class  The fieldname
     * 
     * 
     */
    public function render($options, $fieldname, $actual, $class) {
        
        $field = '<select name = "' . $fieldname . '" class="' . $class . '">';
        $field.= '<option value = "">-- Category --</option>';
        foreach ($options as $opt) {
            //cehck if field is selected
            if ($opt[main]->getUid() == $actual) {
                $selected = ' selected="selected"';
            } else {
                $selected = ' ';
            }

            $field.= '<option' . $selected . ' value = "' . $opt[main]->getUid() . '" class="mainopt">' . substr($opt[main]->getCatTitle(), 0, 17) . '</option>';

            foreach ($opt[subs] as $sub) {
                //cehck if field is selected
                if ($sub->getUid() == $actual) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = ' ';
                }

                $field.= '<option'. $selected .' value = "' . $sub->getUid() . '">' . substr($sub->getCatTitle(), 0, 17) . '</option>';
            }
        }
        $field.= '</select >';



        return $field;
    }

}

?>
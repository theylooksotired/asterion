<?php
/**
* @class ParamsUi
*
* This class manages the UI for the Params objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class Params_Ui extends Ui{
    
    /**
    * Function to render a label in the administration area
    */
    public function label($canModify = false, $nested = false) {
        $information = ($this->object->get('informationExtra')!='') ? htmlentities($this->object->get('informationExtra')) : $this->object->get('information');
        return '<div class="label">
                    <div class="labelInside labelstyle_medium">
                        <a href="'.$this->linkModify($nested).'">'.$this->object->get('code').'</a>
                    </div>
                    <div class="labelInside labelstyle_regularSmall">'.$information.'</div>
                </div>';
    }

}
?>
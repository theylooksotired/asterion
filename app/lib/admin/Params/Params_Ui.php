<?php
class Params_Ui extends Ui{
    
    public function label($canModify = false, $nested = false) {
        $information = ($this->object->get('informationExtra')!='') ? htmlentities($this->object->get('informationExtra')) : $this->object->get('information');
        return '<div class="label">
                    <div class="labelInside labelstyle_medium">
                        <a href="'.$this->linkModify($nested).'">'.$this->object->get('code').'</a>
                    </div>
                    <div class="labelInside labelstyle_regularSmall">'.$information.'</div>
                    <div class="clearer"></div>
                </div>';
    }

}
?>
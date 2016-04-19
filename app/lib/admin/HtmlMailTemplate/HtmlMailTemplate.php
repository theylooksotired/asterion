<?php
class HtmlMailTemplate extends Db_Object {

  public function __construct($VALUES=array()) {
    parent::__construct($VALUES);
  }

  static public function code($code) {
    //Return the object using it's code
    return HtmlMailTemplate::readFirst(array('where'=>'code="'.$code.'"'));
  }

  static public function insertConfig() {
    //Initialize the table with default values
    $htmlMailTemplates = HtmlMailTemplate::countResults();
    if ($htmlMailTemplates == 0) {
      //Basic email template
      $htmlMailTemplate = new HtmlMailTemplate();
      $basicTemplate = htmlentities('<table align="center" border="0" cellpadding="0" cellspacing="0" style="width: 600px;">
                        <tbody>
                          <tr>
                            <td><p style="text-align: center;"><img alt="'.Params::param('titlePage').'" src="'.LOGO.'" /><br />&nbsp;</p></td>
                          </tr>
                          <tr>
                            <td>#CONTENT</td>
                          </tr>
                          <tr>
                            <td style="text-align: center;">'.HtmlSectionAdmin::show('footer').'</td>
                          </tr>
                        </tbody>
                      </table>');
      $htmlMailTemplate->insert(array('code'=>'basic',
                      'idsAvailable'=>'#CONTENT',
                      'title_en'=>'Basic Template',
                      'title_fr'=>'Gabarit basique',
                      'title_es'=>'Plantilla simple',
                      'template_en'=>$basicTemplate,
                      'template_fr'=>$basicTemplate,
                      'template_es'=>$basicTemplate
                      ));
    }
  }

}
?>
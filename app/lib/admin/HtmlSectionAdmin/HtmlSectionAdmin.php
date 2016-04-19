<?php
class HtmlSectionAdmin extends Db_Object {

    public function __construct($VALUES=array()) {
        parent::__construct($VALUES);
    }

    static public function code($code) {
        //Return the object using it's code
        return HtmlSectionAdmin::readFirst(array('where'=>'code="'.$code.'"'));
    }

    static public function show($code) {
        //Show the object using it's code
        $html = HtmlSectionAdmin::code($code);
        return $html->showUi('Page');
    }

    static public function insertConfig() {
        //Initialize the table with default values
        $sections = HtmlSectionAdmin::countResults();
        if ($sections==0) {
            $section = new HtmlSectionAdmin();
            $section->insert(array('code'=>'intro', 'title_en'=>'Intro', 'title_fr'=>'Intro', 'title_es'=>'Intro', 'section_en'=>'<p>Welcome to the admin section.</p>', 'section_fr'=>'<p>Bienvenue au centre d\'administration de votre site.</p>', 'section_es'=>'<p>Bienvenido a la secci&oacute;n de administracion de su sitio.</p>'));
            $section = new HtmlSectionAdmin();
            $section->insert(array('code'=>'footer', 'title_en'=>'Footer', 'title_fr'=>'Pied de page', 'title_es'=>'Pie de p&aacute;gina', 'section_en'=>'<p>Asterion - <a href="mailto:info@asterion-cms.com">info@asterion-cms.com</a></p>', 'section_fr'=>'<p>Asterion - <a href="mailto:info@asterion-cms.com">info@asterion-cms.com</a></p>', 'section_es'=>'<p>Asterion - <a href="mailto:info@asterion-cms.com">info@asterion-cms.com</a></p>'));
        }
    }

}
?>
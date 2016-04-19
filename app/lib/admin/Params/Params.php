<?php
class Params extends Db_Object {

    public function __construct($values=array()) {
        parent::__construct($values);
    }

    static public function init() {
        //Retrieve the values in the database
        $query = 'SELECT code, information, informationExtra
                        FROM '.Db::prefixTable('Params');
        $items = array();
        $result = Db::returnAll($query);
        foreach ($result as $item) {
            $items[$item['code']] = ($item['informationExtra']!='') ? $item['informationExtra'] : $item['information'];
        }
        $_ENV['params'] = $items;
    }

    static public function param($code){
        //Get a value
        if (isset($_ENV['params'][$code.'_'.Lang::active()])) {
            return $_ENV['params'][$code.'_'.Lang::active()];
        } else {
            return (isset($_ENV['params'][$code])) ? $_ENV['params'][$code] : '';
        }
    }

    static public function insertConfig() {
        //Initialize the table with default values
        $params = Params::countResults();
        if ($params == 0) {
            foreach (Lang::langs() as $lang) {
                $param = new Params();
                $param->insert(array('code'=>'titlePage_'.$lang, 'information'=>TITLE));
                $param = new Params();
                $param->insert(array('code'=>'metaDescription_'.$lang, 'information'=>TITLE.'...'));
                $param = new Params();
                $param->insert(array('code'=>'metaKeywords_'.$lang, 'information'=>TITLE.'...'));
            }
            $param = new Params();
            $param->insert(array('code'=>'email', 'information'=>EMAIL));
            $param = new Params();
            $param->insert(array('code'=>'link-facebook', 'information'=>'http://www.facebook.com'));
            $param = new Params();
            $param->insert(array('code'=>'link-twitter', 'information'=>'http://www.twitter.com'));
            $param = new Params();
            $param->insert(array('code'=>'link-youtube', 'information'=>'http://www.youtube.com'));
            $param = new Params();
            $param->insert(array('code'=>'link-linkedin', 'information'=>'http://www.linkedin.com'));
            $param = new Params();
            $param->insert(array('code'=>'googleWebmasters', 'informationExtra'=>'<meta name="google-site-verification" content="H3dN86dbZdDl_iDCbRkdqNJoH4mLFrZw3k7G74l-PZw" />'));
            $param = new Params();
            $param->insert(array('code'=>'googleAnalytics',
                                'informationExtra'=>"<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-4946844-43', 'auto');ga('send', 'pageview');</script>"));
        }
    }

}
?>
<?php
define('APP_FOLDER', 'base');
require_once(APP_FOLDER.'/config/config.php');

$info =  array(
array('idUserType'=>'1',
                                    'name'=>'Asterion Administrator',
                                    'email'=>'##EMAIL',
                                    'password'=>'asterion',
                                    'active'=>'1')
);

echo json_encode($info);

/*
$info = array(array('code'=>'link-facebook', 'information'=>'http://www.facebook.com'),
	array('code'=>'link-twitter', 'information'=>'http://www.twitter.com'),
	array('code'=>'link-youtube', 'information'=>'http://www.youtube.com'),
	array('code'=>'link-linkedin', 'information'=>'http://www.linkedin.com'),
	array('code'=>'googleWebmasters', 'information'=>'<meta name="google-site-verification" content="H3dN86dbZdDl_iDCbRkdqNJoH4mLFrZw3k7G74l-PZw" />'),
	array('code'=>'googleAnalytics', 'information'=>"<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', 'UA-4946844-43', 'auto');ga('send', 'pageview');</script>"));

print_r(json_encode($info));

/*
print_r(Init::insertInitialValues('LangTrans'));
Url::init();
Lang::init();

echo __('save');
/*
$info = Csv::toArrays('LangTrans');

print_r(json_encode($info));
*/
?>

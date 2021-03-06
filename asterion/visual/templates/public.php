<!DOCTYPE html>
<html lang="<?php echo Lang::active();?>">
<head>

    <meta charset="utf-8">
    <meta name="description" content="<?php echo $metaDescription;?>"/>
    <meta name="keywords" content="<?php echo $metaKeywords;?>"/>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

    <meta property="og:title" content="<?php echo $title;?>" /> 
    <meta property="og:description" content="<?php echo $metaDescription;?>" />    
    <meta property="og:image" content="<?php echo $metaImage;?>" /> 

    <?php echo Params::param('googleWebmasters');?>

    <link rel="shortcut icon" href="<?php echo BASE_URL;?>visual/img/favicon.ico"/>
    <link rel="canonical" href="<?php echo $metaUrl;?>" />

    <title><?php echo $title;?></title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>libjs/prism/prism.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL;?>visual/css/stylesheets/public.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="<?php echo APP_URL; ?>libjs/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>libjs/public.js"></script>

    <!--
    <?php echo Params::param('googleAnalytics');?>

    <?php echo $header;?>
    -->

</head>
<body>
    <div id="bodyFrame">
        <?php echo $content;?>
    </div>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>libjs/prism/prism.js" data-default-language="markup"></script>
</body>
</html>
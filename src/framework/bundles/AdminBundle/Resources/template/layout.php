<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php e($title); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php echo $this->assets->getUrl('styles/reset.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->assets->getUrl('styles/style.css'); ?>" rel="stylesheet" type="text/css" />
    <?php echo $this->stylesheets; ?>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" ></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" ></script>
    <script type="text/javascript" src="<?php echo $this->assets->getUrl('scripts/script.js'); ?>" ></script>-->
    <?php echo $this->javascripts; ?>

</head>
<body>
    <div class="line main-navigation">
        <div class="select-site">
            <h1>Yacht Export</h1>
            <div class="alternate">
                hmm
            </div>
        </div>
        <a class="preview" href="http://phpgeek.pl/" title="Przejdź na stronę">Zobacz stronę</a>

        <!--<ul class="navigation">
            <li class="active"><a href="#">Zarządzaj</a></li>
            <li><a href="#">Bloki</a></li>
            <li><a href="#">Użytkownicy</a></li>
            <li><a href="#">Konfiguracja</a></li>
        </ul>-->
        <?php echo $menu; ?>
        <div class="user">

            sognat (<a href="#">profil</a> | <a href="#">wyloguj</a>)
        </div>
    </div>
    <div class="line"><form enctype="multipart/form-data" method="post">
        <?php echo $left; ?>
        <?php echo $right; ?>
        <div class="editor">
            <?php echo $content; ?>
        </div>
    </form></div>
</body>
</html>
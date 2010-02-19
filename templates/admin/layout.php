<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php e($title); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php asset('reset.css'); ?>" rel="stylesheet" type="text/css"  /> 
    <link href="<?php asset('style.css'); ?>" rel="stylesheet" type="text/css"  /> 
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" ></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" ></script>
    <script type="text/javascript" src="<?php asset('script.js'); ?>" ></script>

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

        <ul class="navigation">
            <li class="active"><a href="#">Zarządzaj</a></li>
            <li><a href="#">Bloki</a></li>
            <li><a href="#">Użytkownicy</a></li>
            <li><a href="#">Konfiguracja</a></li>
        </ul>
        <div class="user">

            sognat (<a href="#">profil</a> | <a href="#">wyloguj</a>)
        </div>
    </div>
    <div class="line"><form method="post">
        <div class="left-sidebar">
            <p>Dashboard Projekty Contener Blog</p>
            <?php echo $left; ?>
            
            <h3 class="opened">Dashboard</h3>
            <ul class="navigation">
                <li>

                    <a id="dashboard" title="Strona główna" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/7">Dashboard</a>
                </li>
                <li>
                    <a id="add-page" title="Strona główna" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/7">Dodaj stronę</a>
                </li>
            </ul>
        
        </div>
        <div class="right-sidebar">
            <?php echo $right; ?>
                
                <h3 class="opened">Typ strony</h3>
                <dl class="line">

                    <dt>Typ</dt>
                    <dd><select name="blah"><option>Jacht</option></select></dd>
                    <dt>Szablon</dt>
                    <dd><select name="blah"><option>Na sprzedaż</option><option>Do wynajęcia</option></select></dd>
                </dl> 
                
                <h3 class="closed">Ustawienia SEO</h3>

                <div></div>
                <h3 class="closed">Wersje strony</h3>
                <div></div>
        </div>
        <div class="editor">
            <?php echo $content; ?>
        </div>
    </form></div>
</body>
</html>
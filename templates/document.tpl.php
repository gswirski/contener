<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php e($title); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="<?php asset('reset.css'); ?>" rel="stylesheet" type="text/css"  /> 
    <link href="assets/style.css" rel="stylesheet" type="text/css"  /> 
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" ></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" ></script>
    <script type="text/javascript" src="assets/script.js" ></script>

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
    <div class="line">
        <div class="left-sidebar">
            <div class="dialog_box button add-page"><span class="add_page_label">Dodaj stronę &raquo;</span>

                <div class="new_page_panel">
            
                    <h4>Wybierz typ strony</h4>
                    <ul>
                        <li>
                            <a href="/Contener/index.php/admin/page/add/parent/0/template/information">
                                <img src="/Contener/assets/admin/images/icons/file_txt.png" alt="Dodaj stronę" />
                                <span class="page_type_label">Informacje</span>
                            </a>

                        </li>
            
                        <li>
                            <a href="/Contener/index.php/admin/page/add/parent/0/template/project">
                                <img src="/Contener/assets/admin/images/icons/browser.png" alt="Dodaj stronę" />
                                <span class="page_type_label">Projekt</span>
                            </a>
                        </li>
                        <li>

                            <a href="/Contener/index.php/admin/page/add/parent/0/template/download">
            
                                <img src="/Contener/assets/admin/images/icons/box_download.png" alt="Dodaj stronę" />
                                <span class="page_type_label">Pobieranie</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Contener/index.php/admin/page/add/parent/0/template/contact">
                                <img src="/Contener/assets/admin/images/icons/vcard.png" alt="Dodaj stronę" />

                                <span class="page_type_label">Kontakt</span>
            
                            </a>
                        </li>
                    </ul>
                    <h4>Lub dodaj nowy moduł</h4>
                    <ul>
                        <li>
                            <a href="#">

                                <img src="/Contener/assets/admin/images/icons/rss_circle_comments.png" alt="Dodaj stronę" />
                                <span class="page_type_label">Blog</span>
                
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="/Contener/assets/admin/images/icons/speech_bubble_grey.png" alt="Dodaj stronę" />
                                <span class="page_type_label">Forum</span>

                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <h3 class="opened">Dashboard</h3>
            <ul class="navigation">
                <li>

                    <a id="dashboard" title="Strona główna" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/7">Dashboard</a>
                </li>
                <li>
                    <a id="add-page" title="Strona główna" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/7">Dodaj stronę</a>
                </li>
            </ul>
            
            <h3 class="opened">Zarządzaj stronami</h3>

            
            <ul class="navigation">
                <li>
                    <a id="menu-7" title="Strona główna" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/7">Strona główna</a>
                </li>
                <li class="active">
                    <a id="menu-5" title="Projekty" class="Contener_Page container" href="/Contener/index.php/admin/page/edit/id/5">Jachty</a>
                    <a href="#" class="add">dodaj</a>

                    <ul>
                        <li class="active">
                            <a id="menu-6" title="WebLeader.pl" class="Contener_Page last" href="/Contener/index.php/admin/page/edit/id/6">Jakiś wypaśny jachcik</a>
                        </li>
                        <li>
                            <a id="menu-666" title="WebLeader.pl" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/6">Troszkę mniej</a>
                        </li>
                        <li>

                            <a id="menu-667" title="WebLeader.pl" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/6">Lorem</a>
                        </li>
                        <li>
                            <a id="menu-668" title="WebLeader.pl" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/6">Ave 666</a>
                        </li>
                    </ul>
                </li>
                <li>

                    <a id="menu-3" title="Blog" class="Plugin_Blog_Page container" href="/Contener/index.php/admin/page/edit/id/3">Blog</a>
                    <ul>
            
                        <li>
                            <a id="menu-4" title="Witamy" class="Plugin_Blog_Post_Page" href="/Contener/index.php/admin/page/edit/id/4">Witamy</a>
                        </li>
                    </ul>
                </li>
                <li>

                    <a id="menu-2" title="Kontakt" class="Contener_Page" href="/Contener/index.php/admin/page/edit/id/2">Kontakt</a>
                </li>
            
            </ul>
        
        </div>
        <div class="right-sidebar">
            <div class="line">
                <input type="submit" class="button" id="publish" name="publish" value="Publikuj" />
                <input type="submit" class="button" id="save-draft" name="save-draft" value="Zachowaj szkic" />

                <a class="button delete" href="#"><img src="images/trash.gif" /></a>
            </div>
                
                <h3 class="opened">Opcje publikacji</h3>
                <dl class="line">
                    <dt>Status</dt>
                    <dd><input type="checkbox" /> opublikowany</dd>
                    <dt>Nawigacja</dt>

                    <dd><input type="checkbox" /> pokazuj</dd>
                    <dt>Autor</dt>
                    <dd>Grzegorz Świrski</dd>
                </dl>
                
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
            <h2>Edytuj stronę</h2>
            <div class="page-title"><input type="text" id="title" name="title" value="Jakiś wypaśny jachcik" /></div>
            <p class="permament-link">

                <strong>Bezpośredni odnośnik</strong>:
                http://localhost/<span class="editable"><input type="text" id="permalink" name="permalink" value="wypasny-jachcik" /></span>/
            </p>
            
            <ul class="tabs">
                <li><a href="#">Opis</a></li>
                <li class="active"><a href="#">Dane techniczne</a></li>
                <li><a href="#">Galeria</a></li>
            </ul>

            
            <label for="slots-text">Wartość tekstowa</label>
            <div class="input"><input type="text" id="slots-text" name="slots[text]" value="" /></div>
            
            <label for="slots-long_text">Długi tekst</label>
            <div class="input"><textarea rows="10" cols="10" id="slots-long_text" class="wysiwyg" name="slots[long_text]"></textarea></div>
            
            <label for="slots-long_text">Kolejny długi tekst</label>
            <div class="input"><textarea rows="10" cols="10" id="slots-long_text_another" class="wysiwyg" name="slots[long_text]"></textarea></div>

            
            <label for="slots-text">I mały bonus</label>
            <div class="input"><input type="text" id="slots-text-another" name="slots[text]" value="" /></div>
        </div>
    </div>
    
    <!-- <html>
      <head>
    <title><?php e($title); ?></title>
    <?php foreach ($styles as $style): ?>
        <link rel="stylesheet" href="<?php e($style); ?>" />
    <?php endforeach; ?>
    <?php foreach ($scripts as $script): ?>
        <script type="text/javascript" src="<?php e($script); ?>"></script>
    <?php endforeach; ?>
      </head>
      <body>
          <h1>Dunno why, but works</h1>
        <?php echo $content; ?>
      </body>
    <?php foreach ($onload as $javascript): ?>
        <script type="text/javascript">
          <?php echo $javascript; ?>
        </script>
    <?php endforeach; ?>
    </html> -->
</body>
</html>
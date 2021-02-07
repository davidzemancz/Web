<?php
require_once("config.php");

function render_cards($page){
    global $mysqli;
    
    $sql = "SELECT Id, Title, Content, Page, TimeStamp FROM articles WHERE Page = '" . $page . "' ORDER BY Id DESC";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo ' 
            <article>
                <header>
                    <h2>'. $row["Title"] .'</h2>
                </header>
                    ' . $row["Content"];
             if ($page == "home") echo '
                <footer>
                    <p>' . date("d.m.Y",strtotime($row["TimeStamp"])) . '</p>
                </footer>';
            echo'</article>';
        }
    } else {
        echo "Žádné karty";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="UTF-8"/>
        <meta name="description" content="David Zeman - osobní web">
        <meta name="keywords" content="David Zeman, Zeman">
        <meta name="author" content="David Zeman">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>David Zeman</title>

        <link rel="icon" href="img/logo.png"/>
        <link rel="stylesheet" href="styles/style.css"/>

        <script>
            function print_element(elem) {
                const print_window = window.open('', 'PRINT', 'height=' + window.innerHeight + ',width=' + window.innerWidth);
                print_window.document.write('<html><head><title>' + document.title + '</title>');
                print_window.document.write('<link rel="stylesheet" href="styles/style.css"/>');
                print_window.document.write('</head><body>');
                print_window.document.write(document.getElementById(elem).innerHTML);
                print_window.document.write('</body></html>');
                print_window.focus();
                setTimeout( function(){
                    print_window.print();
                    print_window.close();
                }, 500);
               

                return true;
            }
            function init_pages(){
                const pages = get_pages()

                const page = sessionStorage.getItem('selected-page');

                for(i = 0; i < pages.length; i++){
                    if (i === 0){
                        document.getElementById("menu-" + pages[i]).classList.add("selected")
                        document.getElementById(pages[i]).classList.add("selected")
                    }
                    else if (pages[i] === page){
                        document.getElementById("menu-" + pages[0]).classList.remove("selected")
                        document.getElementById(pages[0]).classList.remove("selected")

                        document.getElementById("menu-" + pages[i]).classList.add("selected")
                        document.getElementById(pages[i]).classList.add("selected")
                    }
                    else{
                        document.getElementById("menu-" + pages[i]).classList.remove("selected")
                        document.getElementById(pages[i]).classList.remove("selected")
                    }
                }
            }
            function get_pages(){
                return ["home", "mffuk", "projects", "contact","about"]
            }
            function on_body_load(){
                init_pages();
            }
            function on_menu_item_click(page) {
                const pages = get_pages()

                for(i = 0; i < pages.length; i++){
                    if (pages[i] === page){
                        document.getElementById("menu-" + pages[i]).classList.add("selected")
                        document.getElementById(pages[i]).classList.add("selected")

                        sessionStorage.setItem('selected-page', page);
                    }
                    else{
                        document.getElementById("menu-" + pages[i]).classList.remove("selected")
                        document.getElementById(pages[i]).classList.remove("selected")
                    }
                }
            }
        </script>
    </head>
    <body onload="on_body_load()">
        <div class="header">
            <img alt="logo" class="logo" src="img/logo_inv.png">
            <h1>David Zeman</h1>
        </div>
        <div class="main-menu">
           <div class="main-menu-items">
               <div class="main-menu-item">
                   <span id="menu-home" onclick="on_menu_item_click('home')">Příspěvky</span>
               </div> 
               <div class="main-menu-item">
                   <span id="menu-projects" onclick="on_menu_item_click('projects')">Projekty</span>
               </div>
               <div class="main-menu-item">
                <span id="menu-about" onclick="on_menu_item_click('about')">Životopis</span>
               </div>
               <div class="main-menu-item">
                <span id="menu-mffuk" onclick="on_menu_item_click('mffuk')">MFFUK</span>
               </div>
               <div class="main-menu-item">
                    <span id="menu-contact" onclick="on_menu_item_click('contact')">Kontakt</span>
               </div>
               <hr class="main-menu-divider"/>
               <div class="main-menu-item bottom">
                    <a href="login.php">Přihlásit se</a>
               </div>
           </div>
        </div> 
        <div class="main-content">
            <div id="home" class="content-page">
                <div class="main-content-header">
                    <h2>Příspěvky</h2>
                    <p>
                    </p>
                </div>
                <?php 
                    render_cards("home")
                ?>
            </div>
            <div id="mffuk" class="content-page">
                <div class="main-content-header">
                    <h2>MFFUK</h2>
                    <p>
                        Aktuálně studuji obor Informatika na Matematicko-fyzikální fakutlně UK.
                    </p>                   
                </div>
                <?php 
                    render_cards("mffuk")
                ?>
            </div>
            <div id="projects" class="content-page">
                <div class="main-content-header">
                    <h2>Projekty</h2>
                    <p>
                    </p>
                </div>
                <?php 
                    render_cards("projects")
                ?>
            </div>
            <div id="about" class="content-page">
                <div id="cv">
                    <div class="cv">
                        <div class="cv-header">
                            <h2>Životopis</h2>
                        </div>
                        <div class="cv-body">
                            <div class="cv-section">
                                <h3>
                                    David Zeman
                                </h3>
                                <ul>
                                    <li>20 let</li>
                                    <li>Vývojář</li>
                                    <li>5 let praxe</li>
                                    <li>Praha, České Budějovice</li>
                                </ul>
                            </div>
                            <div class="cv-section">
                                <h3>
                                    Vzdělání
                                </h3>
                                <ul>
                                    <li>Univerzita Karlova
                                        <ul>
                                            <li>Matematicko-fyzikální fakulta</li>
                                            <li>Informatika</li>
                                            <li>2020 - nyní</li>
                                        </ul>
                                    </li>
                                    <li>Gymnázium
                                        <ul>
                                            <li>Prachatice, Zlatá Stezka 137</li>
                                            <li>2012 - 2020</li>
                                        </ul>
                                    </li>
                                    <li>ZŠ Národní
                                        <ul>
                                            <li>Prachatice, Národní 1018</li>
                                            <li>2007-2012</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="cv-section">
                                <h3>
                                    Zkušenosti
                                </h3>
                                <ul>
                                    <li>Programovací jazyky
                                        <ul>
                                            <li>C#</li>
                                            <li>Intersystems Caché Object Script</li>
                                            <li>JS, HTML, CSS</li>
                                            <li>Python</li>
                                        </ul>
                                    </li>
                                    <li>Technologie
                                        <ul>
                                            <li>Windows Forms</li>
                                            <li>ASP.NET MVC</li>
                                            <li>Intersystems Caché, IRIS</li>
                                            <li>ReactJS</li>
                                            <li>ReactNative</li>
                                            <li>Keras (TensorFlow)</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="cv-section">
                                <h3>
                                    Praxe
                                </h3>
                                <ul>
                                    <li>Skladové hospodářství
                                        <ul>
                                            <li>M-line software s.r.o.</li>
                                            <li>Komplexní systém pro správu skladového hospodářství velkých dopravních firem v ČR.</li>
                                            <li class="italic">C#, Caché</li>
                                        </ul>
                                    </li>
                                    <li>Spedice nákladní dopravy
                                        <ul>
                                            <li>M-line software s.r.o.</li>
                                            <li>Logistický systém na správu zakázek a tvorbu objednávek pro dopravní společnosti.</li>
                                            <li class="italic">C#, Caché</li>
                                        </ul>
                                    </li>
                                    <li>Objednávky
                                        <ul>
                                            <li>M-line software s.r.o.</li>
                                            <li>Objednávkový systém pro dopravní podnik s procesem od zadání vnitroobjednávky, jejího schválení a tvorbu objednávky pro dodavatele.</li>
                                            <li class="italic">C#, Caché</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="cv-section cv-print-only">
                                <h3>
                                    Kontakt
                                </h3>
                                <ul>
                                    <li>E-mail: mail@davidzeman.cz</li>
                                    <li>Telefon: +420 720 333 987</li>
                                </ul>
                            </div>
                        </div>
                        <div class="cv-footer">
                            <span class="cv-print" onclick="print_element('cv')">Tisk</span>
                            <span class="cv-print-only">www.davidzeman.cz</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="contact" class="content-page">
                <div class="contact">
                    <div class="contact-header">
                        <h2>Kontakt</h2>
                    </div>
                    <ul>
                    <li><a href="mailto:mail@davidzeman.cz">mail@davidzeman.cz</a></li>
                    <li><a target="_blank" href="https://github.com/davidzemancz">GitHub</a></li>
                    <li><a target="_blank" href="https://www.linkedin.com/in/david-zeman-215a421b2/">LinkedIn</a></li>
                    </ul>
                </div>
        </div>
    </body>
</html>

<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
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
        <link rel="stylesheet" href="styles/admin.css"/>

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
                return ["home", "mffuk", "projects"]
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
            <h1>David Zeman - EDITOR</h1>
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
                   <span id="menu-mffuk" onclick="on_menu_item_click('mffuk')">MFFUK</span>
               </div>
               <hr class="main-menu-divider"/>
               <div class="main-menu-item bottom">
                    <a href="logout.php">Odhlásit se</a>
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
                <article>
                    <header>
                        <h2>Novinky</h2>
                    </header>
                    <section>
                        <h3>
                            PHP!
                        </h3>
                        <p>
                            <?php echo "Web od nynějška úspešně běží na PHP 7.3." ?>
                        </p>
                        <p>
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "web";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                            }
                            echo "Connected successfully";

                            $sql = "INSERT INTO Articles (Title, Content)
                            VALUES ('První PHP příspěvek', 'Test prvního příspěvku uloženého v databázi.')";

                            if ($conn->query($sql) === TRUE) {
                            echo "New record created successfully";
                            } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                            }

                            $conn->close();
                        ?>
                        </p>
                    </section>
                    <section>
                        <h3>
                             Životopis
                        </h3>
                        <p>
                            V menu přibyl nový odkaz na stránku mého skromného životopisu. Ten je možné tisknout či uložit do formátu PDF.
                        </p>
                    </section>
                    <footer>
                        <p>04.02.2021</p>
                    </footer>
                </article>
                <article>
                    <header>
                        <h2>První příspěvěk</h2>
                    </header>
                    <section>
                        <h3>
                            Poznámka
                        </h3>
                        <p>
                            Testovací verze webu. :)
                        </p>
                    </section>
                    <footer>
                        <p>24.01.2021</p>
                    </footer>
                </article>
            </div>
            <div id="mffuk" class="content-page">
                <div class="main-content-header">
                    <h2>MFFUK</h2>
                    <p>
                        Aktuálně studuji obor Informatika na Matematicko-fyzikální fakutlně UK.
                    </p>                   
                </div>
                <article>
                    <header>
                        <h2>ZS 2020/21</h2>
                    </header>
                    <section>
                        <h3>
                            Poznámky ke stažení
                        </h3>
                        <p>
                            Mé poznámky z 1. semestru na MFFUK na oboru informatika. Rozhodně však nejsou kompletním přehledem učiva.
                        </p>
                        <br/>
                        <ul>
                            <li><a target="_blank" href="https://1drv.ms/w/s!AtwQciT4dmsCtpsa8nDF0GEdbMuzzw?e=cORMyf">Algoritmizace</a></li>
                            <li><a target="_blank" href="https://1drv.ms/w/s!AtwQciT4dmsCtpsb2ES8oNeALVgaRw?e=FipwYB">Diskrétní matematika (pojmy)</a></li>
                            <li><a target="_blank" href="https://1drv.ms/w/s!AtwQciT4dmsCtpscf6oKiL_gRGvXOA?e=ufEsg1">Lienární algebra (pojmy)</a></li>
                            <li><a target="_blank" href="https://1drv.ms/w/s!AtwQciT4dmsCtpsd9kVDV0JjR110_Q?e=JBd5gt">Principy počítačů</a></li>
                            <li><a target="_blank" href="https://1drv.ms/w/s!AtwQciT4dmsCtpxenbPuUmK0gOGQIQ?e=GN5AQy">Principy počítačů (zápisky z hodin)</a></li>
                            <li><a target="_blank" href="https://1drv.ms/w/s!AtwQciT4dmsCtpsf4LN0n1FtYwE7ag?e=4ckglB">Úvod do počítačových sítí</a></li>
                            <li><a target="_blank" href="https://1drv.ms/w/s!AtwQciT4dmsCtpseXnsFyiqZQgXWaA?e=7ICZja">Úvod do počítačových sítí (zpracované otázky)</a></li>
                        </ul>
                    </section>
                    <hr class="section-divider"/>
                    <section>
                        <h3>
                            Zdrojové kódy
                        </h3>
                        <p>
                           Zdrojové kódy ze cvičení z Programování I v Pythonu.
                        </p>
                        <br/>
                        <ul>
                            <li><a target="_blank" href="https://1drv.ms/u/s!AtwQciT4dmsCtptBGYXVYP_7Lf_TJw?e=QFAOGE">Projekt pro MS Visual studio</a></li>
                        </ul>
                    </section>
                    <footer>
                        
                    </footer>
                </article>
            </div>
            <div id="projects" class="content-page">
                <div class="main-content-header">
                    <h2>Projekty</h2>
                    <p>
                    </p>
                </div>
                <article>
                    <header>
                        <h2>GraphIt</h2>
                    </header>
                    <section>
                        <h3>
                            Popis
                        </h3>
                        <p>
                            Knihovna v Pythonu pro práci s grafy (množina vrcholů a hran, viz <a href="https://en.wikipedia.org/wiki/Graph_theory">Wikipedia</a>).
                        </p>
                    </section>
                    <section>
                        <h3>
                            Funkce
                        </h3>
                        <ul>
                            <li>Dijkstrův algoritmus</li>
                            <li>Kruskalův algoritmus</li>
                            <li>Lagrangeova interpolace</li>
                            <li>Bellovo číslo (počet rozkladů množiny)</li>
                        </ul>
                    </section>
                    <section>
                        <h3>
                            Odkazy
                        </h3>
                        <ul>
                            <li><a target="_blank" href="https://github.com/davidzemancz/GraphIt">GitHub</a></li>
                            <li><a target="_blank" href="https://github.com/davidzemancz/GraphIt/blob/master/GraphIt/Docs/GraphIt-cs.docx">Dokumentace</a></li>
                        </ul>
                    </section>
                    <footer>
                        
                    </footer>
                </article>
                <article>
                    <header>
                        <h2>PythonAI</h2>
                    </header>
                    <section>
                        <h3>
                            Popis
                        </h3>
                        <p>
                            Testování AI v Pythonu. Napojení na kryptoměnovou burzu Binance prostřednictvím knihovny <a href="https://github.com/sammchardy/python-binance">python-binance</a>.
                        </p>
                    </section>
                    <section>
                        <h3>
                            Odkazy
                        </h3>
                        <ul>
                            <li><a target="_blank" href="https://github.com/davidzemancz/PythonAI">GitHub</a></li>
                            <li><a target="_blank" href="https://www.youtube.com/playlist?list=PLQVvvaa0QuDcjD5BAw2DxE6OF2tius3V3">Tutoriály</a></li>
                            <li><a target="_blank" href="https://www.youtube.com/watch?v=aircAruvnKk&list=PLZHQObOWTQDNU6R1_67000Dx_ZCJB-3pi">3Blue1Brown</a></li>
                        </ul>
                    </section>
                    <footer>
                        
                    </footer>
                </article>
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
                                    <li>Vývojář (C#, Python, ReactJS, Caché)</li>
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
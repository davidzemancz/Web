<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
}
require_once("config.php");
 
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if ($_POST["action"] == "update"){
        $sql = "UPDATE articles
        SET Title='" . $_POST["title"] . "', Content='" . $_POST["content"] . "', Page='" . $_POST["page"] . "'
        WHERE Id = ". $_POST["id"];
    }
    else if($_POST["action"] == "add"){
        $sql = "INSERT INTO articles (Title, Content, Page)
        VALUES ('Nový příspěvek', '','home')";
    }
    else if($_POST["action"] == "delete"){
        $sql = "DELETE FROM articles WHERE Id = " . $_POST["id"];
    }

    if ($mysqli->query($sql) === TRUE) {
    } 
    else {
        echo "<script type='text/javascript'>alert('Během ukládání nastala chyba');</script>";
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
        <link rel="stylesheet" href="styles/admin.css"/>

        <script>
            function add_card() {
                var formData = new FormData(); 
                formData.append("action","add")

                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open("post", "admin.php"); 
                xmlHttp.send(formData); 
                location.reload();
            }
            function delete_card(id) {
                if(!confirm("Opravdu chcete odstranit vybranou kartu?")) return;

                var formData = new FormData(); 
                formData.append("action","delete")
                formData.append("id",id)

                var xmlHttp = new XMLHttpRequest();
                xmlHttp.open("post", "admin.php"); 
                xmlHttp.send(formData); 
                location.reload();
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
                return ["cards"]
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
                   <span id="menu-cards" onclick="on_menu_item_click('cards')">Karty</span>
               </div> 
               <hr class="main-menu-divider"/>
               <div class="main-menu-item bottom">
                    <a href="logout.php">Odhlásit se</a>
               </div>
           </div>
        </div> 
        <div class="main-content">
            <div id="cards" class="content-page">
                <div class="main-content-header">
                    <h2>Karty</h2>
                    <p>
                    </p>
                </div>
                <div class="cards-list">
                <div class="cards-toolbar">
                    <ul>
                        <li onclick="location.reload()">Aktualizovat</li>    
                        <li onclick="add_card()">Přidat</li>
                    </ul>
                </div>
                <?php
                    require_once("config.php");

                    $sql = "SELECT Id, Title, Content, Page FROM articles ORDER BY Id DESC";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            // echo "id: " . $row["Id"]. " - Name: " . $row["Title"]. " " . $row["Content"]. "<br>";
                            echo '<div class="card"> <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post">';
                            echo '<input type="hidden" name="id" value="'. $row["Id"] . '" />';
                            echo '<div class="form-group">';
                            echo '<label for="page">Stránka:</label><br/>';
                            echo '<select name="page"/>';
                            echo '<option value="home" '. ($row["Page"] == "home" ?  "selected" : "") .'>Příspěvky</option>';
                            echo '<option value="projects"'. ($row["Page"] == "projects" ?  "selected" : "") .'>Projekty</option>';
                            echo '<option value="mffuk"'. ($row["Page"] == "mffuk" ?  "selected" : "") .'>MFFUK</option>';
                            echo '</select>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<input type="hidden" name="action" value="update" />';
                            echo '<label for="title">Titulek:</label><br/>';
                            echo '<input type="text" name="title" value="' . $row["Title"] . '">';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="content">Obsah:</label><br/>';
                            echo '<textarea name="content">' . $row["Content"] . '</textarea>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<input type="submit" value="Uložit">';
                            echo '<button onclick="delete_card('.$row["Id"].')">Odstranit</button>';
                            echo '</div>';
                            echo '</form> </div>';
                        }
                    } else {
                        echo "Žádné karty";
                    }
                    $mysqli->close();
                ?>  
                </div>
            </div>
        </div>
    </body>
</html>

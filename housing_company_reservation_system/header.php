<link rel="stylesheet" href="header.css">
</head>
<body>
<header>
    <div class="header-wrapper">
        <a href="?page=default"><img src="logo.png" alt="logo"></a>
        <div>
           <a href="?page=profile"> <button>Profiili</button></a>
           <?php
                if(isset($_SESSION['user_apartment'])){
                    echo "<a href='unset.php'> <button>Kirjaudu ulos</button></a>";
                }
           ?>
        </div>
    </div>

    <div class="header-buttons">
        <a href="?page=home"><button id="laundry-button">Home</button></a>
        <a href="?page=parking"><button id="parking-button">Parkkipaikat</button></a>
        <a href="?page=sauna"><button id="sauna-button">Sauna</button></a>
    </div>
</header>

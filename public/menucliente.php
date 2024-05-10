




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aerolinea Web</title>
    <link rel="stylesheet" href="styles/style.css"> 

    <link rel="stylesheet" type="text/css" href="styles/default.css" />
		<link rel="stylesheet" type="text/css" href="styles/component.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" href="styles/styleIndex.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
</head>
<div style="display: flex; align-items: center;margin-right: 10px;background-color:rgba(143, 188, 234, 1);">
    <img src="assets\logoavion.png" alt="Menu Icon" style="width:10%;height:10%;margin-left:10px;margin-top: 10px; margin-bottom: 20px;">
    <button id="showRight" style="margin-left:85%;"><img src="assets\home2.png" alt="Menu Icon" style="width:40px;height:50%;background-color:white;"></button>
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
			<h3 style="font-family: 'Inter', sans-serif;font-size:35px;color:white;" id="menuHeader">Menu</h3>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Perfil</a>
			<a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Vuelos</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Check-In</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Premios Millas</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Log out</a>
            
		</nav>
        
</div>

<body>
    

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script src="scripts/script.js"></script>
    <script src="scripts/classie.js"></script>

    <script src="scripts/classie.js"></script>
    <script>
        var 
            menuRight = document.getElementById('cbp-spmenu-s2'),
            showRight = document.getElementById('showRight'),
            menuHeader = document.getElementById('menuHeader'),
            body = document.body;
    
        showRight.onclick = function() {
            classie.toggle(this, 'active');
            classie.toggle(menuRight, 'cbp-spmenu-open');
            disableOther('showRight');
        };
    
        // Function to disable other elements
        function disableOther(button) {
            if (button !== 'showRight') {
                classie.toggle(showRight, 'disabled');
            }
        }
    
        // Add event listener to close menu when header is clicked
        menuHeader.addEventListener('click', function() {
            classie.remove(menuRight, 'cbp-spmenu-open');
            classie.remove(showRight, 'active');
        });
    
        // Add event listener to close menu when clicked outside of it
        document.addEventListener('click', function(event) {
            var isClickInside = menuRight.contains(event.target) || showRight.contains(event.target);
            if (!isClickInside) {
                classie.remove(menuRight, 'cbp-spmenu-open');
                classie.remove(showRight, 'active');
            }
        });
    </script>



















</body>

</html>
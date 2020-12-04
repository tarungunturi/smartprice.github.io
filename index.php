<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>SmartPrice</title>
        <link rel="shortcut icon"  href="images/logoicon.png" sizes="300x300">
	<link rel="stylesheet"  href="hw1.css">
       
    </head>
    <body>
       
        <div id ="bg" style="background-image: url('images/bg.jpg');">
	<header>
            <img id="pic" src="images/logoicon.png" align="left" width="60px" height="60px">

		<h1 id="logo">SmartPrice</h1>

		<p id="quote">-"Do Smartwork not Hardwork", SmartPrice for Smartwork.</p>
	</header>
	
	<section>
		<a href="">HOME</a>
                <a href="aboutsmartprice.html">About</a>
                <a href="about.html">Contact</a>
	</section>


            <div style="display: inline"class="box">
                
         <form action="final.php" method="get">  
             <input type="Text" name="searchdata" id="search_text" placeholder="search product" autocomplete="on">
              
                  <button  type="text" name="button1" value="button1" id="searchButton">search</button>
				  <script>
				  document.getElementById("searchButton").onclick=function(){
				  
                                 <a href="final.php">Result Page</a>;
                              };
                              
});
				 </script>
                                 
                                 
       </form>
    </div>
    
           
    <div class= last>
    	<h2>madeby @181b199 @181b227 @181b228</h2>
    </div>
        <?php
    
           

    
?>
            
          
    </body>
</html>

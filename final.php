<!DOCTYPE html>

<html>
    <head>
        <title>Smart Price</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
        <link rel="shortcut icon"  href="images/logoicon.png" sizes="300x300">
    </head>
    <body>
        
        <header class="w3-container w3-teal">
		 <h1>SmartPrice</h1>
		 </header>
		 <div class="w3-container" >

		<form class="w3-container w3-card-4" action="final.php" method="get" >
		</form>
        <div class="w3-row-padding w3-margin-top">
		<?php
        
		include 'simple_html_dom.php';
        ini_set("user_agent" , "Mozilla/3.0\r\nAccept: */*\r\nX-Padding: Foo");
        error_reporting(0);
        $search=$_GET['searchdata'];
        
        if(empty($search)===false){
        function string_replace($search,$to_be_inserted){
        $search_strings= str_replace(' ',$to_be_inserted, $search);
        return $search_strings;
        }
        $position='26';
		$amazon_position='26';    
        $flipkart_position='34';
        $paytm_mall_position='36';
        $tata_cliq_position='57';
        $happi_mobiles_position='51';
		
        function inserting_in_url($test_url,$search_strings,$position){
        $url = substr($test_url, 0, $position) . $search_strings . substr($test_url, $position);
        return $url;
        }
        
        $string_insert_with_plus=str_replace(" ", "+", "$search");
        $string_insert_with_20= str_replace(" ","%20", $search);
       
		
		//the url formed by these 3 lines are used if user enters a mobile name
        $search_strings= string_replace($search,'-');
        $test_url='https://www.91mobiles.com/-price-in-india?utm_source=SERP';
        $url= inserting_in_url($test_url, $search_strings, '26');
        
        //the url formed by these 3 lines are used if user enters a laptop name 
        $search_string= string_replace($search,'%20');
       $testurl1='https://www.91mobiles.com/laptopfinder.php?search=';
       $url1= inserting_in_url($testurl1, $search_string, '50');
       
       //the url formed by these 3 lines are used if user enters a TV name
       $testurl2='https://www.91mobiles.com/tv-finder.php?search=';
       $url3= inserting_in_url($testurl2, $search_string,'47');
       
        $amazon_url='https://www.amazon.in/s?k=&ref=nb_sb_noss_1';
        $flipkart_url='https://www.flipkart.com/search?q=';
        $paytm_mall_url='https://paytmmall.com/shop/search?q=%20';
        $tata_cliq_url='https://www.tatacliq.com/search/?searchCategory=all&text=%20';
        $happi_mobiles_url='https://www.happimobiles.com/mobiles/all?serach=&q=vivo+v20';
		
		function stringInsert($str,$insertstr,$pos)
               {
                  $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
                    return $str;
                }
		
		$amazon_finalurl= stringInsert($amazon_url,$string_insert_with_plus, $amazon_position) ;
        $flipkart_finalurl= stringInsert($flipkart_url,$string_insert_with_plus,$flipkart_position);
        $paytm_mall_final= stringInsert($paytm_mall_url,$string_insert_with_20, $paytm_mall_position);
        $tata_cliq_finalurl= stringInsert($tata_cliq_url,$string_insert_with_20, $tata_cliq_position);
        $happi_mobiles_finalurl= stringInsert($happi_mobiles_url, $string_insert_with_plus, $happi_mobiles_position);
		
		try{
        $web= file_get_contents($url);
        if($web===false){
            throw new Exception();
        }
       $pic= explode('<div class="image_pnl">', $web);
       $pic1= explode('</div>', $pic[1]);
       $pic2= explode('src="', $pic1[0]);
       
       $pic3= explode('"', $pic2[1]);
       $i='https:';
       $product_image=$i.$pic3[0];
       
       $web1= file_get_html($url);
       foreach ($web1->find('h1.h1_pro_head') as $titles){
           $product_name[]=$titles->plaintext;
       }
	   
	   echo '
         <br>
		<div class="w3-row" style="text-align:center">
		<div class="w3-col l2 w3-row-padding" >
		<div class="w3-card-2" style="color:teal;text-align:left;font-style:bold;">
		<br>
        <img style="display: block;margin-left: auto; margin-right: auto;width: 100%;" src='.$product_image.'>
        <br>
		<div class="w3-container">
		<h5>'.$product_name[0].'</h5>
		</div>
		</div>
		</div>
		</div> 
	  ';
	  
	  echo '
		<div class="w3-col l8" >
		<div class="w3-card-2">
		  <table class="w3-table w3-striped w3-bordered w3-card-4">
		  <thead>
		  <tr class="w3-blue">
			<th>Site Name</th>
			<th>Price</th>
			<th>Buy Here</th>
		  </tr>
		  </thead>
		  </div> 
		  </div> 
		';
       
       foreach ($web1->find('img.img_alt') as $img){
           $images[]=$img->alt;
           
       }
       $site_names=array_unique($images);
             
       foreach ($web1->find('span.prc') as $prc){
           $amount[]=$prc;
       }
       echo '<br>';
       
       foreach ($amount as $price){
           $prices[]=str_replace('(after PayTM cashback)', '', $price);   
       }
       
       
       for($i=0;$i<count($prices);$i++){
         
           If(strcasecmp('Amazon', $site_names[$i])===0){
           $website=$amazon_finalurl;
       }
       elseif(strcasecmp('Flipkart', $site_names[$i])===0){
           $website=$flipkart_finalurl;
       }
       elseif(strcasecmp('Paytm Mall', $site_names[$i])===0){
           $website=$paytm_mall_final;
       }
       elseif(strcasecmp('Tata CLiQ', $site_names[$i])===0){
           $website=$tata_cliq_finalurl;
       }
       elseif(strcasecmp('happimobiles', $site_names[$i])===0){
           $website=$happi_mobiles_finalurl;
       }
       elseif(strcasecmp('Samsung Shop', $site_names[$i])===0){
           $website='https://www.samsung.com/in/search/?searchvalue='.$string_insert_with_20;
       }
           echo '
		  <tr>
			<td>'.$site_names[$i].'</td>
			<td>'.$prices[$i].'</td>
			<td><a href='.$website.'>Buy</a></td>
		  </tr>
		  <br>
		  ';
       }
		   
       
       
       
       
       foreach ($web1->find('ul.specs_ul') as $tab){
           $product_details[]=$tab;
       }
      
       echo $product_details[0].'<br>';
       echo $product_details[1].'<br>';
       echo $product_details[2].'<br>';
        echo $product_details[3].'<br>';
        
       }
       
       
       
       
         catch (Exception $ex) {
             try{
      $web2= file_get_html($url1);
       foreach ($web2->find('a.hover_blue_link') as $link){
           
           if(stripos($link,$search)!==false){
               $i='https://www.91mobiles.com/';
               $url2=$i.$link->href;
               
               
               break;
           }
       } 
       if (empty($url2)){
       throw new Exception();
       
       }
        $web= file_get_contents($url2);
       $pic= explode('<div class="image_pnl">', $web);
       $pic1= explode('</div>', $pic[1]);
       $pic2= explode('src="', $pic1[0]);
       
       $pic3= explode('"', $pic2[1]);
       $i='https:';
       $product_image=$i.$pic3[0];
       
       $web1= file_get_html($url2);
       foreach ($web1->find('h1.h1_pro_head') as $titles){
           $product_name[]=$titles->plaintext;
       }
	   
	   echo '
         <br>
		<div class="w3-row" style="text-align:center">
		<div class="w3-col l2 w3-row-padding" >
		<div class="w3-card-2" style="left-margin:800px;color:teal;text-align:justify">
		
        <img style="display: block;margin-left: auto; margin-right: auto;width: 120%;" src='.$product_image.'>
        
		<div class="w3-container" style="left-margin:800%;">
		<h5>'.$product_name[0].'</h5>
		</div>
		</div>
		</div>
		</div> 
	  ';
	  
	  echo '
		<div class="w3-col l8" >
		<div class="w3-card-2">
		  <table class="w3-table w3-striped w3-bordered w3-card-4">
		  <thead>
		  <tr class="w3-blue">
			<th>Site Name</th>
			<th>Price</th>
			<th>Buy Here</th>
		  </tr>
		  </thead>
		  </div> 
		  </div> 
		';
      
       foreach ($web1->find('img.img_alt') as $img){
           $images[]=$img->alt;
           
       }
       $site_names=array_unique($images);
             
       foreach ($web1->find('span.prc') as $prc){
           $amount[]=$prc;
       }
       echo '<br>';
       
       foreach ($amount as $price){
           $prices[]=str_replace('(after PayTM cashback)', '', $price);
		   
       }
       
       
       for($i=0;$i<count($prices);$i++){
           If(strcasecmp('Amazon', $site_names[$i])===0){
           $website=$amazon_finalurl;
       }
       elseif(strcasecmp('Flipkart', $site_names[$i])===0){
           $website=$flipkart_finalurl;
       }
       elseif(strcasecmp('Paytm Mall', $site_names[$i])===0){
           $website=$paytm_mall_final;
       }
       elseif(strcasecmp('Tata CLiQ', $site_names[$i])===0){
           $website=$tata_cliq_finalurl;
       }
       elseif(strcasecmp('happimobiles', $site_names[$i])===0){
           $website=$happi_mobiles_finalurl;
       }
       elseif(strcasecmp('Samsung Shop', $site_names[$i])===0){
           $website='https://www.samsung.com/in/search/?searchvalue='.$string_insert_with_20;
       }
           echo '
		  <tr>
			<td>'.$site_names[$i].'</td>
			<td>'.$prices[$i].'</td>
			<td><a href='.$website.'>Buy</a></td>
		  </tr>
                  <br>
		  <br>
		  ';
       }
       
       
       
       foreach ($web1->find('ul.specs_ul') as $tab){
           $product_details[]=$tab;
       }
       echo '<br>';
       for($a=0;$a<count($product_details);$a++){
           echo $product_details[$a].'<br>';
       }
         }  
         
         
         
         
         
         
         
        catch (Exception $ex)   {
            try{
           $web3= file_get_html($url3);
       foreach ($web3->find('a.hover_blue_link') as $link){
           
           if(stripos($link,$search)!==false){
               $i='https://www.91mobiles.com/';
               $url4=$i.$link->href;
               
               
               break;
           }
       } if(empty($url4)){
       throw new Exception();
       }
        $web4= file_get_contents($url4);
       $pics= explode('<div class="image_pnl">', $web4);
       $pics1= explode('</div>', $pics[1]);
       $pics2= explode('src="', $pics1[0]);
       
       $pics3= explode('"', $pics2[1]);
       $it='https:';
       $product_image=$it.$pics3[0];
       
       $web5= file_get_html($url4);
       
       foreach ($web5->find('h1.h1_pro_head') as $titles){
           $product_name[]=$titles->innertext;
           
       }
       echo '
         <br>
		<div class="w3-row" style="text-align:center">
		<div class="w3-col l2 w3-row-padding" >
		<div class="w3-card-2" style="color:teal;text-align:justify">
		<br>
        <img style="display: block;margin-left: auto; margin-right: auto;width: 100%;" src='.$product_image.'>
        <br>
		<div class="w3-container">
		<h5>'.$product_name[0].'</h5>
		</div>
		</div>
		</div>
		</div> 
	  ';
	  
	  echo '
		<div class="w3-col l8" >
		<div class="w3-card-2">
		  <table class="w3-table w3-striped w3-bordered w3-card-4">
		  <thead>
		  <tr class="w3-blue">
			<th>Site Name</th>
			<th>Price</th>
			<th>Buy Here</th>
		  </tr>
		  </thead>
		  </div> 
		  </div> 
		';
       
       
       foreach ($web5->find('img.lazy.img_alt') as $img){
           $images[]=$img->alt;
           
       }
       $site_names=array_unique($images);
             
       foreach ($web5->find('span.prc') as $prc){
           $amount[]=$prc;
       }
       
       
       foreach ($amount as $price){
           $prices[]=str_replace('(after PayTM cashback)', '', $price);
       }
       for($i=0;$i<count($prices);$i++){
           If(strcasecmp('Amazon', $site_names[$i])===0){
           $website=$amazon_finalurl;
       }
       elseif(strcasecmp('Flipkart', $site_names[$i])===0){
           $website=$flipkart_finalurl;
       }
       elseif(strcasecmp('Paytm Mall', $site_names[$i])===0){
           $website=$paytm_mall_final;
       }
       elseif(strcasecmp('Tata CLiQ', $site_names[$i])===0){
           $website=$tata_cliq_finalurl;
       }
       elseif(strcasecmp('happimobiles', $site_names[$i])===0){
           $website=$happi_mobiles_finalurl;
       }
       elseif(strcasecmp('Samsung Shop', $site_names[$i])===0){
           $website='https://www.samsung.com/in/search/?searchvalue='.$string_insert_with_20;
       }
           echo '
		  <tr>
			<td>'.$site_names[$i].'</td>
			<td>'.$prices[$i].'</td>
			<td><a href='.$website.'>Buy</a></td>
		  </tr>
		  <br>
		  ';
       }
       
       
       foreach ($web5->find('ul.specs_ul') as $tab){
           $product_details[]=$tab;
       }
       
       for($a=0;$a<count($product_details);$a++){
           echo $product_details[$a].'<br>';
       }
            }  
        
 catch (Exception $ex){
                echo '<script>alert("please correct the input.")</script>';
 }}}
       }
 else {
    echo '<script>alert("Enter a valid input.")</script>';
 }
 
        ?>
		</div> 
      </div> 
        
    </body>
</html>

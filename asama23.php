<html>
<head>
<body>
<button style='position:relative; top:50px; left:-50px;' onclick="window.location.href='index.php'" type="button">AnaSayfa</button>
<form action="" method="post">


<font> 
            1.Site Url: 
        </font> 
<input type="text" name="url1">
<font> 
            2.Site Url: 
        </font>
		<input type="text" name="url2">
<input type="submit" name="gonder" value="İndexle"/>
</form>

<?php
if(isset($_POST['url1'])&&isset($_POST['url2'])){
	include "simple_html_dom.php";
	$url1=$_POST['url1'];
	$url2=$_POST['url2'];
	$veri1=file_get_contents($url1);
	$veri2=file_get_contents($url2);

$veri1=str_replace('Ü','ü',$veri1);
$veri1=str_replace('Ö','ö',$veri1);
$veri1=str_replace('Ç','ç',$veri1);
$veri1=str_replace('Ğ','ğ',$veri1);
$veri1=str_replace('İ','i',$veri1);
$veri1=str_replace('Ş','ş',$veri1);
$veri1=strtolower($veri1);

$veri2=str_replace('Ü','ü',$veri2);
$veri2=str_replace('Ö','ö',$veri2);
$veri2=str_replace('Ç','ç',$veri2);
$veri2=str_replace('Ğ','ğ',$veri2);
$veri2=str_replace('İ','i',$veri2);
$veri2=str_replace('Ş','ş',$veri2);
$veri2=strtolower($veri2);

$search = array('@<script[^>]*?>.*?</script>@si', 
'@<style[^>]*?>.*?</style>@siU',           
 '#\<(.*?)\>#','/-/','/ ile /','/ ve /','/ da /','/ de /','/ � /','/“/','/”/','/%/','/nbsp/','/\./'
);
$Rules = array ('@<script[^>]*?>.*?</script>@si',
                    '@<[\/\!]*?[^<>]*?>@si',
                    '@<style[^>]*?>.*?</style>@siU',
                    '#\<(.*?)\>#',
                    
                    
                    '@([\r\n])[\s]+@',
                    '@&(quot|#34);@i',
                    '@&(amp|#38);@i',
                    '@&(lt|#60);@i',
                    '@&(gt|#62);@i',
                    '@&(nbsp|#160);@i',
                    
                    '/“/','/”/','/%/',"/\"/",'/-/','/ ile /','/ ve /','/ da /','/ de /','/.com /','/ mi /','/ a /','/ the /','/ and /','/ on /','/ of /','/ in /','/ is /','/ this /','/ that /'
             ,'/ if /','/ will /','/ do /','/ what /','/ am /','/ are /','/ to /','/ for /'/*,'/0/','/1/','/2/','/3/','/4/','/5/','/6/','/7/','/8/','/9/'*/,'/\./'
             );
$dizi1=array_count_values(str_word_count(preg_replace($Rules, ' ', $veri1), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’0123456789'));
$dizi2=array_count_values(str_word_count(preg_replace($Rules, ' ', $veri2), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’0123456789'));
/*foreach($dizi1 as $kelime1=>$frekans1){
  if(!mb_detect_encoding($kelime1, 'UTF-8')){
    unset($kelime1);
    $dizi1=array_values($dizi1);
  }
}*/
function sorting($a,$b) 
{ 
    if ($a==$b) return 0; 
        return ($a<$b)?1:-1; 
} 
uasort($dizi1,"sorting"); 
$dizi1t5=array_slice($dizi1,0,10);
$i=1;
foreach($dizi1t5 as $kelime=>$frekans){
  if(!mb_detect_encoding($kelime, 'UTF-8')){
    unset($kelime);
    $dizi1t5=array_values($dizi1t5);
  }else{
    echo "<table style='
    color:red;
    position:relative;
    top:300px;
    left:550px;'><td>$i- $kelime</td> <td>   $frekans defa geçiyor.<br><td></table>";
  $i++;
}
}
$bulunan=array();
$count=0;
$j=0;
foreach($dizi1t5 as $kelime1=>$frekans1){
  foreach($dizi2 as $kelime2=>$frekans2){

	
	if($kelime1==$kelime2){
   
	$bulunan+=[$kelime2=>$frekans2];
	
	$count++;}
  }
  
  $j++;
}


$skor=1;
foreach($bulunan as $kelimebul=>$frekansbul){
         $skor *=$frekansbul;    
}
$skor=$skor/count(str_word_count(preg_replace($search, ' ', $veri2), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’0123456789'));
echo "<text style='
	color:red;
	position:relative;
	top:400px;
	left:710px;'>Skor = $skor   </text>";
$i=1;
foreach($bulunan as $kelime=>$frekans){
	
/*	if($kelime=='/[^\00-\255]+/u'){
	  unset($dizi[current]);
	}*/
	echo "<table style='
	color:red;
	position:relative;
	top:20px;
	left:850px;'><td>$i- $kelime</td> <td>   $frekans defa geçiyor.<br><td></table>";
	$i++;
  }


}








?>









</body>
</head>


<style>
button{
         text-decoration: none;
         background-color: lightgrey;
         color: black;
         padding: 10px 20px;
         font-size: 14px;
		 margin-left: 100px;
		 margin-top: 0px;
		 position: relative;
		 top: 200px;
		 left: 500px;
    }
	font{size:10;
          face:verdana;
          color:red;           
        }
        
        
form{
         
	text-decoration: none;
         color: black;
         padding: 10px 20px;
         font-size: 14px;
		 margin-left: 100px;
		 margin-top: 0px;
		 position: relative;
		 top: 200px;
		 left: 400px;
    }

	
	body{background-image: url("bg.gif");
 background-color: #cccccc;
 height:900;
 width:1500}
	
</style>


</html>
	
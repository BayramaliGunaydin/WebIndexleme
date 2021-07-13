<html lang="tr">
<head>
<meta charset="utf-8">
</head>
<body>
<form action="" method="post">


<font> 
            Site Url: 
        </font> 
<input type="text" name="url">
<input type="submit" name="gonder" value="İndexle"/>
</form>

<?php  

if(isset($_POST['url'])){
include "simple_html_dom.php";

             $Rules = array (
            //  "/<script>.+?<\/script>/i",
              //'#<script(.*?)>(.*?)</script>#is',
             '@<script[^>]*?>.*?</script>@si',
             // '/<script\b[^>]*>(.*?)<\/script>/is',
              
              '@<[\/\!]*?[^<>]*?>@si',
              '@<style[^>]*?>.*?</style>@siU',
              '#\<(.*?)\>#',                   
              "/<img[^>]+\>/i",
              '~(?:\s*/\*.*?\*/\s*)|\{\K(?:\'[^\']*\'|"[^"]*"|/\*.*?\*/|(?:(?R)|[^}]))*~',   
              '@([\r\n])[\s]+@',
              '@&(quot|#34);@i',
              '@&(amp|#38);@i',
              '@&(lt|#60);@i',
              '@&(gt|#62);@i',
              '@&(nbsp|#160);@i',
            
             
             '/“/','/”/','/%/',"/\"/",'/ ile /','/ ve /','/ da /','/ de /','/.com /','/ mi /','/ a /','/ the /','/ and /','/ on /','/ of /','/ in /','/ is /','/ this /','/ that /'
             ,'/ if /','/ will /','/ do /','/ what /','/ am /','/ are /','/ to /','/ for /','/\./'/*,'/0/','/1/','/2/','/3/','/4/','/5/','/6/','/7/','/8/','/9/'*/ );          
       
$url=$_POST['url'];
$veri=file_get_contents($url);





$veri=str_replace('Ü','ü',$veri);
$veri=str_replace('Ö','ö',$veri);
$veri=str_replace('Ç','ç',$veri);
$veri=str_replace('Ğ','ğ',$veri);
$veri=str_replace('İ','i',$veri);
$veri=str_replace('Ş','ş',$veri);

$veri=strtolower($veri);

$search = array('@<script[^>]*?>.*?</script>@si',  
                       
           '@<style[^>]*?>.*?</style>@siU',   
           
           '#\<(.*?)\>#','/-/','/ ile /','/ ve /','/ veya /','/ da /','/ de /','/�/','/“/','/”/','/%/','/"/','/com/','/ mi /'  );     
           
$dizi=array_count_values(str_word_count(preg_replace($Rules,' ', $veri), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’0123456789'));

function sorting($a,$b) 
{ 
    if ($a==$b) return 0; 
        return ($a<$b)?1:-1; 
} 
uasort($dizi,"sorting"); 
$dizi5=$dizi;
$i=1;
foreach($dizi5 as $kelime=>$frekans){
  
  if(!mb_detect_encoding($kelime, 'UTF-8')){
    unset($kelime);
    $dizi5=array_values($dizi5);
  }else{
  echo "<table><td>$i- $kelime</td> <td>   $frekans defa geçiyor.<br><td></table>";
  $i++;
}
  
}
}

?>

</body>



<style>
font{size:20;
          face:verdana;
          color:red;   
          font-size:20px;        
        }
        table{
          position: relative;
          top:200px;
          left:800px;
          color:red;
          font-size:20px;
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
		 left: 600px;
    }
    button{
         text-decoration: none;
         color: black;
         padding: 10px 20px;
         font-size: 14px;
		 margin-left: 100px;
		 margin-top: 0px;
		 position: relative;
		 top: 145px;
		 left: 850px;
    }
    body{background-image: url("bg.gif");
 background-color: #cccccc;}
</style>

</html>
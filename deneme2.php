<html>
<head>
<body>

<?php
include "simple_html_dom.php";
$string = file_get_contents("http://reuters.zendesk.com/hc/en-us");
//$string ="what's";
$Rules = array (
    '@<script[^>]*?>.*?</script>@si',
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
                    
                 //  '/\'/','/“/','/”/','/%/','/"/','/-/','/ ile /','/ ve /','/ da /','/ de /','/com/','/ mi /'
             );
             $out=preg_replace('/&#x27;s/',' ',$string);
            // $out=str_replace('/^(\'(.*)\'|"(.*)")$/','$2$3',$string);
   $out=str_word_count(preg_replace($Rules,' ',$string),1,'&#x27;');
  // $out=str_word_count(str_replace("'","",$string),1,'');
  //$out=strip_tags(html_entity_decode($string));
   //print_r($out); 
   $link=explode("/","https://www.aljazeera.com/news/2021/3/29/canada-to-pause-use-of-astrazeneca-vaccine-for-those-under-55");
   echo $link[0]."//".$link[1]."".$link[2];
  // echo $string['SERVER_NAME'];        
function delete_all_between($beginning, $end, $string) {
  $beginningPos = strpos($string, $beginning);
  $endPos = strpos($string, $end);
  if (!$beginningPos || !$endPos) {
    return $string;
  }

  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

  return str_replace($textToDelete, '', $string);
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

	
	body{background-image: url("bg.gif");
 background-color: #cccccc;}
	
</style>


</html>
	
	
	
	


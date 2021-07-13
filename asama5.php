<html>
<head>
<body>


<form action="" method="post" style='font-size:16; position: relative; top:200px; left:400px;'>

<font> 
            Url: 
        </font> 
<input type="text" name="url1">
         <font> 
            Url Kümesi: 
        </font> 
<textarea action="" method="post" name="url">Url giriniz.</textarea>
<input style='font-size:16; position: relative; top:-10px; left:0px;' type="submit" name="gonder" value="İndexle"/>
</form>
<?php

function readStrLine($str, $n) {
    $lines = explode(PHP_EOL, $str);
    return $lines[$n-1];
}







function sorting($a,$b) 
{ 
    if ($a==$b) return 0; 
        return ($a<$b)?1:-1; 
} 
function isImage( $url )
  {
    $pos = strrpos( $url, ".");
    if ($pos === false)
      return false;
    $ext = strtolower(trim(substr( $url, $pos)));
    $imgExts = array(".gif", ".jpg", ".jpeg", ".png", ".tiff", ".tif",".css"); 
    if ( in_array($ext, $imgExts) )
      return true;
    return false;
  }
$Rules = array ('@<script[^>]*?>.*?</script>@si',
                    '@<[\/\!]*?[^<>]*?>@si',
                    '@<style[^>]*?>.*?</style>@siU',
                    '#\<(.*?)\>#',                   
                    "/<img[^>]+\>/i",
                  //  '~(?:\s*/\*.*?\*/\s*)|\{\K(?:\'[^\']*\'|"[^"]*"|/\*.*?\*/|(?:(?R)|[^}]))*~',   
                    '@([\r\n])[\s]+@',
                    '@&(quot|#34);@i',
                    '@&(amp|#38);@i',
                    '@&(lt|#60);@i',
                    '@&(gt|#62);@i',
                    '@&(nbsp|#160);@i',
                    
                    '/“/','/”/','/%/',"/\"/",'/-/','/ ile /','/ ve /','/ da /','/ de /','/.com /','/ mi /','/ a /','/ the /','/ and /','/ on /','/ of /','/ in /','/ is /','/ this /','/ that /'
             ,'/ if /','/ will /','/ do /','/ what /','/ am /','/ are /','/ to /','/ for /','/\./'/*,'/0/','/1/','/2/','/3/','/4/','/5/','/6/','/7/','/8/','/9/'*/
             );
if(isset($_POST['url'])){
 include "simple_html_dom.php";
$url1=$_POST['url1'];
$veri1=file_get_contents($url1);
$search = array('@<script[^>]*?>.*?</script>@si', 
           '@<style[^>]*?>.*?</style>@siU',           
            '#\<(.*?)\>#','/-/','/ ile /','/ ve /','/ da /','/ de /','/ � /','/\'/','/“/','/”/','/%/','/nbsp/','/\./'
);
$veri1=str_replace('Ü','ü',$veri1);
$veri1=str_replace('Ö','ö',$veri1);
$veri1=str_replace('Ç','ç',$veri1);
$veri1=str_replace('Ğ','ğ',$veri1);
$veri1=str_replace('İ','i',$veri1);
$veri1=str_replace('Ş','ş',$veri1);
$veri1=strtolower($veri1);
$dizi1=array_count_values(str_word_count(preg_replace($Rules, ' ', $veri1), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©123456789&#x27’'));
uasort($dizi1,"sorting"); 
$dizi1t5=array_slice($dizi1,0,5);
echo "<text style='color:red; position:relative; top:400px; font-size:26px;'>Ana url:".$url1."<br></text>";
echo "<text style='color:red; position:relative; top:400px; font-size:26px;'>Anahtar Kelime Sayıları:<br></text>";
foreach($dizi1t5 as $t5kelime=>$t5frekans){
    echo "<text style='color:white; position:relative; top:400px; font-size:26px;'>".$t5kelime."  ".$t5frekans." Defa Geçiyor.<br></text>";
}
$semantikt5=array("");
foreach($dizi1t5 as $semkelime=>$semfrekans){
    $file = file_get_contents("https://www.dersimiz.com/yakin-ve-es-anlamli-anlamdas-kelimeler-sozlugu.asp?q=".$semkelime);
//echo $semkelime."<br>";
$a= readStrLine($file,277);

if($a!=="<p class='box' style='background:#FFF65E'> <strong>".$semkelime."</strong> ile ilgili eş, yakın anlam bulunamadı...<br/> <b>* Türkçe olarak sadece aradığınız kelimeyi yazdığınızdan emin olun. <br/>* Üstte aradığınız kelime hatalıysa doğrusunu yazıp tekrar arayın.<br/ >* Bu sözlük eş, yakın anlamlılar sözlüğüdür, diğer sözlüklere ana sayfamızdan ulaşabilirsiniz.</b></p>"){


$b="Ulusal";
$a=strtolower($a);
$a=str_replace("</strong><br /></p>","",$a);
$a=str_replace("<p class='box' style='background:#fff65e'><img class='absmiddle' src='/img/redball.gif' alt='eş yakın anlam' /> aradığınız <strong><u>".$semkelime."</u></strong> kelimesinin eş ve yakın anlamlısı, anlamdaşı <strong>","",$a);
$a=preg_replace("/$semkelime/",'',$a);
$a=str_replace(",","",$a);
if(isset($semantikt5)){
    $sem=explode (" ",$a);
     $semantikt5=array_merge($semantikt5,$sem);
}
else{
   $semantikt5 = explode (" ",$a); 
}
}
}

//echo $dizi1t5[0];
$semantikt5=array_unique($semantikt5);
$semantikt5=array_values($semantikt5);
echo "<text style='color:red; position:relative; top:400px; font-size:26px;'>Semantik Anahtar Kelimeler:<br></text>";
foreach($semantikt5 as $semkelime){
  echo "<text style='color:white; position:relative; top:400px; font-size:26px;'>".$semkelime."<br></text>";
}

$url=$_POST['url'];
$url=preg_replace("/https:/"," https:",$url);
$url=preg_replace("/http:/"," http:",$url);
$pattern = '~[a-z]+://\S+~';
if($num_found = preg_match_all($pattern, $url, $out))
{
 // echo "FOUND ".$num_found." LINKS:\n";
 // print_r($out[0][0]);
}
$sayfalinkler;
foreach($out as $indeks=>$url){
    $sayfalinkler=$url;
}


$veriler=array();
$derinlik1;
$derinlik1kelimeler;
$derinlik1semantikkelimeler;
$derinlik2;
$derinlik2veriler;
$derinlik2kelimeler=array(array());
$derinlik2semantikkelimeler=array(array());
$derinlik3;
$derinlik3veriler=array();
$derinlik2link=array();
$derinlik3link=array();
$derinlik3kelimeler=array(array(array()));
$derinlik3semantikkelimeler=array(array(array()));
$derinlik1skor=array();
$derinlik2skor=array(array());
$derinlik3skor=array(array(array()));
$derinlik1semskor=array();
$derinlik2semskor=array(array());
$derinlik3semskor=array(array(array()));
$b=0;
$c=0;
$d=0;
$e=0;
$f=0;
$bos1=5;
$skor=1;
  for($b=0;$b<count($sayfalinkler);$b++){
      $diziderinlik1;
      $kesisim1=array();
      $semkesisim1=array();
    $e=0;
    $veriler[$b]=@file_get_contents($sayfalinkler[$b]);
    $veriler[$b]=preg_replace("/<link\b[^>]*>(.*?)>/is","",$veriler[$b]);   
    preg_match_all("/href=\"([^\"]+)/i",$veriler[$b],$derinlik2);  
 /*   foreach ($derinlik2[0] as $row) 
{   
    $row=str_replace('href="','',$row);
   if (0 === strpos($row, 'http://') || 0 === strpos($row, 'https://')) {
     if(!isImage($row)){
    $derinlik2link[$b][$e]=$row;
    $e++;
  }
 
    
}     
}  */ 
$parcala=explode("/",$sayfalinkler[$b]);
$domain=$parcala[0]."//".$parcala[1]."".$parcala[2];
foreach ($derinlik2[0] as $row) 
{   
$row=str_replace('href="','',$row);
if(!isImage($row)){
if ( 0 === strpos($row, 'http://')||0 === strpos($row, 'https://')) {
  $derinlik2link[$b][$e]=$row;}
  else{
   
    if(0 === strpos($row, '/www.')|| 0 === strpos($row, 'www.')|| 0 === strpos($row, '//www.')){
      if(0 === strpos($row, '/www.')){
       $row="https:/".$row;
      }
      if(0 === strpos($row, 'www.')){
       $row="https://".$row;
      }
      if(0 === strpos($row, '//www.')){
       $row="https:".$row;
      }
     $derinlik2link[$b][$e]=$row;}
     else{
  if ('/' === substr($row, 0,1) ) {
      $row=$domain."".$row;
      $derinlik2link[$b][$e]=$row;
  }
  else{
     $row=$sayfalinkler[$b]."".$row;
      $derinlik2link[$b][$e]=$row;
  }


}
  
}
$e++;  
}     
}       
    $derinlik2link[$b]=array_unique($derinlik2link[$b],SORT_STRING);
    $derinlik2link[$b]=array_values($derinlik2link[$b]);
    $derinlik2toplamveri="";
    $derinlik2kelimesayisi=0;
    for($c=0;$c<5;$c++){
      $diziderinlik2;
      $kesisim2=array();
      $semkesisim2=array();
      $f=0;
      $derinlik2veriler[$c]=@file_get_contents($derinlik2link[$b][$c]);
      $veriler[$b]=$veriler[$b]." ".$derinlik2veriler[$c];
      $derinlik2veriler[$c]=preg_replace("/<link\b[^>]*>(.*?)>/is","",$derinlik2veriler[$c]);     
      preg_match_all("/href=\"([^\"]+)/i",$derinlik2veriler[$c],$derinlik3);
   //   echo "derinlik2-".$derinlik2link[$b][$c]."<br>";
    /*  foreach ($derinlik3[0] as $row1) 
{   
    $row1=str_replace('href="','',$row1);
   if (0 === strpos($row1, 'http://') || 0 === strpos($row1, 'https://')) {
    if(!isImage($row1)){
    $derinlik3link[$b][$c][$f]=$row1;
    $f++;
  }
}        
  
  
    
    
}     
*/
foreach ($derinlik3[0] as $row1) 
{   
$row1=str_replace('href="','',$row1);
if(!isImage($row1)){
if ( 0 === strpos($row1, 'http://')||0 === strpos($row1, 'https://')) {
  $derinlik3link[$b][$c][$f]=$row1;}
  else{
   if(0 === strpos($row1, '/www.')|| 0 === strpos($row1, 'www.')|| 0 === strpos($row1, '//www.')){
     if(0 === strpos($row1, '/www.')){
      $row1="https:/".$row1;
     }
     if(0 === strpos($row1, 'www.')){
      $row1="https://".$row1;
     }
     if(0 === strpos($row1, '//www.')){
      $row1="https:".$row1;
     }
    $derinlik3link[$b][$c][$f]=$row1;}
     else{
  if ('/' === substr($row1, 0,1) ) {
      $row1=$domain."".$row1;
      $derinlik3link[$b][$c][$f]=$row1;
  }
  else{
     $row1=$sayfalinkler[$b]."".$row1;
     $derinlik3link[$b][$c][$f]=$row1;
  }


}
  
}
$f++;  
}     
} 
       $bos=10;
     //  $derinlik3link[$b][$c]=array_unique($derinlik3link[$b][$c],SORT_STRING);
      // $derinlik3link[$b][$c]=array_values($derinlik3link[$b][$c]);
       $derinlik3toplamveri="";
       $derinlik3kelimesayisi=0;
      for($d=0;$d<5;$d++){
      $diziderinlik3;
      $kesisim3=array();
      $semkesisim3=array();
      if(isset($derinlik3link[$b][$c][$d])){
    //   echo $derinlik3link[$b][$c][$d]."<br>";
       $derinlik3veriler[$d]=@file_get_contents($derinlik3link[$b][$c][$d]);
       
       $derinlik3veriler[$d]=str_replace('Ü','ü',$derinlik3veriler[$d]);
       $derinlik3veriler[$d]=str_replace('Ö','ö',$derinlik3veriler[$d]);
       $derinlik3veriler[$d]=str_replace('Ç','ç',$derinlik3veriler[$d]);
       $derinlik3veriler[$d]=str_replace('Ğ','ğ',$derinlik3veriler[$d]);
       $derinlik3veriler[$d]=str_replace('İ','i',$derinlik3veriler[$d]);
       $derinlik3veriler[$d]=str_replace('Ş','ş',$derinlik3veriler[$d]);
       $derinlik3veriler[$d]=strtolower($derinlik3veriler[$d]);

       $diziderinlik3=array_count_values(str_word_count(preg_replace($Rules, ' ', $derinlik3veriler[$d]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©.&#x27;.’'));
       $kel3=0;
       $semkel3=0;
       foreach($dizi1t5 as $kelimet5=>$frekanst5){
        // print_r($dizi1t5);
         foreach($diziderinlik3 as $kelimeder3=>$frekansder3){
         //  echo "asdasdads".$frekansder3;
         
           if($kelimet5==$kelimeder3){
            array_push($kesisim3,$frekansder3);
            $derinlik3kelimeler[$b][$c][$d][$kel3]=[$kelimeder3=>$frekansder3];
             
        //    echo $kelimeder3."---".$frekansder3."<br>";
            $kel3++;
           }
         }
       }
       
       
       foreach($semantikt5 as $semkelimet5){
        
         foreach($diziderinlik3 as $kelimeder3=>$frekansder3){
         
         
           if($semkelimet5==$kelimeder3){
            array_push($semkesisim3,$frekansder3);
            $derinlik3semantikkelimeler[$b][$c][$d][$semkel3]=[$kelimeder3=>$frekansder3];
        
            $semkel3++;
           }
         }
       } 
       
       $skor3=1;
       $semskor3=1;
       foreach($kesisim3 as $kesisim33){
    
        $skor3 *=$kesisim33; 
       }
       foreach($semkesisim3 as $semkesisim33){
        
            $semskor3 *=$semkesisim33; 
           }
      
       if(count(str_word_count(preg_replace($Rules, ' ', $derinlik3veriler[$d]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'))>0){
       $skor3=$skor3/count(str_word_count(preg_replace($Rules, ' ', $derinlik3veriler[$d]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'));
       $semskor3=$semskor3/count(str_word_count(preg_replace($Rules, ' ', $derinlik3veriler[$d]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'));
      }else{
        $skor3=0;
        $semskor3=0;
      }
       $derinlik3kelimesayisi+=count(str_word_count(preg_replace($Rules, ' ', $derinlik3veriler[$d]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'));
                               
    
       $derinlik3skor[$b][$c][$d]=$skor3+$semskor3;
       $derinlik3semskor[$b][$c][$d]=$semskor3;
    
       $derinlik3toplamveri=$derinlik3toplamveri.' '.$derinlik3veriler[$d];
       $veriler[$b]=$veriler[$b]." ".$derinlik3veriler[$d];
      }      
      
      }
      

      $derinlik3toplamveri=$derinlik3toplamveri.' '.@file_get_contents($derinlik2link[$b][$c]);
      $derinlik3toplamveri=str_replace('Ü','ü',$derinlik3toplamveri);
      $derinlik3toplamveri=str_replace('Ö','ö',$derinlik3toplamveri);
      $derinlik3toplamveri=str_replace('Ç','ç',$derinlik3toplamveri);
      $derinlik3toplamveri=str_replace('Ğ','ğ',$derinlik3toplamveri);
      $derinlik3toplamveri=str_replace('İ','i',$derinlik3toplamveri);
      $derinlik3toplamveri=str_replace('Ş','ş',$derinlik3toplamveri);
      $derinlik3toplamveri=strtolower($derinlik3toplamveri);
     
      $diziderinlik2=array_count_values(str_word_count(preg_replace($Rules, ' ', $derinlik3toplamveri), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'));
      
      $kel2=0;
      $semkel2=0;
      foreach($dizi1t5 as $kelimet5=>$frekanst5){
        
        
         foreach($diziderinlik2 as $kelimeder2=>$frekansder2){
         
         
           if($kelimet5==$kelimeder2){
            array_push($kesisim2,$frekansder2);
            $derinlik2kelimeler[$b][$c][$kel2]=[$kelimeder2=>$frekansder2];
            
            $kel2++;
           }
         }
       }
       
       foreach($semantikt5 as $semkelimet5){
       
         foreach($diziderinlik2 as $kelimeder2=>$frekansder2){
         
         
           if($semkelimet5==$kelimeder2){
            array_push($semkesisim2,$frekansder2);
            $derinlik2semantikkelimeler[$b][$c][$semkel2]=[$kelimeder2=>$frekansder2];
            
            $semkel2++;
           }
         }
       }  
       
       $skor2=1;
       $semskor2=1;
       foreach($kesisim2 as $kesisim23){
      
        $skor2 *=$kesisim23; 
       }
       foreach($semkesisim2 as $semkesisim23){
        
          $semskor2 *=$semkesisim23; 
         }
         if(count(str_word_count(preg_replace($Rules, ' ', $derinlik2veriler[$c]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'))>0){
       $skor2=$skor2/($derinlik3kelimesayisi+count(str_word_count(preg_replace($Rules, ' ', $derinlik2veriler[$c]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’')));
       $semskor2=$semskor2/($derinlik3kelimesayisi+count(str_word_count(preg_replace($Rules, ' ', $derinlik2veriler[$c]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’')));
      }else{
        $skor2=0;
        $semskor2=0;
      }
      
       $derinlik2kelimesayisi+=($derinlik3kelimesayisi+count(str_word_count(preg_replace($Rules, ' ', $derinlik2veriler[$c]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’')));
    
        $derinlik2skor[$b][$c]=$skor2+$semskor2;
        $derinlik2semskor[$b][$c]=$semskor2;

      $sıfırla=array(); 
     
      $derinlik2toplamveri=$derinlik2toplamveri.' '.$derinlik3toplamveri;
  }

  


$derinlik2toplamveri=$derinlik2toplamveri.' '.@file_get_contents($sayfalinkler[$b]);
$derinlik2toplamveri=str_replace('Ü','ü',$derinlik2toplamveri);
$derinlik2toplamveri=str_replace('Ö','ö',$derinlik2toplamveri);
$derinlik2toplamveri=str_replace('Ç','ç',$derinlik2toplamveri);
$derinlik2toplamveri=str_replace('Ğ','ğ',$derinlik2toplamveri);
$derinlik2toplamveri=str_replace('İ','i',$derinlik2toplamveri);
$derinlik2toplamveri=str_replace('Ş','ş',$derinlik2toplamveri);
$derinlik2toplamveri=strtolower($derinlik2toplamveri);
 
 $diziderinlik1=array_count_values(str_word_count(preg_replace($Rules, ' ', $derinlik2toplamveri), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'));

 $kel1=0;
 $semkel1=0;
 foreach($dizi1t5 as $kelimet5=>$frekanst5){
   
   
    foreach($diziderinlik1 as $kelimeder1=>$frekansder1){
    
    
      if($kelimet5==$kelimeder1){
       array_push($kesisim1,$frekansder1);
       $derinlik1kelimeler[$b][$kel1]=[$kelimeder1=>$frekansder1];
       
       $kel1++;
      }
    }
  } 
  foreach($semantikt5 as $semkelimet5){
    
    
     foreach($diziderinlik1 as $kelimeder1=>$frekansder1){
     
     
       if($semkelimet5==$kelimeder1){
        array_push($semkesisim1,$frekansder1);
        $derinlik1semantikkelimeler[$b][$semkel1]=[$kelimeder1=>$frekansder1];
        
        $semkel1++;
       }
     }
   }  
  $skor1=1;
  $semskor1=1;
  foreach($kesisim1 as $kesisim13){
  
   $skor1 *=$kesisim13; 
  }
  foreach($semkesisim1 as $semkesisim13){
    
     $semskor1 *=$semkesisim13; 
    }
    
    if(count(str_word_count(preg_replace($Rules, ' ', $veriler[$b]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'))>0){
  $skor1=$skor1/($derinlik2kelimesayisi+count(str_word_count(preg_replace($Rules, ' ', $veriler[$b]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’')));
  $semskor1=$semskor1/($derinlik2kelimesayisi+count(str_word_count(preg_replace($Rules, ' ', $veriler[$b]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’')));
}else{
  $semskor1=0;
  $skor1=0;
}
 
   $derinlik1skor[$b]=$skor1+$semskor1;
   $derinlik1semskor[$b]=$semskor1;




}    











$i=0;

$dizi=array();

$search = array('@<script[^>]*?>.*?</script>@si',  
                       
           '@<style[^>]*?>.*?</style>@siU',   
           
           '#\<(.*?)\>#','/-/','/ ile /','/ ve /','/ da /','/ de /','/ � /','/\'/','/“/','/”/','/%/','/\./'       
);
$yaz=array();

for($say=0;$say<count($sayfalinkler);$say++){
  $yaz[$say]=$sayfalinkler[$say]; 
  $dizi[$say]=array_count_values(str_word_count(preg_replace($search, ' ', $veriler[$say]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©&#x27;.’'));
 
}


arsort($derinlik1skor);
$sayac1=0;
$sayac2=0;
$sayac3=0;
if(isset($derinlik1skor)){
foreach($derinlik1skor as $site1=>$skor){
  echo "<text style='color:red; position:relative; top:400px; font-size:24px;'>-------------------------------------------------------------------------------------------<br></text>";

       echo "<text style='color:red; position:relative; top:400px; font-size:24px;'> Url:".$sayfalinkler[$site1]."---1.Derinlik<br></text>";
       echo "<text style='color:lightblue; position:relative; top:400px;font-size:20px;'> skor:".$derinlik1skor[$site1]."<br></text>";
       echo "<text style='color:lightblue; position:relative; top:400px;font-size:20px;'> Sematik skor:".$derinlik1semskor[$site1]."<br></text>";
       echo "<text style='color:red; position:relative; top:400px; font-size:20px;'> Anahtar Kelime Sayıları:<br></text>";
       for($sayac1=0;$sayac1<10;$sayac1++){
        if(isset($derinlik1kelimeler[$site1][$sayac1])){
      foreach($derinlik1kelimeler[$site1][$sayac1] as $kelimesite1=>$frekanssite1){
      
        echo "<text style='color:white;position:relative; top:400px; font-size:20px;'>".$kelimesite1."  ".$frekanssite1." Defa Geçiyor.<br></text>";
       
      }}     
    }
    echo "<text style='color:red; position:relative; top:400px; font-size:20px;'> Semantik Anahtar Kelime Sayıları:<br></text>";
    for($sayac1=0;$sayac1<10;$sayac1++){
      if(isset($derinlik1semantikkelimeler[$site1][$sayac1])){
        foreach($derinlik1semantikkelimeler[$site1][$sayac1] as $kelimesite1=>$frekanssite1){
        //  foreach($b as $kelimesite1=>$frekanssite1){
          echo "<text style='color:white;position:relative; top:400px; font-size:20px;'>".$kelimesite1."  ".$frekanssite1." Defa Geçiyor.<br></text>";
         // }
        }}}
        if(isset($derinlik2skor[$site1])){
    arsort($derinlik2skor[$site1]);
   // for($sayac2=0;$sayac2<5;$sayac2++){
    foreach($derinlik2skor[$site1] as $site2=>$skor2){
      echo "<text style='color:red; position:relative; top:400px; font-size:24px;'>**************************************************************<br></text>";
      echo "<text style='color:red; position:relative; top:400px; font-size:22px;'>Url:".$derinlik2link[$site1][$site2]."---2.Derinlik<br></text>";
      echo "<text style='color:lightblue; position:relative; top:400px; font-size:20px;'> skor:".$derinlik2skor[$site1][$site2]."<br></text>";
      echo "<text style='color:lightblue; position:relative; top:400px; font-size:20px;'> Sematik skor:".$derinlik2semskor[$site1][$site2]."<br></text>";
      echo "<text style='color:red; position:relative; top:400px; font-size:20px;'>Anahtar Kelime Sayıları:<br></text>";
      for($sayac1=0;$sayac1<10;$sayac1++){
        if(isset($derinlik2kelimeler[$site1][$site2][$sayac1])){
        foreach($derinlik2kelimeler[$site1][$site2][$sayac1] as $kelimesite1=>$frekanssite1){
        //  foreach($b as $kelimesite1=>$frekanssite1){
          echo "<text style='color:white; position:relative; top:400px; font-size:20px;'>".$kelimesite1."  ".$frekanssite1." Defa Geçiyor.<br></text>";
         // }
        }}
      }
      echo "<text style='color:red; position:relative; top:400px; font-size:20px;'> Semantik Anahtar Kelime Sayıları:<br></text>";
    for($sayac1=0;$sayac1<10;$sayac1++){
        if(isset($derinlik2semantikkelimeler[$site1][$site2][$sayac1])){
            foreach($derinlik2semantikkelimeler[$site1][$site2][$sayac1] as $kelimesite1=>$frekanssite1){
            //  foreach($b as $kelimesite1=>$frekanssite1){
              echo "<text style='color:white; position:relative; top:400px; font-size:20px;'>".$kelimesite1."  ".$frekanssite1." Defa Geçiyor.<br></text>";
             // }
        }}}
        if(isset($derinlik3skor[$site1][$site2])){
      arsort($derinlik3skor[$site1][$site2]);
      foreach($derinlik3skor[$site1][$site2] as $site3=>$skor3){
        echo "<text style='color:red; position:relative; top:400px; font-size:18px;'> Url:".$derinlik3link[$site1][$site2][$site3]."---3.Derinlik<br></text>";
        echo "<text style='color:lightblue; position:relative; top:400px; font-size:16px;'> skor:".$derinlik3skor[$site1][$site2][$site3]."<br></text>";
        echo "<text style='color:lightblue; position:relative; top:400px; font-size:16px;'> Sematik skor:".$derinlik3semskor[$site1][$site2][$site3]."<br></text>";
        echo "<text style='color:red; position:relative; top:400px; font-size:16px;'> Anahtar Kelime Sayıları:<br></text>";
        for($sayac1=0;$sayac1<10;$sayac1++){
          if(isset($derinlik3kelimeler[$site1][$site2][$site3][$sayac1])){
          foreach($derinlik3kelimeler[$site1][$site2][$site3][$sayac1] as $kelimesite1=>$frekanssite1){
          //  foreach($b as $kelimesite1=>$frekanssite1){
            echo "<text style='color:white; position:relative; top:400px; font-size:16px;'>".$kelimesite1."  ".$frekanssite1." Defa Geçiyor.<br></text>";
           // }
          }}
        }
          echo "<text style='color:red; position:relative; top:400px; font-size:20px;'> Semantik Anahtar Kelime Sayıları:<br></text>";
    for($sayac1=0;$sayac1<10;$sayac1++){
        if(isset($derinlik3semantikkelimeler[$site1][$site2][$site3][$sayac1])){
            foreach($derinlik3semantikkelimeler[$site1][$site2][$site3][$sayac1] as $kelimesite1=>$frekanssite1){
            //  foreach($b as $kelimesite1=>$frekanssite1){
              echo "<text style='color:white; position:relative; top:400px; font-size:16px;'>".$kelimesite1."  ".$frekanssite1." Defa Geçiyor.<br></text>";
             // }
        }}}


      }
    }



    }}
//  }
}
}










































/*$j=0;
$yatay=0;
$dikey=0;
$bulunan=array(array(array()));
$count=0;


foreach($dizi as $dizi1=>$ai){
  $bi=$dizi[0];
uasort($ai,"sorting"); 
$a5=array_slice($ai,0,5);
echo "<text style='color:red; font-size:20;'>".($j+1)." .Url: $yaz[$j]</text>";
echo "<br><br>";
$i=1;

for($k=0;$k<2;$k++){
$bi=$dizi[$k];
foreach($a5 as $kelime1=>$frekans1){
  
  if($ai==$bi&&$k!=1){
    $k++;
    $bi=$dizi[$k];   
  }
  if(is_array($bi)){
     foreach($bi as $kelime2=>$frekans2){
      if($kelime1==$kelime2){
       $bulunan[$j][$k][$count]=[$kelime2=>$frekans2];
      // $bulunan[$count][1]=[$frekans2];
       $count++; 
      }
    
     }}
     
}
$count=0;
//print_r($bulunan[$j][$k]);
$skor=1;
$countfre=0;
for($countfre=0;$countfre<count($bulunan[$j][$k]);$countfre++){
foreach($bulunan[$j][$k][$countfre] as $kelime=>$frekans){
         $skor =$skor*$frekans;            
}}
$skor=$skor/count(str_word_count(preg_replace($search, ' ', $veriler[$k]), 1,'ÇçİĞğÜüÖöŞşıîâûÎÂÛêÊø°²%©'));
//echo ($j+1).".url ve ".($k+1).".url benzerlik skoru:".$skor;
echo "<text style='
	color:red;
	'>".($j+1)." .url ve ".($k+1)." .url benzerlik skoru:$skor</text>";
echo "<br><br>";
}

foreach($a5 as $kelime=>$frekans){
  if($kelime=='/[^\00-\255]+/u'){
    unset($dizi1[current]);
  }
  
  echo "<div style='color:red;margin:10;float:left position:relative;left:$yatay'px; top:$dikey'px'; ><li> $kelime    $frekans defa geçiyor</li></div>";
  
  $i++;
  
}

echo "<br><br>";
$yatay +=200;
$dikey=-700;
//echo "<div style='float:right;position: absolute; left:200px; top:200px color:red;'></div>";
$j++;


}*/

//print_r($dizi[0]);


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
font{
    font-size:24px;
    color:red;

}
	
	body{background-image: url("bg.gif");
 background-color: #cccccc;}
	
</style>


</html>
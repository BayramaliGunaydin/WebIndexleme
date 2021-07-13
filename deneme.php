<html>
<head>
<body>


<?php

include "simple_html_dom.php";
/*$url=file_get_html("http://www.kocaeli.edu.tr/");
$url=preg_replace("/https:/"," https:",$url);
$pattern = '~[a-z]+://\S+~';
if($num_found = preg_match_all($pattern, $url, $out))
{
  //echo "FOUND ".$num_found." LINKS:\n";
 // print_r($out[0][0]);
}
$urldizi;

foreach($out as $indeks=>$url){
    $urldizi=$url;
}
print_r($urldizi);*/

$a="http://www.kocaeli.edu.tr/";
$sayfalinkler=array(
  "http://www.kocaeli.edu.tr/",
  "https://www.haberturk.com/",
  "https://www.yesilzeytin.net/"
);
$veriler=array();
$derinlik1;
$derinlik2;
$derinlik2veriler;
$derinlik3;
$derinlik2link=array();
$derinlik3link=array();
$b=0;
$c=0;
$d=0;
$e=0;
$f=0;
$bos1=5;
  for($b=0;$b<count($sayfalinkler);$b++){
    $e=0;
    $veriler[$b]=@file_get_contents($sayfalinkler[$b]);
    $as=array(
      "/href=\"([^\"]+)/i",
      '/href=\"([^\"]+)/i'
    );
    //$veriler[$b]=preg_replace("href='","href=\"",$veriler[$b]);
    
    preg_match_all("/href=\"([^\"]+)/i",$veriler[$b],$derinlik2);

    echo "derinlik1<br>";   
    foreach ($derinlik2[0] as $row) 
{   
    $row=str_replace('href="','',$row);
   if (0 === strpos($row, 'http://') || 0 === strpos($row, 'https://')) {
    $derinlik2link[$e]=$row;
    echo $derinlik2link[$e]."--- <br>";
    $e++;
}     
}     
    // print_r($derinlik2link);
    $derinlik2link=array_unique($derinlik2link,SORT_STRING);
    $derinlik2link=array_values($derinlik2link);
    for($c=0;$c<5;$c++){
      $f=0;
      $derinlik2veriler[$c]=@file_get_contents($derinlik2link[$c]);
      $veriler[$b]=$veriler[$b]."".$derinlik2veriler[$c];
     // $derinlik2veriler[$c]=preg_replace("/'/","/\"/",$derinlik2veriler[$c]);
     // echo $derinlik2veriler[$c];
      preg_match_all("/href=\"([^\"]+)/i",$derinlik2veriler[$c],$derinlik3);
      echo "derinlik2-".$derinlik2link[$c]."<br>";
      foreach ($derinlik3[0] as $row1) 
{   
 // echo "asdadssad".$row1."<br>";
    $row1=str_replace('href="','',$row1);
   if (0 === strpos($row1, 'http://') || 0 === strpos($row1, 'https://')) {
  // $row1=$derinlik2link[$c]."".$row1;
    $derinlik3link[$f]=$row1;
    $f++;
}        
  
   
  //  echo $derinlik3link[$f] ."<br>";
    
    
}      
       $bos=10;
       $derinlik3link=array_unique($derinlik3link,SORT_STRING);
       $derinlik3link=array_values($derinlik3link);
      for($d=0;$d<5;$d++){
       // echo "---".$derinlik2link[$c]."--".$c."<br>";      
       //  
     /*  if (0 !== strpos($derinlik3link[$d], 'http://') && 0 !== strpos($derinlik3link[$d], 'https://')) {
        $derinlik3link[$d]=$derinlik2link[$c]."".$derinlik3link[$d];
       // echo $derinlik2link[$c]."".$derinlik3link[$d]."<br";
     } */
      
      if(isset($derinlik3link[$d])){
       echo $derinlik3link[$d]."<br>";
       $veriler[$b]=$veriler[$b]."".@file_get_contents($derinlik3link[$d]);
      }      
      /*  if(array_unique($derinlik3link,SORT_STRING)!==$derinlik3link){
        $le=count($derinlik3link);
       $derinlik3link=array_unique($derinlik3link,SORT_STRING);
       echo "fark:".$le."<br>";
       $bos=$bos+$le;
       echo "--".$bos;
        }*/
      }
      $sıfırla=array(); 
      $derinlik3link=$sıfırla;
  }


 // echo $sayfalinkler[$b]."---".$veriler[$b];
  }    
/*foreach ($link[0] as $row) 
{   
  $row=str_replace('href="','',$row);
if (0 !== strpos($row, 'http://') && 0 !== strpos($row, 'https://')) {
   $row = $a."".$row;   
}   
    
    echo $row ."<br>";
}
$url = "blahblah.com";*/
// to clarify, this shouldn't be === false, but rather !== 0


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

	
	body{
 background-color: white;}
	
</style>


</html>
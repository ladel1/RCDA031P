<?php 

namespace App\Service;

class Censurator{


    public function purify(string $text){
        $badwords = ["con","idiot"];

        return str_ireplace($badwords,"****",$text);
    }

    public function purify2(string $text){
        $badwords = ["","con","idiot"];
        $cleanText = array();
       
        foreach (explode(' ',$text) as $word) {
            if(array_search(strtolower($word), $badwords)){
                array_push($cleanText,str_repeat("*",strlen($word)));
            }else{
                array_push($cleanText,$word);
            }
        }
        
        return implode(' ',$cleanText);
    }


}
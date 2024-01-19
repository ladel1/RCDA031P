<?php 

namespace App\Service;

class Censurator {

    public function purify(String $text):string{
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
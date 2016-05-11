<?php

namespace Soul\Util;

/**
 * Description of String
 *
 * @author Alisson Chiquitto <chiquitto@chiquitto.com.br>
 */
class String {

    public static function randomString($length = 10, $characters = null) {
        if ($characters === null) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }
    
    public static function removeAcentos($string) {
        // http://www.vivaolinux.com.br/script/Funcao-Retira-Acentos-php
        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
        return str_replace($array1, $array2, $string);
    }
    
    public static function strToPermalink($string) {
        $string = trim($string);
        $string = self::removeAcentos($string);
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9_ \-]/', '', $string);
        $string = preg_replace('/[\-_ ]+/', '-', $string);
        return $string;
    }


}

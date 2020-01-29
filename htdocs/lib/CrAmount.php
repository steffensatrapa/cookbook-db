<?php

class CrAmount {

    private function parseFraction($fraction) {
        if (preg_match('#(\d+)\s+(\d+)/(\d+)#', $fraction, $m)) {
            return ($m[1] + $m[2] / $m[3]);
        } else if (preg_match('#(\d+)/(\d+)#', $fraction, $m)) {
            return ($m[1] / $m[2]);
        }
        //return (float) 0;
        return $fraction;
    }

    private function replaceCharacters($str) {
        $str = str_replace(",", ".", $str);
        $str = str_replace("½", "1/2", $str);
        $str = str_replace("¼", "1/4", $str);
        $str = str_replace("¾", "3/4", $str);

        return $str;
    }

    public static function normalizeAmount($str) {
        $str = CrAmount::replaceCharacters($str);
        $str = CrAmount::parseFraction($str);
        return $str;
    }

    public static function isAmount($str) {
        $str = CrAmount::normalizeAmount($str);
        return is_numeric($str);
    }

}

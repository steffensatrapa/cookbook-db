<?php

class CrUnit {

    const alias = array(
        array("liter", "l"),
        array("milliliter", "ml"),
        array("kilogramm", "kg"),
        array("kilo", "kg"),
        array("gramm", "g"),
        array("milligramm", "mg"),
        array("milligramm", "mg"),
        array("teelöffel", "TL"),
        array("esslöffel", "EL"),
        array("päckchen", "Pck.")
    );
    const units = array(
        "l",
        "ml",
        "mg",
        "g",
        "kg",
        "TL",
        "EL",
        "Bund",
        "Prise",
        "Pck."
    );

    private static function replaceAlias($str) {
        foreach (CrUnit::alias as $aliasDefinition) {
            $alias = $aliasDefinition[0];
            $replacement = $aliasDefinition[1];

            if (strtoupper(trim($str)) == strtoupper($alias)) {
                return $replacement;
            }
        }

        return $str;
    }

    private static function normalizeCasing($str) {
        foreach (CrUnit::units as $unit) {

            if (strtoupper($unit) == strtoupper($str)) {
                return $unit;
            }
        }

        return $str;
    }

    public static function normalizeUnit($str) {
        $str = CrUnit::replaceAlias($str);
        $str = CrUnit::normalizeCasing($str);
        return $str;
    }

    public static function isUnit($str) {
        return in_array(CrUnit::normalizeUnit($str), CrUnit::units);
    }

}

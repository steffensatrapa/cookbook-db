<?php

class CrHtmlTemplate {

    /**
     * 
     * @return Smarty
     */
    public static function getTemplate() {
        $htmlTemplate = new Smarty;

        // $htmlTemplate->setCompileDir(TbfConfig::$SmartyCompilePath);
        // $htmlTemplate->setCacheDir(TbfConfig::$SmartyCachePath);
        //$smarty->force_compile = true;
        $htmlTemplate->debugging = false;
        $htmlTemplate->caching = false;


        return $htmlTemplate;
    }

}

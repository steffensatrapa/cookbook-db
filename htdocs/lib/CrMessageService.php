<?php

class CrMessageService {

    public static function setError($message, $title = "") {
        $_SESSION['errorMessage'] = $message;
        $_SESSION['errorMessageHeader'] = $title;
    }

    public static function setWarning($message, $title = "") {
        $_SESSION['warningMessage'] = $message;
        $_SESSION['warningMessageHeader'] = $title;
    }

    public static function setSuccess($message, $title = "") {
        $_SESSION['successMessage'] = $message;
        $_SESSION['successMessageHeader'] = $title;
    }

    private static function clear() {
        $_SESSION['errorMessage'] = "";
        $_SESSION['errorMessageHeader'] = "";
        $_SESSION['warningMessage'] = "";
        $_SESSION['warningMessageHeader'] = "";
        $_SESSION['successMessage'] = "";
        $_SESSION['successMessageHeader'] = "";
    }

    /**
     * 
     * @param Smarty $htmlTemplate
     */
    public static function applyToTemplate($htmlTemplate) {

        $htmlTemplate->assign("errorMessage", $_SESSION['errorMessage']);
        $htmlTemplate->assign("errorMessageHeader", $_SESSION['errorMessageHeader']);
        $htmlTemplate->assign("warningMessage", $_SESSION['warningMessage']);
        $htmlTemplate->assign("warningMessageHeader", $_SESSION['warningMessageHeader']);
        $htmlTemplate->assign("successMessage", $_SESSION['successMessage']);
        $htmlTemplate->assign("successMessageHeader", $_SESSION['successMessageHeader']);

        CrMessageService::clear();
    }

}

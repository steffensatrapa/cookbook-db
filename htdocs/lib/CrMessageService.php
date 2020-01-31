<?php

class CrMessageService {

    public static function setError($message, $params = array()) {
        $_SESSION['displayMessageType'] = "error";
        $_SESSION['displayMessage'] = $message;
        $_SESSION['displayMessageParams'] = $params;
    }

    public static function setWarning($message, $params = array()) {
        $_SESSION['displayMessageType'] = "warning";
        $_SESSION['displayMessage'] = $message;
        $_SESSION['displayMessageParams'] = $params;
    }

    public static function setSuccess($message, $params = array()) {
        $_SESSION['displayMessageType'] = "success";
        $_SESSION['displayMessage'] = $message;
        $_SESSION['displayMessageParams'] = $params;
    }

    private static function clear() {
        $_SESSION['displayMessageType'] = "";
        $_SESSION['displayMessage'] = "";
        $_SESSION['displayMessageParams'] = array();
    }

    /**
     * 
     * @param Smarty $htmlTemplate
     */
    public static function applyToTemplate($htmlTemplate) {

        $htmlTemplate->assign("displayMessageType", $_SESSION['displayMessageType']);
        $htmlTemplate->assign("displayMessage", $_SESSION['displayMessage']);

        if (isset($_SESSION['displayMessageParams']) && is_array($_SESSION['displayMessageParams'])) {
            foreach ($_SESSION['displayMessageParams'] as $param) {
                $htmlTemplate->assign($param["key"], $param["value"]);
            }
        }

        CrMessageService::clear();
    }

}

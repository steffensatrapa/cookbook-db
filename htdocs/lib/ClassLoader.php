<?php

require_once(dirname(__FILE__) . "/CrConfig.php");
require_once(dirname(__FILE__) . "/CrDatabase.php");
require_once(dirname(__FILE__) . "/CrRecipe.php");
require_once(dirname(__FILE__) . "/CrIngredient.php");
require_once(dirname(__FILE__) . "/CrUser.php");
require_once(dirname(__FILE__) . "/CrUnit.php");
require_once(dirname(__FILE__) . "/CrAmount.php");
require_once(dirname(__FILE__) . "/CrTag.php");
require_once(dirname(__FILE__) . "/CrLogger.php");
require_once(dirname(__FILE__) . "/CrHtmlTemplate.php");
require_once(dirname(__FILE__) . "/CrLoginService.php");
require_once(dirname(__FILE__) . "/CrMessageService.php");
require_once(dirname(__FILE__) . "/smarty/libs/Smarty.class.php");

session_start();

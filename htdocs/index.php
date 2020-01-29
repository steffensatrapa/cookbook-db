<?php

require_once(dirname(__FILE__) . "/lib/ClassLoader.php");

function displayTemplate($templateFile, $htmlTemplate) {
    CrMessageService::applyToTemplate($htmlTemplate);
    $htmlTemplate->display($templateFile);
    die;
}

/**
 * 
 * @return CrRecipe
 */
function getRecipe() {
    $recipeId = filter_input(INPUT_GET, "recipeId", FILTER_SANITIZE_NUMBER_INT);
    if (!$recipeId) {
        $recipeId = filter_input(INPUT_POST, "recipeId", FILTER_SANITIZE_NUMBER_INT);
    }

    $recipe = CrRecipe::loadFromDatabase($recipeId);
    if (!$recipe) {
        $recipe = new CrRecipe("", "", CrLoginService::getLoggedInUser());
    }

    return $recipe;
}

/**
 * 
 * @param CrRecipe $recipe
 * @param Smarty $htmlTemplate
 */
function ensureIsLoggedIn($recipe, $htmlTemplate) {
    if (!CrLoginService::getLoggedInUser()) {
        CrLogger::log("main", CrLogType::ERROR, "Not logged in for action. Recipe: '" . $recipe->getId() . "' (" . $recipe->getTitle() . ").");
        CrMessageService::setError("Für diese Aktion musst du eingeloggt sein. Bitte logge dich über das Menü ein, bevor zu fortfährst.", "Nicht eingeloggt!");
        displayDefaultTemplate($htmlTemplate);
    }
}

/**
 * 
 * @param CrRecipe $recipe
 * @param Smarty $htmlTemplate
 */
function ensureIsAllowedToEdit($recipe, $htmlTemplate) {
    ensureIsLoggedIn($recipe, $htmlTemplate);

    if (!CrLoginService::isAllowedToEdit($recipe->getCreatedBy())) {
        CrLogger::log("main", CrLogType::ERROR, "Not allowed to edit recipe: '" . $recipe->getId() . "' (" . $recipe->getTitle() . ").");
        CrMessageService::setError("Du hast keine Berechtigung um das Rezept <i>'" . $recipe->getTitle() . "'</i> von <i>" . $recipe->getCreatedBy()->getUserName() . "</i> zu editieren. Wende dich bitte an den Support.", "Keine Berechtigung!");
        displayDefaultTemplate($htmlTemplate);
    }
}

/**
 * 
 * @param CrRecipe $recipe
 * @param Smarty $htmlTemplate
 */
function ensureIsAllowedToDelete($recipe, $htmlTemplate) {
    ensureIsLoggedIn($recipe, $htmlTemplate);

    if (!CrLoginService::isAllowedToDelete($recipe->getCreatedBy())) {
        CrLogger::log("main", CrLogType::ERROR, "Not allowed to delete recipe: '" . $recipe->getId() . "' (" . $recipe->getTitle() . ").");
        CrMessageService::setError("Du hast keine Berechtigung um das Rezept <i>'" . $recipe->getTitle() . "'</i> von <i>" . $recipe->getCreatedBy()->getUserName() . "</i> zu löschen. Wende dich bitte an den Support.", "Keine Berechtigung!");
        displayDefaultTemplate($htmlTemplate);
    }
}

function displayDefaultTemplate($htmlTemplate) {
    $rows = CrDatabase::queryFetch("SELECT * FROM recipe where deletedAt is null");
    $recipes = CrRecipe::getObjectsFromDatabaseResult($rows);
    $htmlTemplate->assign("recipes", $recipes);
    displayTemplate("overview.tpl", $htmlTemplate);
}

function getAllTags() {
    $rows = CrDatabase::queryFetch("SELECT 
                                        tag.description, 
                                        count(tag.description) as count
                                    FROM tag 
                                    inner join recipe on recipe.id=tag.recipeId
                                    where recipe.deletedAt is null
                                    group by tag.description
                                    order by count(tag.description) desc, description", array());
    $tags = array();
    foreach ($rows as $tag) {
        array_push($tags, array('description' => htmlentities($tag['description']), 'count' => $tag['count']));
    }
    
    return $tags;
}

function processActionLogin($htmlTemplate) {
    $userName = filter_input(INPUT_POST, "userName");
    $password = filter_input(INPUT_POST, "password");

    if (!$userName) {
        // nothing posted. Display login page:
        displayTemplate("login.tpl", $htmlTemplate);
    } else if (CrLoginService::login($userName, $password)) {
        CrLogger::log("main", CrLogType::INFO, "Login with user '" . $userName . "'.");
        CrMessageService::setSuccess("Du hast dich erfolgreich als '" . htmlentities($userName) . "' angemeldet!", "Anmeldung erfolgreich!");
        header("Location: ?");
        die;
    } else {
        CrLogger::log("main", CrLogType::ERROR, "Login failed with user '" . $userName . "'.");
        CrMessageService::setError("Login mit '" . htmlentities($userName) . "' fehlgeschlagen!", "Anmeldung fehlgeschlagen!");
        header("Location: ?action=login");
        die;
    }
}

function processActionLogout($htmlTemplate) {
    CrLogger::log("main", CrLogType::INFO, "Logout.");
    CrLoginService::logout();
    CrMessageService::setSuccess("Du hast dich erfolgreich abgemeldet.", "Abmeldung erfolgreich!");
    header("Location: ?");
}

function processActionSave($htmlTemplate) {
    $recipe = getRecipe();

    ensureIsAllowedToEdit($recipe, $htmlTemplate);
    $recipeTitle = filter_input(INPUT_POST, "recipeTitle");
    $recipeIngredients = filter_input(INPUT_POST, "recipeIngredients");
    $recipeDescription = filter_input(INPUT_POST, "recipeDescription");
    $recipeTags = filter_input(INPUT_POST, "recipeTags");
    $doExit = filter_input(INPUT_POST, "doExit");

    $recipe->setTitle($recipeTitle);
    $recipe->setDescription($recipeDescription);
    $recipe->parseIngredients($recipeIngredients);
    $recipe->parseTags($recipeTags);
    $recipe->saveToDatabase(CrLoginService::getLoggedInUser());

    CrLogger::log("main", CrLogType::INFO, "Recipe '" . $recipe->getId() . "' (" . $recipe->getTitle() . ") saved.");
    CrMessageService::setSuccess("Rezept erfolgreich gespeichert.");

    if ($doExit) {
        header("Location: ?" . $recipe->getId());
        die;
    } else {
        header("Location: ?action=edit&recipeId=" . $recipe->getId());
        die;
    }
}

function processActionDelete($htmlTemplate) {
    $recipe = getRecipe();
    ensureIsAllowedToDelete($recipe, $htmlTemplate);

    $recipe->delete(CrLoginService::getLoggedInUser());

    CrLogger::log("main", CrLogType::INFO, "Recipe '" . $recipe->getId() . "' (" . $recipe->getTitle() . ") deleted.");
    CrMessageService::setSuccess("Rezept erfolgreich gelöscht.");

    header("Location: ?");
    die;
}

function processActionEdit($htmlTemplate) {
    $recipe = getRecipe();
    ensureIsAllowedToEdit($recipe, $htmlTemplate);
    $htmlTemplate->assign("recipe", $recipe);
    displayTemplate("edit.tpl", $htmlTemplate);
}

function processActionView($htmlTemplate) {
    $recipe = getRecipe();
    $htmlTemplate->assign("recipe", $recipe);
    displayTemplate("view.tpl", $htmlTemplate);
}

function processActionSearch($htmlTemplate) {
    $recipe = getRecipe();
    $keywords = filter_input(INPUT_GET, "keywords");
    if ($keywords) {
        CrLogger::log("main", CrLogType::INFO, "Searching for: '" . $keywords . "' ...");
        $rows = CrDatabase::queryFetch("SELECT DISTINCT recipe.*
                        FROM recipe
                        INNER JOIN ingredient on ingredient.recipeId = recipe.id
                        WHERE
                        (MATCH(recipe.title) AGAINST(:keyword IN Boolean MODE) * 3 +
                        MATCH(recipe.description) AGAINST(:keyword IN Boolean MODE) * 2 +
                        MATCH(ingredient.description) AGAINST(:keyword IN Boolean MODE)) >0
                        AND recipe.deletedAt is null
                        ORDER BY
                        (MATCH(recipe.title) AGAINST(:keyword IN Boolean MODE) * 3 +
                        MATCH(recipe.description) AGAINST(:keyword IN Boolean MODE) * 2 +
                        MATCH(ingredient.description) AGAINST(:keyword IN Boolean MODE)) DESC", array(
                    ':keyword' => $keywords . "*"));


        $recipes = CrRecipe::getObjectsFromDatabaseResult($rows);
        $htmlTemplate->assign("recipes", $recipes);
        $htmlTemplate->assign("keywords", htmlentities($keywords));
        displayTemplate("overview.tpl", $htmlTemplate);
    } else {
        displayDefaultTemplate($htmlTemplate);
    }
}

function processActionFilter($htmlTemplate) {
    $recipe = getRecipe();
    $tag = filter_input(INPUT_GET, "tag");
    if ($tag) {
        CrLogger::log("main", CrLogType::INFO, "Filter for tag: '" . $tag . "' ...");

        $rows = CrDatabase::queryFetch("SELECT distinct recipe.* FROM `tag`
                        inner join recipe on recipe.id = tag.recipeId
                        WHERE tag.description = :tag
                        AND deletedAt is null", array(
                    ':tag' => $tag));


        $recipes = CrRecipe::getObjectsFromDatabaseResult($rows);
        $htmlTemplate->assign("recipes", $recipes);
        $htmlTemplate->assign("filterTag", htmlentities($tag));
        displayTemplate("overview.tpl", $htmlTemplate);
    } else {
        displayDefaultTemplate($htmlTemplate);
    }
}

// -----------------------------------------------------------------------------

$action = filter_input(INPUT_POST, "action", FILTER_SANITIZE_STRING);
if (!$action) {
    $action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_STRING);
}

$htmlTemplate = CrHtmlTemplate::getTemplate();
$htmlTemplate->assign("loggedInUser", CrLoginService::getLoggedInUser());
$htmlTemplate->assign("action", $action);
$htmlTemplate->assign("allTags", getAllTags());

$logRecipe = getRecipe();
CrLogger::log("main", CrLogType::DEBUG, "Accessing site with action: '" . $action . "'. Recipe: '" . $logRecipe->getTitle() . "' [" . $logRecipe->getId() . "].");


if ($action == "login") {
    processActionLogin($htmlTemplate);
} else if ($action == "logout") {
    processActionLogout($htmlTemplate);
} else if ($action == "save") {
    processActionSave($htmlTemplate);
} else if ($action == "delete") {
    processActionDelete($htmlTemplate);
} else if ($action == "edit") {
    processActionEdit($htmlTemplate);
} else if ($action == "view") {
    processActionView($htmlTemplate);
} else if ($action == "search") {
    processActionSearch($htmlTemplate);
} else if ($action == "filter") {
    processActionFilter($htmlTemplate);
} else {
    displayDefaultTemplate($htmlTemplate);
}




{if $displayMessageType}

    {if $displayMessageType=="error"}
        {$alertClass="alert-danger"}
    {else if $displayMessageType=="warning"}
        {$alertClass="alert-warning"}
    {else}
        {$alertClass="alert-success"}
    {/if}

    <div class="alert {$alertClass}" role="alert">
        <h4 class="alert-heading">
            {if $displayMessage=="notLoggedIn"}
                {if $lang=="de"}
                    Nicht eingeloggt.
                {else}
                    Not logged in.
                {/if}
            {/if}

            {if $displayMessage=="notAllowedToEdit" || $displayMessage=="notAllowedToDelete"}
                {if $lang=="de"}
                    Keine Berechtigung!
                {else}
                    Access denied!
                {/if}
            {/if}

            {if $displayMessage=="errorLogin"}
                {if $lang=="de"}
                    Anmeldung fehlgeschlagen!
                {else}
                    Login failed!
                {/if}
            {/if}

            {if $displayMessage=="successLogin"}
                {if $lang=="de"}
                    Anmeldung erfolgreich!
                {else}
                    Login successful!
                {/if}
            {/if}

            {if $displayMessage=="successlogout"}
                {if $lang=="de"}
                    Abmeldung erfolgreich!
                {else}
                    Logout successful!
                {/if}
            {/if}

            {if $displayMessage=="successSave"}
                {if $lang=="de"}
                    Speichern erfolgreich!
                {else}
                    Saved
                {/if}
            {/if}

            {if $displayMessage=="errorLanguage"}
                {if $lang=="de"}
                    Fehler
                {else}
                    Error
                {/if}
            {/if}

            {if $displayMessage=="successLanguage"}
                {if $lang=="de"}
                    Erfolg
                {else}
                    Success
                {/if}
            {/if}

        </h4>

        <p>
            {if $displayMessage=="notLoggedIn"}
                {if $lang=="de"}
                    Für diese Aktion musst du eingeloggt sein. Bitte logge dich 
                    über das Menü ein, bevor zu fortfährst.
                {else}
                    You have to be logged in for this action. Please login via 
                    menu before proceeding.
                {/if}
            {/if}

            {if $displayMessage=="notAllowedToEdit"}
                {if $lang=="de"}
                    Du hast keine Berechtigung um das Rezept <i>{$notAllowedRecipeTitle}</i> 
                    von <i>{$notAllowedRecipeCreateBy}</i> zu editieren. 
                    Wende dich bitte an den Support.
                {else}
                    You don't have permissions to edit recipe <i>{$notAllowedRecipeTitle}</i> 
                    created by <i>{$notAllowedRecipeCreateBy}</i>.
                    Prease contact support.
                {/if}
            {/if}

            {if $displayMessage=="notAllowedToDelete"}
                {if $lang=="de"}
                    Du hast keine Berechtigung um das Rezept <i>{$notAllowedRecipeTitle}</i> 
                    von <i>{$notAllowedRecipeCreateBy}</i> zu löschen. 
                    Wende dich bitte an den Support.
                {else}
                    You don't have permissions to delete recipe <i>{$notAllowedRecipeTitle}</i> 
                    created by <i>{$notAllowedRecipeCreateBy}</i>.
                    Prease contact support.
                {/if}
            {/if}

            {if $displayMessage=="errorLogin"}
                {if $lang=="de"}
                    Anmeldung mit '{$errorLoginUser}' fehlgeschlagen!
                {else}
                    Login with '{$errorLoginUser}' failed!
                {/if}
            {/if}

            {if $displayMessage=="successLogin"}
                {if $lang=="de"}
                    Du hast dich erfolgreich als '{$successLoginUser}' angemeldet!
                {else}
                    Successfully logged in as '{$successLoginUser}'!
                {/if}
            {/if}

            {if $displayMessage=="successlogout"}
                {if $lang=="de"}
                    Du hast dich erfolgreich abgemeldet!
                {else}
                    Successfully logged out!
                {/if}
            {/if}

            {if $displayMessage=="successSave"}
                {if $lang=="de"}
                    Rezept '{$messageRecipeTitle}' erfolgreich gespeichert.
                {else}
                    Successfully saved recipe '{$messageRecipeTitle}'.
                {/if}
            {/if}

            {if $displayMessage=="successDelete"}
                {if $lang=="de"}
                    Rezept '{$messageRecipeTitle}' erfolgreich gelöscht.
                {else}
                    Successfully deleted recipe '{$messageRecipeTitle}'.
                {/if}
            {/if}

            {if $displayMessage=="errorLanguage"}
                {if $lang=="de"}
                    Sprache '{$messageLanguageLang}' nicht unterstützt.
                {else}
                    Language '{$messageLanguageLang}'not supported.
                {/if}
            {/if}

            {if $displayMessage=="successLanguage"}
                {if $lang=="de"}
                    Sprache '{$messageLanguageLang}' erfolgreich gesetzt.
                {else}
                    Successfully switched to language '{$messageLanguageLang}'.
                {/if}
            {/if}

        </p>
    </div>
{/if}
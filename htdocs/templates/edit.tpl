{include file="_header.tpl" title=">{if $lang=="de"}Bearbeiten{else}Edit{/if}: {$recipe->getTitle()} - "}

<h1>{if $lang=="de"}Bearbeiten{else}Edit{/if}</h1>

<form method="POST">  

    <div class="form-group">
        <label for="recipeTitle">{if $lang=="de"}Titel{else}Title{/if}:</label>
        <input type="text" class="form-control" id="recipeTitle" name="recipeTitle" value="{$recipe->getTitle()}">
    </div>

    <div class="form-group">
        <label for="recipeIngredients">{if $lang=="de"}Zutaten{else}Ingredients{/if}:</label>
        <textarea style="font-family:monospace;" class="form-control" id="recipeIngredients" name="recipeIngredients" rows="10">{$recipe->getIngredientsAsString()}</textarea>
    </div>

    <div class="form-group">
        <label for="recipeDescription">{if $lang=="de"}Beschreibung{else}Description{/if}:</label>
        <textarea style="font-family:monospace;" class="form-control" id="recipeDescription" name="recipeDescription" rows="10">{$recipe->getDescription()}</textarea>
    </div>


    <input type="hidden" name="recipeId" value="{$recipe->getId()}">
    <input type="hidden" name="action" value="save">

    <div class="form-group">
        <label for="recipeTags">{if $lang=="de"}Tags{else}Tags{/if}:</label>
        <input type="text" class="form-control" id="recipeTags" name="recipeTags" value="{$recipe->getTagsAsString()}">
    </div>

    <button type="submit" name="doExit" value="" class="btn btn-primary">{if $lang=="de"}Speichern{else}Save{/if}</button>
    <button type="submit" name="doExit" value="true" class="btn btn-secondary">{if $lang=="de"}Speichern und Schließen{else}Save and exit{/if}</button>

    <button type="submit" name="action" value="delete" class="btn btn-light float-right"
            onclick="return confirm(
            {if $lang=="de"}
                    'Bist du sicher, dass du das Rezept löschen möchtest?'
            {else}
                    'Are you sure you want to delete?'
            {/if}
    )">{if $lang=="de"}Löschen{else}Delete{/if}</button>

</form>

{include file="_footer.tpl"}
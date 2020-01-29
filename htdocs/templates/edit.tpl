{include file="_header.tpl" title="Editieren: {$recipe->getTitle()} - Satrapas Kochbuch"}

<h1>Editieren</h1>

<form method="POST">  

    <div class="form-group">
        <label for="recipeTitle">Titel:</label>
        <input type="text" class="form-control" id="recipeTitle" name="recipeTitle" value="{$recipe->getTitle()}">
    </div>

    <div class="form-group">
        <label for="recipeIngredients">Zutaten:</label>
        <textarea style="font-family:monospace;" class="form-control" id="recipeIngredients" name="recipeIngredients" rows="10">{$recipe->getIngredientsAsString()}</textarea>
    </div>

    <div class="form-group">
        <label for="recipeDescription">Beschreibung:</label>
        <textarea style="font-family:monospace;" class="form-control" id="recipeDescription" name="recipeDescription" rows="10">{$recipe->getDescription()}</textarea>
    </div>


    <input type="hidden" name="recipeId" value="{$recipe->getId()}">
    <input type="hidden" name="action" value="save">

    <div class="form-group">
        <label for="recipeTags">Tags:</label>
        <input type="text" class="form-control" id="recipeTags" name="recipeTags" value="{$recipe->getTagsAsString()}">
    </div>

    <button type="submit" name="doExit" value="" class="btn btn-primary">Speichern</button>
    <button type="submit" name="doExit" value="true" class="btn btn-secondary">Speichern und schließen</button>
    
    <button type="submit" name="action" value="delete" class="btn btn-light float-right"
            onclick="return confirm('Bist du sicher, dass du das Rezept löschen möchtest?')">Löschen</button>

</form>

{include file="_footer.tpl"}
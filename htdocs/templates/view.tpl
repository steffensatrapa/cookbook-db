{include file="_header.tpl" title="{$recipe->getTitle()} - Satrapas Kochbuch"}


<div>
    <h1 style="display: inline-block">
        {if $recipe->getTitle()}
            {$recipe->getTitle()}
        {else}
            [kein Titel]
        {/if}
    </h1>
    <span class="badge badge-light badge-pill" 
          style="vertical-align: top"
          data-toggle="tooltip" 
          title="Erstellt: {$recipe->getCreatedAt()|date_format:"%d.%m.%Y"} {if $recipe->getUpdatedBy()} Bearbeitet: {$recipe->getUpdatedAt()|date_format:"%d.%m.%Y"} von {$recipe->getUpdatedBy()->toHtmlString()}{/if}">{$recipe->getCreatedBy()->toHtmlString()}</span>
</div>

<h2>Zutaten</h2>
<p class="text-monospace pl-3">
    {$recipe->getIngredientsAsString("<br>", true)}
</p>
<h2>Zubereitung</h2>
<p class="text-monospace pl-3">
    {$recipe->getDescription("<br>")}
</p>

<h2>Tags</h2>
{foreach from=$recipe->getTags() item=tag}
    <a href="?action=filter&tag={$tag->getDescription()}">
        <button type="button" class="btn btn-outline-primary m-1">
            {$tag->getDescription()}
        </button>
    </a>
{/foreach}

{include file="_footer.tpl"}
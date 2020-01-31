{include file="_header.tpl" title="{$recipe->getTitle()} - "}

<div>
    <h1 style="display: inline-block">
        {if $recipe->getTitle()}
            {$recipe->getTitle()}
        {else}
            {if $lang=="de"}[kein Titel]{else}[no title]{/if}
        {/if}
    </h1>
    <span class="badge badge-light badge-pill" 
          style="vertical-align: top"
          data-toggle="tooltip" 
          title=
          {if $lang=="de"}
              "Erstellt: {$recipe->getCreatedAt()|date_format:"%d.%m.%Y"} {if $recipe->getUpdatedBy()} Bearbeitet: {$recipe->getUpdatedAt()|date_format:"%d.%m.%Y"} von {$recipe->getUpdatedBy()->toHtmlString()}{/if}"
          {else}
              "Created: {$recipe->getCreatedAt()|date_format:"%d.%m.%Y"} {if $recipe->getUpdatedBy()} modified: {$recipe->getUpdatedAt()|date_format:"%d.%m.%Y"} by {$recipe->getUpdatedBy()->toHtmlString()}{/if}"
          {/if}
          >{$recipe->getCreatedBy()->toHtmlString()}</span>
</div>

<h2>{if $lang=="de"}Zutaten{else}Ingredients{/if}</h2>
<p class="text-monospace pl-3">
    {$recipe->getIngredientsAsString("<br>", true)}
</p>
<h2>{if $lang=="de"}Zubereitung{else}Preparation{/if}</h2>
<p class="text-monospace pl-3">
    {$recipe->getDescription("<br>")}
</p>

<h2>{if $lang=="de"}Tags{else}Tags{/if}</h2>
{foreach from=$recipe->getTags() item=tag}
    <a href="?action=filter&tag={$tag->getDescription()}">
        <button type="button" class="btn btn-outline-primary m-1">
            {$tag->getDescription()}
        </button>
    </a>
{/foreach}

{include file="_footer.tpl"}
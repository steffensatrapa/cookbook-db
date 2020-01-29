{include file="_header.tpl" title="Satrapas Kochbuch"}
<h1>Übersicht</h1>
{if isset($keywords) && $keywords}
    <h2>Suche nach: {$keywords}</h2>
{/if}
{if isset($filterTag) && $filterTag}
    <h2>Filter nach: {$filterTag}</h2>
{/if}
<ul>
    {foreach from=$recipes item=recipe}
        <li>
            <a href="?action=view&recipeId={$recipe->getId()}">
                {if $recipe->getTitle()}
                    {$recipe->getTitle()}
                {else}
                    [kein Titel]
                {/if}
            </a> 
            {if CrLoginService::isAllowedToEdit($recipe->getCreatedBy())}
                <a href="?action=edit&recipeId={$recipe->getId()}">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
            {/if}

        </li>
    {/foreach}
</ul>
<h2>Tags</h2>

{foreach from=$allTags item=tag}
    <a href="?action=filter&tag={$tag.description}">
        <button type="button" class="btn btn-outline-primary  m-1">
            {$tag.description} <span class="badge badge-secondary">{$tag.count}</span>
        </button>
    </a>
{/foreach}

{include file="_footer.tpl"}
{include file="_header.tpl" title=""}
<h1>{if $lang=="de"}Übersicht{else}Overview{/if}</h1>

{if isset($keywords) && $keywords}
    <h2>{if $lang=="de"}Suche nach{else}Searching for{/if}: {$keywords}</h2>
{/if}

{if isset($filterTag) && $filterTag}
    <h2>{if $lang=="de"}Filter nach{else}Filter for{/if}: {$filterTag}</h2>
{/if}

<ul>
    {foreach from=$recipes item=recipe}
        <li>
            <a href="?action=view&recipeId={$recipe->getId()}">
                {if $recipe->getTitle()}
                    {$recipe->getTitle()}
                {else}
                    {if $lang=="de"}[kein Titel]{else}[no title]{/if}
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
<h2>{if $lang=="de"}Tags{else}Tags{/if}</h2>

{foreach from=$allTags item=tag}
    <a href="?action=filter&tag={$tag.description}">
        <button type="button" class="btn btn-outline-primary  m-1">
            {$tag.description} <span class="badge badge-secondary">{$tag.count}</span>
        </button>
    </a>
{/foreach}

{include file="_footer.tpl"}
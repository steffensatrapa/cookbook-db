<!doctype html>
<html lang="de">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="pic/favicon32.png" type="image/png">
        <link rel="apple-touch-icon" href="pic/logo57.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="pic/logo72.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="pic/logo114.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="pic/logo144.png" />

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"></link>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <title>{$title}{if $lang=="de"}Kochbuch{else}cookbook{/if}</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-sm navbar-light bg-light">
            <div class="container">
                <!--<a class="navbar-brand" href="#">Container</a>-->
                <a class="navbar-brand" href="#">
                    <img src="pic/favicon32.png" width="32" height="32" alt="">
                </a>
                <button class="navbar-toggler" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#mainNavbar" 
                        aria-controls="mainNavbar" 
                        aria-expanded="false" 
                        aria-label="Aufklappen">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link {if $action==""}active{/if}" href="?">{if $lang=="de"}Übersicht{else}Overview{/if}</a>
                        </li>

                        <li class="nav-item">

                            <a class="nav-link {if $action=="edit" && isset($recipe)&& $recipe->getId()<=0}active{/if}" href="?action=edit">{if $lang=="de"}Neu{else}New{/if}</a>

                        </li>

                        <li class="nav-item">
                            {if isset($recipe)}
                                <a class="nav-link {if $action=="edit" && $recipe->getId()>0}active{/if}" href="?action=edit&recipeId={$recipe->getId()}">{if $lang=="de"}Bearbeiten{else}Edit{/if}</a>
                            {else}
                                <a class="nav-link disabled" href="#">{if $lang=="de"}Bearbeiten{else}Edit{/if}</a>
                            {/if}
                        </li>

                        <li class="nav-item">
                            {if $loggedInUser}
                                <a class="nav-link" href="?action=logout">{if $lang=="de"}Abmelden{else}Logout{/if} [{$loggedInUser->getUserName()}]</a>
                            {else}
                                <a class="nav-link {if $action=="login"}active{/if}" href="?action=login">{if $lang=="de"}Anmelden{else}Login{/if}</a>
                            {/if}
                        </li>
                    </ul>


                    <ul class="navbar-nav ml-auto">

                        <form class="form-inline my-2 my-md-0" method="GET">
                            <input type="hidden" name="action" value="search">
                            <input class="form-control mr-sm-2" type="search" placeholder="Suche" name="keywords" aria-label="{if $lang=="de"}Suche{else}Search{/if}" value="{$keywords}">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{if $lang=="de"}Suche{else}Search{/if}</button>
                        </form>

                        <li class="nav-item dropdown float-right">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {$lang|upper}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="?action=language&lang=de">DE</a>
                                <a class="dropdown-item" href="?action=language&lang=en">EN</a>

                            </div>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>

        <main role="main" class="container pt-4">

            {include file="_alerts.tpl"}
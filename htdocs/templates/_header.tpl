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

        <title>{$title}</title>
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
                            <a class="nav-link {if $action==""}active{/if}" href="?">Übersicht</a>
                        </li>

                        <li class="nav-item">

                            <a class="nav-link {if $action=="edit" && isset($recipe)&& $recipe->getId()<=0}active{/if}" href="?action=edit">Neu</a>

                        </li>

                        <li class="nav-item">
                            {if isset($recipe)}
                                <a class="nav-link {if $action=="edit" && $recipe->getId()>0}active{/if}" href="?action=edit&recipeId={$recipe->getId()}">Editieren</a>
                            {else}
                                <a class="nav-link disabled" href="#">Editieren</a>
                            {/if}
                        </li>

                        <li class="nav-item">
                            {if $loggedInUser}
                                <a class="nav-link" href="?action=logout">Abmelden [{$loggedInUser->getUserName()}]</a>
                            {else}
                                <a class="nav-link {if $action=="login"}active{/if}" href="?action=login">Anmelden</a>
                            {/if}
                        </li>



                    </ul>
                    <form class="form-inline my-2 my-md-0" method="GET">
                        <input type="hidden" name="action" value="search">
                        <input class="form-control mr-sm-2" type="search" placeholder="Suche" name="keywords" aria-label="Suche" value="{$keywords}">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Suche</button>
                    </form>
                </div>
            </div>
        </nav>


        <main role="main" class="container pt-4">

            {if $errorMessage}
                <div class="alert alert-danger" role="alert">
                    {if $errorMessageHeader}
                        <h4 class="alert-heading">{$errorMessageHeader}</h4>
                    {/if}
                    <p>{$errorMessage}</p>
                </div>
            {/if}

            {if $warningMessage}
                <div class="alert alert-warning" role="alert">
                    {if $warningMessageHeader}
                        <h4 class="alert-heading">{$warningMessageHeader}</h4>
                    {/if}
                    <p>{$warningMessage}</p>
                </div>
            {/if}

            {if $successMessage}
                <div class="alert alert-success" role="alert">
                    {if $successMessageHeader}
                        <h4 class="alert-heading">{$successMessageHeader}</h4>
                    {/if}
                    <p>{$successMessage}</p>
                </div>
            {/if}

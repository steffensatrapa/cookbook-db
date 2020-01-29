<?php

require_once(dirname(__FILE__) . "/lib/ClassLoader.php");

CrUser::createDatabaseTable();
CrRecipe::createDatabaseTable();
CrIngredient::createDatabaseTable();
CrTag::createDatabaseTable();

echo "Done. Created all tables.";

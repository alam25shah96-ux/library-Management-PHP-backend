<?php
function getCategories()
{
    echo json_encode(Categories::readAll());
}

?>
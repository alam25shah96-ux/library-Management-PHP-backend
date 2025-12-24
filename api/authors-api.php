<?php
function getAuthors()
{
    echo json_encode(Authors::readAll());
}

?>
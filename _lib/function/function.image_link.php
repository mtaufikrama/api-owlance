<?php
function image_link($tabs = '', $id = '')
{
    $link = "owlance.metir.my.id/api/v1/get-foto.php?id=$id&tabs=$tabs";
    return $link;
}

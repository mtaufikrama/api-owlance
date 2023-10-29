<?php
if (!function_exists("image_link")) {
    function image_link($tabs = '', $id = '')
    {
        $link = "owlance.metir.my.id/api/v1/get-foto.php?tabs=$tabs&id=$id";
        return $link;
    }
}

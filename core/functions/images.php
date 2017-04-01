<?php
function images($folder) {
    return scandir('images/'.$folder);
}
?>
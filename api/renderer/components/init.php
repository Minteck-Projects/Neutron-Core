<?php

$json = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/widgets.json"));
$widgets = $json->list;
foreach ($widgets as $widget): ?>
<?php $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/feature.json")); ?>
<?php

if (isset($data->class) && is_string($data->class)) {
    require $_SERVER['DOCUMENT_ROOT'] . "/widgets/" . $widget . "/source.php";
}

?>
<?php endforeach ?>
<?php

function getPageContent() {
    global $MPCMSRendererPageMarkup;
    global $MPCMSRendererPageMarkupDN;
    global $MPCMSRendererPageNameValue;

    if (isset($MPCMSRendererPageMarkup) && isset($MPCMSRendererPageMarkupDN)) {
        return $MPCMSRendererPageMarkup;
    } else {
        return file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $MPCMSRendererPageNameValue);
    }
}
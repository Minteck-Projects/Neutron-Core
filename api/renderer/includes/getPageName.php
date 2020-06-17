<?php

function getPageName() {
    global $MPCMSRendererPageMarkup;
    global $MPCMSRendererPageMarkupDN;
    global $MPCMSRendererPageNameValue;
    
    if (isset($MPCMSRendererPageMarkup) && isset($MPCMSRendererPageMarkupDN)) {
        return $MPCMSRendererPageMarkupDN;
    } else {
        if ($MPCMSRendererPageNameValue == "index") {
            return file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename");
        } else {
            return file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $MPCMSRendererPageNameValue . "/pagename");
        }
    }
}
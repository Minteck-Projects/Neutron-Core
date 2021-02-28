<?php

function debugDump() {
    global $_FNSN_DUMP_STARTDATE;
    $_FNSN_DUMP_STOPDATE = new DateTime("now");
    $_FNSN_DUMP_DSTARTDATE = new DateTime("now");

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/flag_boundaries")): ?>

<style>

* {
    outline: 1px solid rgba(0, 0, 0, 0.3);
}

div, blockquote, center {
    outline: 1px solid rgba(255, 0, 0, 0.3);
}

p, h1, h2, h3, h4, h5, h6 {
    outline: 1px solid rgba(0, 255, 0, 0.3);
}

span, i, u, b, s, sup, sub, code, mark {
    outline: 1px solid rgba(0, 0, 255, 0.3);
}

li, ol, ul, table {
    outline: 1px solid rgba(0, 255, 255, 0.3);
}

iframe, audio, video, frame, canvas, figure {
    outline: 1px solid rgba(255, 0, 255, 0.3);
}

svg, image, img {
    outline: 1px solid rgba(255, 255, 0, 0.3);
}

input, textarea {
    outline: 1px solid rgba(255, 255, 255, 0.3);
}

</style>
<?php endif;if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/flag_trace")): ?>
    <style>
        #neutron-dump {
            background: white;
            outline: none;
            border-collapse: collapse;
            color: black;
            font-family: sans-serif !important;
        }

        #neutron-dump td, #neutron-dump tr, #neutron-dump tbody {
            border: 1px solid black;
            font-family: sans-serif !important;
        }

        #neutron-dump * {
            font-family: sans-serif !important;
            outline: none !important;
        }

        #neutron-dump-title {
            background: red;
            color: white;
            font-size: 24px;
        }

        #neutron-dump-logo {
            background-color: blue;
        }

        #neutron-dump-category {
            background-color: lightgray;
            font-weight: bold;
        }
    </style>
<table id="neutron-dump">
    <tbody>
        <tr>
            <td colspan="3" id="neutron-dump-title"><span id="neutron-dump-logo">(i)</span> FNS Neutron Debug</td>
        </tr>
        <tr>
            <td colspan="3" id="neutron-dump-category">Loaded Files</td>
        </tr>
        <?php
        $files = get_included_files();
        $sizes = [];
        foreach ($files as $file) {
            $sizes[] = filesize($file);
        }
        sort($sizes, SORT_NUMERIC);
        $rev = array_reverse($sizes);
        $max = $rev[0];
        $i = 1;
        foreach ($files as $file) : ?>
        <tr>
            <td id="neutron-dump-cell"><?php if (filesize($file) == $max) { echo("<b>"); } ?><?= $i ?><?php if (filesize($file) == $max) { echo("</b>"); } ?></td>
            <td id="neutron-dump-cell"><?php if (filesize($file) == $max) { echo("<b>"); } ?><?= $file ?><?php if (filesize($file) == $max) { echo("</b>"); } ?></td>
            <td id="neutron-dump-cell"><?php if (filesize($file) == $max) { echo("<b>"); } ?><?= filesize($file) ?> B<?php if (filesize($file) == $max) { echo("</b>"); } ?></td>
        </tr>
        <?php $i++;endforeach; ?>
        <tr>
            <td colspan="3" id="neutron-dump-category">Processing Time</td>
        </tr>
        <tr>
            <td colspan="2" id="neutron-dump-cell">Page Rendering</td>
            <td id="neutron-dump-cell"><?= $_FNSN_DUMP_STARTDATE->diff($_FNSN_DUMP_STOPDATE)->f * 1000; ?> ms</td>
        </tr>
        <tr>
            <td colspan="2" id="neutron-dump-cell">System Trace Creation</td>
            <td id="neutron-dump-cell"><?php $_FNSN_DUMP_DSTOPDATE = new DateTime("now"); echo $_FNSN_DUMP_DSTARTDATE->diff($_FNSN_DUMP_DSTOPDATE)->f * 1000; ?> ms</td>
        </tr>
        <tr>
            <td colspan="3" id="neutron-dump-category">Software Stack Version</td>
        </tr>
        <tr>
            <td id="neutron-dump-cell">PHP Version</td>
            <td colspan="2" id="neutron-dump-cell"><?= PHP_VERSION ?></td>
        </tr>
        <tr>
            <td id="neutron-dump-cell">Server OS</td>
            <td colspan="2" id="neutron-dump-cell"><?= php_uname('s') ?>:<?= php_uname('m') ?>@<?= php_uname('n') ?> <?= php_uname('r') ?></td>
        </tr>
        <tr>
            <td id="neutron-dump-cell">Neutron Version</td>
            <td colspan="2" id="neutron-dump-cell"><?= explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"))[0] ?></td>
        </tr>
        <tr>
            <td id="neutron-dump-cell">Electrode Compat. Layer</td>
            <td colspan="2" id="neutron-dump-cell"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/electrode/version") ?></td>
        </tr>
        <tr>
            <td id="neutron-dump-cell">JustAWebsite</td>
            <td colspan="2" id="neutron-dump-cell"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/jaw_version") ?></td>
        </tr>
        <tr>
            <td id="neutron-dump-cell">CyclicCMS</td>
            <td colspan="2" id="neutron-dump-cell"><?= file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/cyclic_version") ?></td>
        </tr>
        <tr>
            <td colspan="3" id="neutron-dump-category">Server Data</td>
        </tr>
        <tr>
            <td colspan="3" id="neutron-dump-cell">
                <details style="cursor:pointer;">
                    <summary>Click here to show</summary>
                    <table style="border-collapse:collapse;cursor:text;">
                    <tbody>
                    <?php foreach ($_SERVER as $key => $srv): ?>
                    <tr>
                        <td id="neutron-dump-cell"><?= $key ?></td>
                        <td colspan="2" id="neutron-dump-cell"><?= $srv ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
                </details>
            </td>
        </tr>
        <tr>
            <td colspan="3" id="neutron-dump-category">Headers</td>
        </tr>
        <?php foreach (getallheaders() as $key => $srv): ?>
            <tr>
                <td id="neutron-dump-cell"><?= $key ?></td>
                <td colspan="2" id="neutron-dump-cell"><?php
                
                if (strtolower($key) == "cookie" || strtolower($key) == "set-cookie") {
                    echo("[hidden for safety]");
                } else {
                    echo($srv);
                }
                
                
                ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <?php
    endif;
}
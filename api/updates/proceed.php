<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";

function error($errno, $errmsg) {
    if (strpos($errmsg, "Not Found") !== false) {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit($errmsg);
    }
}

function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755)) {
    $result=false;

    if (is_file($source)) {
        if ($dest[strlen($dest)-1]=='/') {
            if (!file_exists($dest)) {
                cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
            }
            $__dest=$dest."/".basename($source);
        } else {
            $__dest=$dest;
        }
        $result=copy($source, $__dest);
        chmod($__dest,$options['filePermission']);

    } elseif(is_dir($source)) {
        if ($dest[strlen($dest)-1]=='/') {
            if ($source[strlen($source)-1]=='/') {
                //Copy only contents
            } else {
                //Change parent itself and its contents
                $dest=$dest.basename($source);
                @mkdir($dest);
                chmod($dest,$options['filePermission']);
            }
        } else {
            if ($source[strlen($source)-1]=='/') {
                //Copy parent directory with new name and all its content
                @mkdir($dest,$options['folderPermission']);
                chmod($dest,$options['filePermission']);
            } else {
                //Copy parent directory with new name and all its content
                @mkdir($dest,$options['folderPermission']);
                chmod($dest,$options['filePermission']);
            }
        }
        $dirHandle=opendir($source);
        while($file=readdir($dirHandle))
        {
            if($file!="." && $file!="..")
            {
                 if(!is_dir($source."/".$file)) {
                    $__dest=$dest."/".$file;
                } else {
                    $__dest=$dest."/".$file;
                }
                //echo "$source/$file ||| $__dest<br />";
                $result=smartCopy($source."/".$file, $__dest, $options);
            }
        }
        closedir($dirHandle);

    } else {
        $result=false;
    }
    return $result;
}

function rrmdir($dir) {
    if (is_dir($dir)) {
      $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir."/".$object)) {
                    rrmdir($dir."/".$object);
                } else {
                    unlink($dir."/".$object);
                }
            }
        }
        rmdir($dir);
    }
}

function rcopy($dir) {
    if (is_dir($dir)) {
      $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir."/".$object)) {
                    rrmdir($dir."/".$object);
                } else {
                    unlink($dir."/".$object);
                }
            }
        }
        rmdir($dir);
    }
}

if (isset($_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN']) && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != ".." && $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'] != "/") {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $_COOKIE['_FNS_NEUTRON_ADMIN_TOKEN'])) {

    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Jeton d'authentification invalide");
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        } else {
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
        }
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Jeton d'authentification invalide");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log")) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log") . date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    } else {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/system.log", date("d/m/Y H:i:s") . " - APIDENY/" . $_SERVER['REQUEST_METHOD'] . " - " . $_SERVER['REQUEST_URI'] . " - " . $_SERVER['HTTP_USER_AGENT'] . "\n\n");
    }
}

function append(string $content) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/UPDATE.log", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/UPDATE.log") . $content . "\n");
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/UPDATE.log")) {
    unlink($_SERVER['DOCUMENT_ROOT'] . "/data/UPDATE.log");
}
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/UPDATE.log",  "");

append("# Checking for updates...");

$version = explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"))[0];
append("curl: " . file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/update") . "/" . $version . "/updates.json");

$json = json_decode(file_get_contents(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/update") . "/" . $version . "/updates.json"));

if (json_last_error() != JSON_ERROR_NONE) {
    append("Received data is not valid JSON.");
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Received data is not valid JSON.");
}

if ($json->version->name != $version) {
    append("Version mismatch. Expecting " . $version . " but got " . $json->version->name);
    require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("Received data is not valid JSON.");
}

$updates = [];
foreach ($json->updates as $update) {
    if (version_compare($version, $update->target) == -1) { // Update not installed
        array_push($updates, $update);
    }
}

if (count($updates) == 0) {
    append("# Installation clean, nothing to update.");
} else {
    append("# Updates to install: " . count($updates));
}

$files = [];
foreach ($updates as $update) {
    if ($update->package->url != null) {
        array_push($files, $update->package->url);
    }
    foreach ($update->changes as $change) {
        array_push($files, file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/update") . "/" . $version . "/" . $change->url);
    }
}

$unames = [];
foreach ($updates as $update) {
    array_push($unames, $update->type . "::" . $update->target);
}

$lastver = "";
foreach ($updates as $update) {
    $lastver = $update->target;
}

$addops = [];
foreach ($updates as $update) {
    if ($update->package->mode == "erase" && $update->package->url != null) {
        array_push($addops, "Remove all system data");
    }
}

append("# Updates summary:\n\nThe following files will be downloaded:\n    " . implode("    ", $files) . "\n\nThe following updates will be installed:\n    " . implode("    ", $unames) . "\n\nAfter the updates, the software will be at version:\n    " . $lastver . "\n\nThe following additional operations will be done:\n    " . implode("    ", $addops) . "\n\nThe system is now ready to update.\n");

append("# Setting up protections...");
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/.htaccess")) {
    append("# User htaccess directives found, moving them");
    append("file: /.htaccess -> /data/.htaccess.orig.temp");
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/.htaccess.orig.temp", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/.htaccess"));
    unlink($_SERVER['DOCUMENT_ROOT'] . "/.htaccess");
}
append("# Setting up update-specific htaccess directives");
append("file: .htaccess.next -> /.htaccess");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/.htaccess", file_get_contents("./.htaccess.next"));
append("# Moving old index.php file");
append("file: /index.php -> /data/.index.php.orig.temp");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/data/.index.php.orig.temp", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/index.php"));
unlink($_SERVER['DOCUMENT_ROOT'] . "/index.php");
append("# Generating update-specific index.html file");
append("cms: Generating localized homepage");
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/index.html", "<!DOCTYPE html><html><head><meta charset=\"utf-8\"><title>FNS Neutron</title></head><body><h1>" . $lang["updating"]["title"] . "</h1><p>" . $lang["updating"]["message"] . "</p><p><i>" . $lang["updating"]["admin"] . "</i></p></body></html>");
append("# Flushing administrator tokens");
append("cms: Closed all sessions");
$tokens = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/tokens");
foreach ($tokens as $atoken) {
    if ($atoken == "." || $atoken == "..") {} else {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/data/tokens/" . $atoken);
    }
}
append("# Reserving more execution time");
set_time_limit(0);
append("php: Script will run infinitely");
append("# Update environment is now ready!");
append("# Creating temporary space...");
mkdir($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache");
append("files: makedir /data/\$UpdateCache");

// Do real things!
$count = 1;
$total = count($updates);
foreach ($updates as $update) {
    append("# Processing update " . $count . " of " . $total);

    $tarball = null;
    $files = [];
    if ($update->package->url != null) {
        $tarball = $update->package->url;
    }
    foreach ($update->changes as $file) {
        array_push($files, file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/update") . "/" . $version . "/" . $file->url);
    }

    $dcount = 1;
    $index = 0;
    $dtotal = count($updates);
    if ($tarball != null) {
        $dtotal++;
    }

    append("# u:{$count}: Downloading files...");
    if ($tarball != null) {
        append("# u:{$count}: {$dcount}/{$dtotal}: {$tarball} -> /data/\$UpdateCache/update.tar.gz");
        copy($tarball, $_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update.tar.gz");
        $dcount++;
    }
    foreach ($files as $file) {
        append("# u:{$count}: {$dcount}/{$dtotal}: {$file} -> /data/\$UpdateCache/{$index}.bin");
        copy($file, $_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/{$index}.bin");
        $index++;
        $dcount++;
    }

    append("# u:{$count}: Applying update...");
    if ($tarball != null) {
        append("# u:{$count}: /data/\$UpdateCache/update.tar.gz");
        append("# Processing archive...");
        $p = new PharData($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update.tar.gz");
        $p->decompress();
        $phar = new PharData($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update.tar");
        if ($update->package->mode == "erase") {
            append("# Archive in erase mode, deleting all system files...");
            rrmdir($_SERVER['DOCUMENT_ROOT'] . "/api");
            rrmdir($_SERVER['DOCUMENT_ROOT'] . "/cms-special");
            rrmdir($_SERVER['DOCUMENT_ROOT'] . "/widgets");
            $resdirs = scandir($_SERVER['DOCUMENT_ROOT'] . "/resources");
            foreach ($resdirs as $dir) {
                if ($dir == "." || $dir == ".." || $dir == "upload") {} else {
                    rrmdir($_SERVER['DOCUMENT_ROOT'] . "/resources/" . $dir);
                }
            }
        }
        append("# Extracting archive...");
        $phar->extractTo($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update");
        if (count(scandir($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update")) == 3) {
            append("# Archive only contains one subroot directory, upgrading from it");
            $uproot = $_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update/" . scandir($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update")[2];
        } else {
            $uproot = $_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update";
        }
        append("# Applying tarball to website...");
        smartCopy($uproot, $_SERVER['DOCUMENT_ROOT']);
        append("# Removing old update root...");
        rrmdir($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/update");
    }

    $ufiles = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache");
    foreach ($ufiles as $file) {
        if ($file != "." && $file != ".." && $file != "update.tar" && $file != "update.tar.gz") {
            append("# u:{$count}: Applying /data/\$UpdateCache/{$file}");
            copy($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/{$file}", $_SERVER['DOCUMENT_ROOT'] . "/" . $update->changes[explode('.', $file)[0]]->file);
        }
    }

    append("# Updating version number...");
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/api/version")) {
        $verparts = explode("-", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version"));
        $verparts[0] = $lastver;
        $fullver = implode("-", $verparts);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version", $fullver);
    } else {
        append("# This update is missing a version number, creating a new one");
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/api/version", $lastver . "-#-generic");
    }

    $count++;
}

append("# All updates done, restoring normal environment");

if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/.htaccess.orig.temp")) {
    append("# User htaccess directives found, restoring them");
    append("file: /data/.htaccess.orig.temp -> /.htaccess");
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/.htaccess", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/.htaccess.orig.temp"));
    unlink($_SERVER['DOCUMENT_ROOT'] . "/data/.htaccess.orig.temp");
} else {
    append("# Removing update-specific htaccess directives");
    append("file: delete /.htaccess");
    unlink($_SERVER['DOCUMENT_ROOT'] . "/.htaccess");
}
if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/index.php")) {
    append("# Update overwritten original index.php file, removing backup");
    append("file: delete /data/.index.php.orig.temp");
    unlink($_SERVER['DOCUMENT_ROOT'] . "/data/.index.php.orig.temp");
} else {
    append("# Restoring index.php file");
    append("file: delete /index.html");
    unlink($_SERVER['DOCUMENT_ROOT'] . "/index.html");
    append("file: /index.php -> /data/.index.php.orig.temp");
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/index.php", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/.index.php.orig.temp"));
    unlink($_SERVER['DOCUMENT_ROOT'] . "/data/.index.php.orig.temp");
}
append("# Deleting update cache...");
$tokens = scandir($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache");
foreach ($tokens as $atoken) {
    if ($atoken == "." || $atoken == "..") {} else {
        unlink($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache/" . $atoken);
    }
}
rmdir($_SERVER['DOCUMENT_ROOT'] . "/data/\$UpdateCache");
append("# Finished restoring normal environment, please login to website administration to ensure everything is installed correctly.");
append("# Bye!");

require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit("ok");
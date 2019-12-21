<?php
use OpenApi\Annotations as OA;
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/public/headers.php";

function getData(string $dir, $ignoreUploadDir = false) {
    global $size;
    $dircontent = scandir($dir);
    foreach ($dircontent as $direl) {
        if ($ignoreUploadDir && ($direl == "/upload" || $dir . "/" . $direl == $_SERVER['DOCUMENT_ROOT'] . "/resources/upload")) {} else {
            if ($direl == "." || $direl == ".." || $direl == ".git") {} else {
                if (is_link($dir . "/" . $direl)) {} else {
                    if (is_dir($dir . "/" . $direl)) {
                        getData($dir . "/" . $direl);
                    } else {
                        $size = $size + filesize($dir . "/" . $direl);
                    }
                }
            }
        }
    }
}

/**
 * @OA\Get(
 *      path="/api/public/info/size.php",
 *      @OA\Response(
 *          response="200",
 *          description="Taille des fichiers du site dans différents formats",
 *          @OA\JsonContent(type="object", @OA\Items(ref="#/components/schemas/InfoSize"), example={"size":22369368,"sizestr":"21.333M"}),
 *      ),
 *      @OA\Response(response="401", description="API désactivé par l'administrateur du site"),
 *      @OA\Response(response="500",description="Erreur interne de l'API",@OA\JsonContent(type="object", @OA\Items(ref="#/components/schemas/Error"), example={"error":420,"message":"Required argument is undefined"}))
 * )
 */
header("Content-Type: application/json");
$output = array();
getData($_SERVER['DOCUMENT_ROOT']);
$output["size"] = $size;
$sizestr = $size . "B";
if ($size > 1024) {
    if ($size > 1048576) {
        if ($size > 1073741824) {
            $sizestr = round($size / 1073741824, 3) . "G";
        } else {
            $sizestr = round($size / 1048576, 3) . "M";
        }
    } else {
        $sizestr = round($size / 1024, 3) . "K";
    }
} else {
    $sizestr = $size . "B";
}
$output["sizestr"] = $sizestr;
echo(json_encode($output));
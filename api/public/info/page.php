<?php
use OpenApi\Annotations as OA;
include_once $_SERVER['DOCUMENT_ROOT'] . "/api/public/headers.php";

/**
 * @OA\Get(
 *      path="/api/public/info/page.php",
 *      @OA\Parameter(
 *          name="id",
 *          in="query",
 *          description="Identifiant de la page",
 *          required=true,
 *          @OA\Schema(type="string",example="index")
 *      ),
 *      @OA\Response(
 *          response="200",
 *          description="Informations concernant une page",
 *          @OA\JsonContent(type="object", @OA\Items(ref="#/components/schemas/InfoPage"), example={"size":22369368,"sizestr":"21.333M"}),
 *      ),
 *      @OA\Response(response="401", description="API désactivé par l'administrateur du site"),
 *      @OA\Response(
 *          response="500",
 *          description="Erreur interne de l'API",
 *          @OA\JsonContent(type="object", @OA\Items(ref="#/components/schemas/Error"), example={"error":420,"message":"Required argument is undefined"}),
 *      )
 * )
 */
header("Content-Type: application/json");
if (isset($_GET['id'])) {
    if ($_GET['id'] == "index" || $_GET['id'] == "galery") {

    } else {
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $_GET['id'])) {
            header("HTTP/1.1 500 API Error");
            die(json_encode(array(
                'error' => "E_FILE_NOTFOUND",
                'message' => "File cannot be found or read"
            )));
        }
    }
} else {
    header("HTTP/1.1 500 API Error");
    die(json_encode(array(
        'error' => "E_ARG_MISSING",
        'message' => "Required argument is undefined"
    )));
}
$output = array();
$output['id'] = $_GET['id'];
if ($_GET['id'] != "galery") {
    if ($_GET['id'] != "index") {
        $output['name'] = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/" . $_GET['id'] . "/pagename");
    } else {
        $output['name'] = "Accueil";
    }
} else {
    $output['name'] = "Galerie de photos";
}
if ($_GET['id'] != "galery") {
    $output['size'] = filesize($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/pages/" . $_GET['id']);
} else {
    $output['size'] = null;
}
if ($_GET['id'] != "galery") {
    if ($_GET['id'] != "index") {
        $output['path'] = "/" . $_GET['id'];
    } else {
        $output['path'] = "/";
    }
} else {
    $output['path'] = "/cms-special/galery";
}
if (!in_array($_GET['id'], $customSettings->PagesMasquées)) {
    $output['hidden'] = false;
} else {
    $output['hidden'] = true;
}
echo(json_encode($output));
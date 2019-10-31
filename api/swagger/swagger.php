<?php
use OpenApi\Annotations as OA;

/**
 * 
 * @OA\Info(title="API de Minteck Projects CMS", version="1.0")
 * 
 * @OA\Schema(
 *      schema="Error",
 *      @OA\Property(property="error", type="string", description="Nom interne de l'erreur, ou E_INTERNAL si l'erreur est inconnue", example="E_ARG_MISSING"),
 *      @OA\Property(property="message", type="string", description="Court message (en anglais) associé à l'erreur", example="Required argument is undefined"),
 * )
 * 
 * @OA\Schema(
 *      schema="InfoPage",
 *      @OA\Property(property="id", type="string", description="Identifiant de la page", example="index"),
 *      @OA\Property(property="title", type="string", description="Titre de la page", example="Accueil"),
 *      @OA\Property(property="size", type="integer", description="Taille de la page (en octets)", example="421", nullable=true),
 *      @OA\Property(property="path", type="string", description="Emplacement de la page par rapport à la racine du site", example="/"),
 *      @OA\Property(property="hidden", type="boolean", description="Page masquée depuis les paramètres avancés", example="false"),
 * )
 * 
 * @OA\Schema(
 *      schema="InfoSize",
 *      @OA\Property(property="size", type="integer", description="Taille du site en octets", example="22369368"),
 *      @OA\Property(property="sizestr", type="string", description="Taille du site dans un format plus lisible", example="21.333M"),
 * )
 * 
 */
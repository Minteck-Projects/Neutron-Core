<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php"; ?>
<?php $pageConfig = [ "domName" => "Options avancées", "headerName" => "Options avancées" ]; require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/precontent.php"; ?>
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/2fasecret")): ?>
    <?php else: ?>
        <?php $tfa = new RobThree\Auth\TwoFactorAuth(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/data/webcontent/sitename")); ?>
        <?php $secret = $tfa->createSecret(); ?>
        <p><b><?= $lang["admin-2fa"]["intro"][2] ?></b></p>
        <p><?= $lang["admin-2fa"]["intro"][0] ?></p>
        <p><?= $lang["admin-2fa"]["intro"][1] ?></p>
        <p><?= $lang["admin-2fa"]["scan"] ?></p>
        <img src="<?php echo $tfa->getQRCodeImageAsDataUri('Minteck Projects CMS', $secret); ?>">
        <p><?= $lang["admin-2fa"]["code"] ?></p>
        <code><?php echo substr($secret, 0, 4) . " " . substr($secret, 4, 4) . " " . substr($secret, 8, 4) . " " . substr($secret, 12, 4); ?></code><br>
        <p><?= $lang["admin-2fa"]["finish"] ?></p>
    <?php endif; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/cms-special/admin/\$resources/postcontent.php"; ?>
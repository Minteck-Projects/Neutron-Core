<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/api/lang/processor.php";

if (isset($_GET['return'])) {
    $callback = $_GET['return'];
}

?>
<!DOCTYPE html>
<html lang="en" style="height:100%;overflow:hidden;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/resources/css/preview.css">
    <script src="/resources/js/jquery.js"></script>
    <title><?= $lang["gallery"]["preview"]->title ?></title>
</head>
<?php

    if (isset($_GET['url'])) {
        if (strpos($_GET['url'], '..') !== false) {
            require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit($lang["gallery"]["preview"]->invalid);
        } else {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/" . $_GET['url'])) {
                $ext1 = explode(".", $_GET['url']);
                $ext2 = end($ext1);
                $ext = strtoupper($ext2);
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit($lang["gallery"]["preview"]->notfound);
            }
        }
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . "/api/electrode/quit.php";quit($lang["gallery"]["preview"]->none);
    }

?>
<body style="background-size:contain;background-position:center;height: 100%;margin: 0;background-repeat: no-repeat;background-color: #222;">
    <div class="container">
        <img class="image" id="scroll" src="<?= $_GET['url'] ?>" draggable="false" onmouseup="clearTimeout(mdt);--mousedown;" onclick="return false;">
        <script>
          document.getElementsByClassName('image')[0].style.scale = 1;
        </script>
    </div>
    <?php if (isset($callback)): ?><a class="close" title="<?= $lang["gallery"]["preview"]->close ?>"><img class="icon" src="/resources/image/close.svg" onclick="location.href = &quot;<?= $callback ?>&quot;"></a><?php endif ?>
    <a class="download" href="<?= $_GET['url'] ?>" title="<?= $lang["gallery"]["preview"]->placeholder[0] ?> <?= $ext ?> <?= $lang["gallery"]["preview"]->placeholder[1] ?>" download><?= $lang["gallery"]["preview"]->download ?> (<?= $ext ?>)</a>
    <span class="zoom">
        <a class="zoomin" onclick="if (document.getElementsByClassName('image')[0].style.scale < 8) {document.getElementsByClassName('image')[0].style.scale++;document.getElementsByClassName('image')[0].style['margin-top'] = (((1055 / 6) * (window.innerHeight / 480)) * document.getElementsByClassName('image')[0].style.scale) + 'px';}"></a>
        <a class="zoomout" onclick="if (document.getElementsByClassName('image')[0].style.scale > 1) {document.getElementsByClassName('image')[0].style.scale--;if (document.getElementsByClassName('image')[0].style.scale > 1) {document.getElementsByClassName('image')[0].style['margin-top'] = (((1055 / 6) / 422) * document.getElementsByClassName('image')[0].style.scale) + 'px';}else{document.getElementsByClassName('image')[0].style['margin-top'] = 0;}}"></a>
    </span>
</body>
<script>

window.onload = () => {setTimeout(() => {Array.from(document.getElementsByClassName('ppreview')).forEach((el) => {el.classList.add('loaded')});}, 1000)}

(function($) {
  $.dragScroll = function(options) {
    var settings = $.extend({
      scrollVertical: true,
      scrollHorizontal: true,
      cursor: null
    }, options);

    var clicked = false,
      clickY, clickX;

    var getCursor = function() {
      if (settings.cursor) return settings.cursor;
      if (settings.scrollVertical && settings.scrollHorizontal) return 'move';
      if (settings.scrollVertical) return 'row-resize';
      if (settings.scrollHorizontal) return 'col-resize';
    }

    var updateScrollPos = function(e, el) {
      $('html').css('cursor', getCursor());
      var $el = $(el);
      settings.scrollVertical && $el.scrollTop($el.scrollTop() + (clickY - e.pageY));
      settings.scrollHorizontal && $el.scrollLeft($el.scrollLeft() + (clickX - e.pageX));
    }

    $(document).on({
      'mousemove': function(e) {
        clicked && updateScrollPos(e, this);
      },
      'mousedown': function(e) {
        clicked = true;
        clickY = e.pageY;
        clickX = e.pageX;
      },
      'mouseup': function() {
        clicked = false;
        $('html').css('cursor', 'auto');
      }
    });
  }
}(jQuery))

$.dragScroll();

</script>
</html>
<?php
/* @var $option \app\models\Option */
?>
<h3><span class="icon-thumb-up"></span>Share Bonus:</h3>
<p>Click to add $<?= $option->share_bonus ?> share bonus</p>
<div class="share-buttons">
    <div class="google-plus">
        <div class="g-plusone" data-size="medium" data-annotation="none" data-callback="updatePlusOne" data-href="<?= Yii::$app->request->url ?>"></div>
        <script type="text/javascript">
            window.___gcfg = {lang: "en-US"};
            (function() {var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
                po.src = "https://apis.google.com/js/platform.js";
                var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);})();
        </script>
    </div>
    <div class="fb-like" data-href="" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
</div>
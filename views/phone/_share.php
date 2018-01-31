<?php
/* @var $option \app\models\Option */
?>
<h3><span class="icon-thumb-up"></span>Share Bonus:</h3>
<p>Click to add $<?= $option->share_bonus ?> share bonus</p>

<div class="share-buttons">
	<span class="share-btn fb-btn" data-url="" data-sharer="https://www.facebook.com/sharer/sharer.php?u=">
		<i class="fa fa-facebook"></i>
	</span>
	<span class="share-btn google-btn" data-url="" data-sharer="https://plus.google.com/share?url=">
    	<i class="fa fa-google-plus"></i>
    </span>
    <span class="share-btn twitter-btn" data-url="" data-sharer="https://twitter.com/intent/tweet/?text=ezBuyBack.com%20-%20Sell%20your%20used%20device!&url=">
    	<i class="fa fa-twitter"></i>
    </span>
</div>
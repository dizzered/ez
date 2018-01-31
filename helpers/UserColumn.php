<?php
/**
 * Created by PhpStorm.
 * User: rzyuzin
 * Date: 09.11.2015
 * Time: 15:49
 */

namespace app\helpers;

use kartik\grid\DataColumn;

class UserColumn extends DataColumn
{
    public $user_attribute = null;

    protected function renderDataCellContent($model, $key, $index)
    {
        $column = $this->user_attribute ? $this->user_attribute : $this->attribute;
        $user = $model->{$column};

        return "<div class='user-icon'>" . UserHtml::userLink( $user ) . "</div>";
    }
}
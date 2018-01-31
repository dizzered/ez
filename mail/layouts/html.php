<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        body {
            font-family: Calibri, Verdana, Geneva, sans-serif;
            font-size:16px;
        }
        h1, h2, h3 {
            color:#0899ff;
        }
        h1 span {
            color:darkorange;
        }
        table {
            width:100%;
        }
        table td {
            padding:10px;
        }
        table.footer-info td {
            vertical-align:top;
            padding:0;
        }
        @media screen and (max-width: 640px) {
            .table-responsive {
                width:100%;
                overflow-x: scroll;
            }
            .table-responsive table {
                width:auto;
            }
            img.logo {
                width:100%;
                height:auto;
            }
        }
    </style>
</head>
<body style="background:#eee;">
    <?php $this->beginBody() ?>

    <div style="width:100%; margin:auto; background:#fff; padding:0;">
        <table style="width:100%;">
            <tr>
                <td style="background: #222; padding:15px 30px;">
                    <a href="<?= Yii::$app->getHomeUrl() ?>">
                        <img src="<?= Yii::$app->getHomeUrl() ?>img/ezbuybacklogo.png" alt="<?= Yii::$app->name ?>" class="logo" />
                    </a>
                </td>
            </tr>
        </table>
        <br />

        <?= $content ?>

        <div style="padding:0 10px;">
            <br /><br /><br /><br />
            Thank you!
            <BR>
            The <?= Yii::$app->name ?> Team
            <BR><BR>

            <strong>Online Chat Support:</strong><br /><br />
            Monday - Friday (9AM - 5PM EST)<br />
            <a href="https://app.purechat.com/w/ezbuyback" style="color:#f28022; font-weight:bold;">Click here to Chat!</a>

            <br /><br /><br /><br />

            <strong>Mailing Address:</strong><br /><br />
            10871 Bustleton Ave Suite #232<br />Philadelphia, PA 19116<br /><br />

        </div>

        <table style="width:100%;">
            <tr>
                <td style="background: #222; padding:15px 30px;">
                    <a href="<?= Yii::$app->getHomeUrl() ?>">
                        <img src="<?= Yii::$app->getHomeUrl() ?>img/ezbuybacklogo.png" alt="<?= Yii::$app->name ?>" class="logo" />
                    </a>
                </td>
            </tr>
        </table>

    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

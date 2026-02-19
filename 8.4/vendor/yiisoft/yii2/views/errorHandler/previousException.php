<?php

namespace Odigos;

/**
 * @var \yii\base\Exception $exception
 * @var \yii\web\ErrorHandler $handler
 */
?>
<div class="previous">
    <span class="arrow">&crarr;</span>
    <h2>
        <span>Caused by:</span>
        <?php 
$name = $handler->getExceptionName($exception);
?>
        <?php 
if ($name !== null) {
    ?>
            <span><?php 
    echo $handler->htmlEncode($name);
    ?></span> &ndash;
            <?php 
    echo $handler->addTypeLinks(\get_class($exception));
    ?>
        <?php 
} else {
    ?>
            <span><?php 
    echo $handler->htmlEncode(\get_class($exception));
    ?></span>
        <?php 
}
?>
    </h2>
    <h3><?php 
echo \nl2br($handler->htmlEncode($exception->getMessage()));
?></h3>
    <p>in <span class="file"><?php 
echo $exception->getFile();
?></span> at line <span class="line"><?php 
echo $exception->getLine();
?></span></p>
    <?php 
if ($exception instanceof \yii\db\Exception && !empty($exception->errorInfo)) {
    ?>
        <pre>Error Info: <?php 
    echo $handler->htmlEncode(\print_r($exception->errorInfo, \true));
    ?></pre>
    <?php 
}
?>
    <?php 
echo $handler->renderPreviousExceptions($exception);
?>
</div>
<?php 

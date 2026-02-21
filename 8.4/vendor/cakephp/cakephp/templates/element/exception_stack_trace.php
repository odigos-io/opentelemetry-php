<?php

namespace Odigos;

/**
 * Prints a stack trace for an exception
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var array $trace
 */
use Cake\Error\Debugger;
use function Cake\Core\h;
foreach ($exceptions as $exc) {
    $stackTrace = Debugger::formatTrace($exc->getTrace(), ['format' => 'array', 'args' => \true]);
    foreach ($stackTrace as $i => $stack) {
        $excerpt = [];
        $params = [];
        $line = null;
        if (isset($stack['file'], $stack['line']) && \is_numeric($stack['line'])) {
            $line = $stack['line'];
            $excerpt = Debugger::excerpt($stack['file'], $line, 4);
        }
        if (isset($stack['file'])) {
            $file = $stack['file'];
        } else {
            $file = '[internal function]';
        }
        if (isset($stack['function'])) {
            if (!empty($stack['args'])) {
                foreach ((array) $stack['args'] as $arg) {
                    $params[] = Debugger::exportVar($arg, 4);
                }
            } else {
                $params[] = 'No arguments';
            }
        }
        ?>
        <div id="stack-frame-<?php 
        echo $i;
        ?>" style="display:<?php 
        echo $i === 0 ? 'block' : 'none';
        ?>;" class="stack-details">
            <div class="stack-frame-header">
                <span class="stack-frame-file">
                    <?php 
        if ($line !== null) {
            ?>
                        <?php 
            echo $this->Html->link(Debugger::trimPath($file), Debugger::editorUrl($file, $line));
            ?>
                    <?php 
        } else {
            ?>
                        <?php 
            echo h(Debugger::trimPath($file));
            ?>
                    <?php 
        }
        ?>
                </span>
                <a href="#" class="toggle-link stack-frame-args" data-target="stack-args-<?php 
        echo $i;
        ?>">Toggle Arguments</a>
            </div>

            <table class="code-excerpt" cellspacing="0" cellpadding="0">
            <?php 
        $lineno = isset($stack['line']) && \is_numeric($stack['line']) ? $stack['line'] - 4 : 0;
        ?>
            <?php 
        foreach ($excerpt as $l => $line) {
            ?>
                <tr>
                    <td class="excerpt-number" data-number="<?php 
            echo $lineno + $l;
            ?>"></td>
                    <td class="excerpt-line"><?php 
            echo $line;
            ?></td>
                </tr>
            <?php 
        }
        ?>
            </table>

            <div id="stack-args-<?php 
        echo $i;
        ?>" class="cake-debug" style="display: none;">
                <h4>Arguments</h4>
                <?php 
        foreach ($params as $param) {
            ?>
                    <div class="cake-debug"><?php 
            echo $param;
            ?></div>
                <?php 
        }
        ?>
            </div>
        </div>
    <?php 
    }
}

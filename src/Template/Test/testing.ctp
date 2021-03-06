<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = false;

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace src/Template/Pages/home.ctp with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('home.css') ?>
    <?= $this->Html->css('custom.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
</head>
<body class="home">

<header class="row">
    <div class="header-image"><b>Upwork Test</b></div>
</header>

<div class="row main-body">
    <form class="container" method="post" action="<?php echo $this->Url->build(['_name' => 'test_testing', 'testId' => $categoryId ]); ?>">
        
        <div class="margin-top-20 font-22px">
            <b>Question:</b>
        </div>
        <div class="font-20px">
            <?php echo $questions[$questionId]->question_content ?>
        </div>
        <div class="margin-top-50 font-22px">
            <b>Answers:</b>
        </div>
        <div class="margin-top-20">
            <?php foreach($answers as $answer): ?>
            <input class="answer-radio margin-top-5" type='radio' value='<?php echo $answer->id ?>' name='answer_radio' id='<?php echo $answer->id ?>'/>
            <label class="margin-top-5 answer-label font-15px" for='<?php echo $answer->id ?>'><?php echo $answer->answer ?></label>
            <?php endforeach; ?>
        </div>
        <div class="margin-top-120">
            <input type="submit" class="btn-continue" value="Continue"/>
        </div>
    </form>
</div>
</body>
</html>

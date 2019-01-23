<?php //dump($subtree); die;?>
<li class="panel-heading item-comment-<?= $subtree['id']?>">     
    <div class="m-feed-item__identifier">
        <span style="background-color:#<?= $subtree['color']?>" class="avatar a-avatar__initials a-avatar__initials--ultramarine"><?=$subtree['img']?></span>
    </div>
    <div class="m-feed-item__body comment_wrapper">
        <div class="com-user-name"> <?= $subtree['fio']?></div>
        <p>
            <?= $subtree['text'];?>
        </p> 
        <?php if($subtree['id_parent'] == 0 ) : //&& !$subtree['childs']?> 
            <a href="#" class="reply" data-id="<?= $subtree['id']?>">
                <i class="fa fa-reply" aria-hidden="true"></i>
                Ответить
            </a>
        <?php endif ?>
        <?php if( isset($subtree['childs']) ): ?>
            
            <ul>
                <?= $this->getMenuHtml($subtree['childs'])?>
            </ul>

        <?php endif;?>

        <?php if($subtree['id_parent'] == 0) : ?>  
            <div class="form" data-view="<?= isset($subtree['childs']) ? 1 : 0?>" id="form_<?= $subtree['id']?>" style="<?= isset($subtree['childs']) ? 'display:block':'display:none';?>">
            <?= \yii\helpers\Html::beginForm(['course/addcoments'], 'post', ['class' => 'submit_comments']) ?>
                <input type="hidden" name="idQuestion" value="<?= $id?>">
                <input type="hidden" name="id_parent" value="<?= $subtree['id']?>"> 
                <div class="textarea-style">
                    <textarea name="text" type="text" class="text autoresize input subtext-stl" id="text" required="required" placeholder="Введите текст"></textarea>
                </div>
                <button type="submit" class="btn btn-info link">Отправить</button>
                <span class="character-count u-float-right">0/1200</span>
            <?= \yii\helpers\Html::endForm() ?>
            </div>
        <?php endif ?>
    </div>
    <div class="clearfix"></div>
</li>

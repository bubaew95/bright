<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a <?php if( isset($category['childs']) ): ?> data-toggle="collapse"  data-parent="#accordian" <?php endif;?> 
                href="<?= isset($category['childs']) 
                        ? '#'.$category['name_url'] 
                        : \yii\helpers\Url::to(['category/index', 'name_url' => "{$category['name_url']}"])?>
                     "
            >
                <?php if( isset($category['childs']) ): ?>    
                    <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                <?php endif;?> 
                <?= $category['name']?>
            </a>
        </h4>
    </div>
    <?php if( isset($category['childs']) ): ?>
        <div id="<?= $category['name_url']?>" class="panel-collapse collapse">
            <div class="panel-body">
                <ul>
                    <?= $this->getMenuHtml($category['childs'])?>
                </ul>
            </div>
        </div>
    <?php endif;?>
</div>
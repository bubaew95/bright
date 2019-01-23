<option value="<?= $category['id']?>" 
    <?php if( $category['id'] == $this->model->id) echo 'selected'?>
    <?php if($category['id'] == $this->model->id) echo ' disabled'; ?>>
    <?= $tab . $category['name']?>
</option>
<?php if( isset($category['childs']) ): ?>
    <?= $this->getMenuHtml($category['childs'], $tab . '- ')?>
<?php endif;?>

<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My blog';
?>

<?php foreach ($categories as $category): ?>
    <?= Html::a($category->name, ['site/index', 'category_id' => $category->id], ['class' => 'btn btn-primary']) ?>
<?php endforeach; ?>
<hr />

<?php foreach ($allPosts as $post): ?>
    <div>
        <h3><?= $post->title ?></h3> | <?= $post->category->name ?>
        <br />
        <?= $post->date_creation ?>
        <?php if ($post->img): ?>
            <img src="<?= $post->getPathToImage() ?>" width="250px" height="250px">
        <?php endif; ?>
        <br />
        <p>
            <?= $post->text ?>
        </p>
        <p>
            <?php foreach ($post->tags as $tag): ?>
                <?= Html::a($tag->name, ['site/index', 'tag_id' => $tag->id]) ?>
            <?php endforeach; ?>
        </p>
    </div>
    <hr />
<?php endforeach; ?>
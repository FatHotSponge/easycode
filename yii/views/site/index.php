<?php
use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My blog';
?>

<?php foreach ($categories as $category): ?>
    <?php
        $params = ['site/index', 'category_id' => $category->id];
        if ($tagId != 0) {
            $params['tag_id'] = $tagId;
        }
    ?>
    <?= Html::a($category->name, $params, ['class' => 'btn btn-primary']) ?>
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
                <?php
                    $params = ['site/index', 'tag_id' => $tag->id];
                    if ($categoryId != 0) {
                        $params['category_id'] = $categoryId;
                    }
                ?>
                <?= Html::a($tag->name, $params) ?>
            <?php endforeach; ?>
        </p>
    </div>
    <hr />
<?php endforeach; ?>
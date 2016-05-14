<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\UploadedFile;

use app\models\Tag;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->getId();
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['user_id' => $userId]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->getIdentity()->getId();
            $model->img = UploadedFile::getInstance($model, 'img');
            $fileName = POST::PATH_TO_IMG_UPLOAD_FOLDER . $model->img->baseName . '.' . $model->img->extension;
            $model->img->saveAs($fileName, false);
            if ($model->save()) {
                $tags = Yii::$app->request->post('tags');

                $this->linkTagsToPost($tags, $model);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                var_dump($model->getErrors());
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->unlinkAllTagsFromPost($model);

                $tags = Yii::$app->request->post('tags');
                $this->linkTagsToPost($tags, $model);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param array $tags
     *
     * @return array
     */
    protected function _validateTags(array $tags) {
        foreach ($tags as &$tag) {
            $tag = strtolower(trim($tag));
        }

//        foreach ($tags as $key => $tag) {
//            $tags[$key] = trim($tag);
//        }

        return array_filter($tags);
    }

    public function linkTagsToPost($tags, Post $post) {
        $explodedTags = explode(',', $tags);
        $validatedTags = $this->_validateTags($explodedTags);
        foreach ($validatedTags as $tagName) {
            $tag = Tag::find()->where(['name' => $tagName])->one();
            if (!$tag) {
                $tag = new Tag();
                $tag->name = $tagName;
                $tag->save();
            }
            $post->link('tags', $tag);
        }
    }

    public function unlinkAllTagsFromPost(Post $post) {
        foreach ($post->tags as $tag) {
            $post->unlink('tags', $tag, true);
        }
    }
}

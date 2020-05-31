<?php /** @noinspection MissedViewInspection */

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;

use Yii;
use yii\base\ExitException;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * This trait includes base actions with CRUD functions: grid, view, edit
 * Trait ArControlTrait
 * @package vsevolodryzhov\yii2ArControl
 */
abstract class AbstractArController extends Controller
{
    private const GRID_ACTION_NAME = 'grid';
    private const VIEW_ACTION_NAME = 'view';
    private const EDIT_ACTION_NAME = 'edit';

    /**
     * @param $className
     * @param null $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionFormAjaxValidate($className, $id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        /* @var $model ActiveRecord */
        if ($id === null) {
            $model = new $className;
            $model->setScenario(get_class($model)::SCENARIO_INSERT);
        } else {
            /* @var $className ActiveRecord */
            $model = $className::findOne($id);
            if (!$model) {
                throw new NotFoundHttpException("Model #$id not found");
            }
            $model->setScenario(get_class($model)::SCENARIO_UPDATE);
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            return ActiveForm::validate($model);
        }
        return [];
    }
    /**
     * @param $className
     * @param null $filterParams
     * @return string
     * @throws HttpException
     */
    public function actionGrid($className, $filterParams = null): string
    {
        $classes = ClassFactory::getByOriginalClassName($className);

        $searchableClass = $classes->getSearchableClass();
        if (!$searchableClass) {
            throw new HttpException(400, 'Searchable class doesn\'t exist');
        }

        if (!$searchableClass->hasAccess()) {
            throw new HttpException(400, 'You don\'t have permission to view this object.');
        }

        $dataProvider = $searchableClass->search($filterParams ?? Yii::$app->request->get());

        return $this->render('@vendor/vsevolod-ryzhov/yii2-ar-control/src/views/grid', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchableClass
        ]);
    }

    /**
     * Просмотр модели
     * @param $className
     * @param int $id
     * @return string
     * @throws HttpException
     */
    public function actionView($className, int $id): string
    {
        $classes = ClassFactory::getByOriginalClassName($className);

        $searchableClass = $classes->getSearchableClass();
        if (!$searchableClass) {
            throw new HttpException(400, 'View object is not permitted');
        }

        $model = $searchableClass::findOne($id);
        if (empty($model)) {
            throw new HttpException(404, 'Object not found');
        }

        $editClass = $classes->getEditableClass();

        $editUrl = ($editClass && $editClass->hasAccess()) ? self::EDIT_ACTION_NAME : null;

        return $this->render('@vendor/vsevolod-ryzhov/yii2-ar-control/src/views/item', [
            'model' => $model,
            'className' => $className,
            'editUrl' => $editUrl
        ]);
    }

    /**
     * @param $className
     * @param null $id
     * @return string|Response
     * @throws HttpException
     * @throws ExitException
     */
    public function actionEdit($className, $id = null)
    {
        $classes = ClassFactory::getByOriginalClassName($className);
        $editClass = $classes->getEditableClass();

        if (!$editClass) {
            throw new HttpException(400, 'Object edit is not permitted');
        }

        if ($id === null) {
            $model = new $editClass;
            $model->setScenario($editClass::SCENARIO_INSERT);
        } else {
            $model = $editClass::findOne($id);
            $model->setScenario($editClass::SCENARIO_UPDATE);
        }

        $shortClassName = ClassFactory::getShortName($className);
        if (!empty($_GET[$shortClassName])) {
            // Get default model params
            $model->load(Yii::$app->request->get());
        }

        if (!$editClass->hasAccess()) {
            throw new HttpException(400, 'Can\'t edit this object');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->setStatusCode(201);
                Yii::$app->end();
            } else {
                return $this->redirect([self::VIEW_ACTION_NAME, 'className' => $className, 'id' => $model->primaryKey]);
            }
        }

        return $this->render('@vendor/vsevolod-ryzhov/yii2-ar-control/src/views/edit', [
            'model' => $model,
            'shortClassName' => $shortClassName,
            'attributes' => $editClass->scenarios()[$editClass->getScenario()],
            'types' => $editClass->attributeTypes()
        ]);
    }

    /**
     * @param $className
     * @param $id
     * @return Response
     * @throws HttpException
     */
    public function actionDelete($className, $id): Response
    {
        $classes = ClassFactory::getByOriginalClassName($className);
        $editClass = $classes->getEditableClass();
        if (!$editClass) {
            throw new HttpException(400, 'Delete object is not permitted');
        }

        $model = $className::findOne($id);
        if (empty($model)) {
            throw new HttpException(404, 'Object not found');
        }
        $model->delete();
        return $this->redirect([self::GRID_ACTION_NAME, 'className' => $className]);
    }
}
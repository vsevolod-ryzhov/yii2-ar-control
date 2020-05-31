<?php /** @noinspection MissedViewInspection */

declare(strict_types=1);


namespace vsevolodryzhov\yii2ArControl;

use HttpException;
use Yii;
use yii\web\Controller;

/**
 * This trait includes base actions with CRUD functions: grid, view, edit
 * Trait ArControlTrait
 * @package vsevolodryzhov\yii2ArControl
 */
abstract class AbstractArController extends Controller
{
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
            throw new HttpException(400, 'Searchable class doesn\'t exist');
        }

        $model = $searchableClass::findOne($id);
        if (empty($model)) {
            throw new HttpException(404, 'Object not found');
        }

        $editClass = $classes->getEditableClass();

        $canEdit = ($editClass && $editClass->hasAccess());

        return $this->render('@vendor/vsevolod-ryzhov/yii2-ar-control/src/views/item', [
            'model' => $model,
            'className' => $className,
            'canEdit' => $canEdit
        ]);
    }
}
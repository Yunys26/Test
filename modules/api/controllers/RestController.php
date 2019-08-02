<?php


namespace app\modules\api\controllers;


use app\modules\api\models\Entity;
use app\modules\api\repository\Repository;
use yii\filters\ContentNegotiator;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class RestController extends Controller {

    // MARK: - Properties

    public $data = null;

    /**
     * @var Repository
     */
    public $repo;

    // MARK: - System

    public function behaviors() {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    public function beforeAction($action) {
        $this->buildData();
        $this->repo = new Repository();
        return parent::beforeAction($action);
    }

    public function successResult(Entity $object): array {
        return ['result' => 'success'] + $object->toArray();
    }

    public function errorResult(string $message): array {
        return [
            'result' => 'fail',
            'message' => $message
        ];
    }

    // MARK: - Private

    private function buildData() {
        $input = file_get_contents('php://input');
        $this->data = ArrayHelper::toArray(Json::decode($input));
    }

}
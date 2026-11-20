<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action): bool
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * GET /api/health — confirms the backend runs and can reach the DB.
     */
    public function actionHealth(): array
    {
        $db = 'not configured';
        if (Yii::$app->has('db')) {
            try {
                Yii::$app->db->createCommand('SELECT 1')->queryScalar();
                $db = 'ok';
            } catch (\Throwable $e) {
                Yii::error($e->getMessage(), __METHOD__);
                $db = 'error';
            }
        }

        return [
            'status' => 'ok',
            'php' => PHP_VERSION,
            'db' => $db,
        ];
    }
}

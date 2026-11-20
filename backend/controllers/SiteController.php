<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

/**
 * Serves the built Vue application for every non-API route, so that
 * client-side (history mode) routes survive a page reload.
 */
class SiteController extends Controller
{
    public $layout = false;

    public function actionIndex(): string
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->set('Content-Type', 'text/html; charset=UTF-8');

        $index = Yii::getAlias('@webroot/dist/index.html');
        if (!is_file($index)) {
            Yii::$app->response->statusCode = 503;
            return 'Frontend is not built. Run "npm run build" in frontend/.';
        }

        return file_get_contents($index);
    }
}

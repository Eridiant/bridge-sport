<?php

namespace frontend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use Mpdf\Mpdf;

/**
 * Site controller
 */
class PdfController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    private function extractDataFromPDF($pdfFilePath) {
        $mpdf = new Mpdf();
        $mpdf->SetImportUse();
    
        $pageCount = $mpdf->SetSourceFile($pdfFilePath);
        $textData = '';
    
        for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
            $pageData = $mpdf->ImportPage($pageNumber);
            $textData .= $pageData;
        }
    
        $mpdf->close();
    
        return $textData;
    }

    public function actionView($slug)
    {
        $this->layout = ('@app/views/layouts/pdf');
        // Check if the file exists
        $filePath = Yii::getAlias('/frontend/web/pdf/' . $slug . '.pdf');
        // var_dump('<pre>');
        // var_dump($filePath);
        // var_dump('</pre>');
        // die;
        
        // if (!file_exists($filePath) || !is_file($filePath)) {
        //     throw new NotFoundHttpException('The requested PDF file does not exist.');
        // }

        return $this->render('view', compact('filePath'));
    }
}
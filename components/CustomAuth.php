<?php
namespace app\components;

use app\models\User;
use Yii;
use yii\filters\auth\AuthMethod;

class CustomAuth extends AuthMethod
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $user_id = $_REQUEST['user_id'];
        if ($user_id != null || $user_id != "") {
            $data = User::findOne(['id' => $user_id]);
            if ($data != null) {
                Yii::$app->user->login($data);
                return $data;
            }
        }
        return null;
    }

    public static function auth($id)
    {
        return $id;
    }
}

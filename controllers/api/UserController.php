<?php
namespace app\controllers\api;

use app\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class UserController extends \yii\rest\ActiveController
{
    public $modelClass = "app\models\User";

    public function actions()
    {
        $parent = parent::actions();
        unset($parent['index']);
        unset($parent['view']);
        unset($parent['create']);
        unset($parent['update']);
        unset($parent['delete']);

        return $parent;
    }
    public function actionLogin()
    {
        if ($_POST) {
            $user = User::find()->where(['username' => $_POST['username']])->one();

            if ($user) {
                if ($user->password == md5($_POST['password'])) {
                    $data_user = [
                        "id" => $user->id,
                        "role_id" => $user->role->id,
                        "role_name" => $user->role->name,
                        "email" => $user->email,
                        "username" => $user->username,
                        "name" => $user->username,
                        "photo_url" => Url::base(true) . "/uploads/" . $user->photo_url,
                    ];
                    return [
                        "success" => true,
                        "message" => "Login berhasil",
                        "data" => $data_user,
                    ];
                }
            }

            return [
                "success" => false,
                "message" => "Login gagal",
            ];
        }
    }

    
    public function actionProfile()
    {
        $model = User::find()->where(["id"=> $_POST['user_id'] ])->one();
        if($model == []){
            return[
                "success" => false,
                "message" => "Data tidak ditemukan"
            ];
        }
        $oldMd5Password = $model->password;
        $oldPhotoUrl = $model->photo_url;
        $oldTtd = $model->ttd;

        $model->password = "";

        if ($model->load($_POST)){
            //password
            if($model->password != ""){
                $model->password = md5($model->password);
            }else{
                $model->password = $oldMd5Password;
            }

            # get the uploaded file instance
            $ttd = UploadedFile::getInstance($model, 'ttd');
            $image = UploadedFile::getInstance($model, 'photo_url');
            $model->photo_url = $this->uploadFile($image, $oldPhotoUrl);
            $model->ttd = $this->uploadFile($ttd, $oldTtd);

            if($model->save()){
                return [
                    "success" => true,
                    "message" => "Profile successfully updated."
                ];
            }else{
                return [
                    "success" => true,
                    "message" => "Profile cannot updated."
                ];
            }
        }
    }
    
    public function uploadFile($image, $default = "default.png", $path = "@app/web/uploads/"){
        if ($image != NULL) {
            # store the source file name
            $foto = $image->name;
            $arr = explode(".", $image->name);
            $extension = end($arr);

            # generate a unique file name
            $foto = Yii::$app->security->generateRandomString() . ".{$extension}";

            # the path to save file
            $path = Yii::getAlias($path) . $foto;
            $image->saveAs($path);
        } else {
            $foto = $default;
        }

        return $foto;
    }
}

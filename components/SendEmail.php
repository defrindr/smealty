<?php
namespace app\components;

use dmstr\helpers\Html;
use Yii;
use yii\helpers\Url;

class SendEmail
{
    public static function with($model, $list_user, $msg = null)
    {
        foreach ($list_user as $user) {
            $role = $user->role->name;
            $subject = isset($msg) ? $msg : "Halo $role, Pengajuan \"{$model->nama_pengajuan}\" perlu persetujuan anda.";

            $isi = $subject . '<table>
                <tbody>
                    <tr>
                        <td>Nama Pengajuan</td>
                        <td>:</td>
                        <td>' . $model->nama_pengajuan . '</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>' . Tanggal::toReadableDate($model->tanggal) . '</td>
                    </tr>
                    <tr>
                        <td>Kategori Peralatan</td>
                        <td>:</td>
                        <td>' . $model->kategoriperalatan->nama_kategori_peralatan . '</td>
                    </tr>
                    <tr>
                        <td>Peralatan</td>
                        <td>:</td>
                        <td>' . $model->peralatan->nama_peralatan . '</td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td>:</td>
                        <td>' . Angka::toReadableHarga($model->harga_estimasi) . '</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>' . $model->keterangan . '</td>
                    </tr>
                    <tr>
                        <td>Foto</td>
                        <td>:</td>
                        <td>' . Html::img(["uploads/" . $model->foto], ["width" => "150px"]) . '</td>
                    </tr>
                    <tr>
                        <td>Action</td>
                        <td>:</td>
                        <td><a style="background:#B45745;color:#fff;padding:10px 40px;" href="' . Url::base(true) . '/pengajuan/view/' . $model->id . '">Lihat</a></td>
                    </tr>
                </tbody>
            </table>';

            if ($user->email != null) {
                Yii::$app->mailer->compose()
                    ->setFrom('mkhamimjazuli@gmail.com')
                    ->setTo($user->email)
                    ->setSubject($subject)
                    ->setHtmlBody($isi)
                    ->send();
            }
        }
    }

    public static function reject($model, $reject_by)
    {
        $name = $model->createdBy->name;
        $subject = "Halo $name, Pengajuan \"{$model->nama_pengajuan}\" perlu revisi anda.";

        $isi = $subject . '<table>
                <tbody>
                    <tr>
                        <td>Nama Pengajuan</td>
                        <td>:</td>
                        <td>' . $model->nama_pengajuan . '</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>' . Tanggal::toReadableDate($model->tanggal) . '</td>
                    </tr>
                    <tr>
                        <td>Kategori Peralatan</td>
                        <td>:</td>
                        <td>' . $model->kategoriperalatan->nama_kategori_peralatan . '</td>
                    </tr>
                    <tr>
                        <td>Peralatan</td>
                        <td>:</td>
                        <td>' . $model->peralatan->nama_peralatan . '</td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td>:</td>
                        <td>' . Angka::toReadableHarga($model->harga_estimasi) . '</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>' . $model->keterangan . '</td>
                    </tr>
                    <tr>
                        <td>Komentar</td>
                        <td>:</td>
                        <td>' . $model->komentar . '</td>
                    </tr>
                    <tr>
                        <td>Foto</td>
                        <td>:</td>
                        <td>' . Html::img(["uploads/" . $model->foto], ["style" => "width:150px;height:auto;margin:20px"]) . '</td>
                    </tr>
                    <tr>
                        <td>Action</td>
                        <td>:</td>
                        <td><a style="background:#B45745;color:#fff;padding:10px 40px;" href="' . Url::base(true) . '/pengajuan/view/' . $model->id . '">Lihat</a></td>
                    </tr>
                </tbody>
            </table>';

        if ($model->createdBy->email != null) {
            Yii::$app->mailer->compose()
                ->setFrom('mkhamimjazuli@gmail.com')
                ->setTo($model->createdBy->email)
                ->setSubject($subject)
                ->setHtmlBody($isi)
                ->send();
        }
    }
}

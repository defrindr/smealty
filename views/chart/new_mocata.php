<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

app\assets\AppAsset::register($this);
// dmstr\web\AdminLteAsset::register($this);
// \app\assets\AdminLtePluginAsset::register($this);

?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">

<head>
    <link rel="icon" type="image/png" href=<?=\Yii::$app->request->baseUrl . "/uploads/" . $modelTentang->logo?> />
    <meta charset="<?=Yii::$app->charset?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <title><?=Html::encode($this->title)?></title>
    <script>
        var baseUrl = "<?=Yii::$app->urlManager->baseUrl?>";
    </script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400;0,500;0,700;1,400&display=swap"
        rel="stylesheet">
    <style>
        html,
        body {
            height: auto !important;
        }

        .box {
            background: rgba( 236, 229, 229, 0.25 );
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
            backdrop-filter: blur( 20.0px );
            -webkit-backdrop-filter: blur( 20.0px );
            border-radius: 10px;
            border: 1px solid rgba( 255, 255, 255, 0.18 );
        }

        body {
            height: auto;
            background-color: rgb(83, 163, 224) !important;
            /* background-image: url("<?=Yii::$app->urlManager->baseUrl?>/uploads/logo/bg-web.png"); */
            background-size: cover;
            background-repeat: no-repeat;
            font-size: 5rem;
            font-weight: bold;
            font-family: 'Arimo', sans-serif !important;
            color: #fff !important;
        }

        h1 {
            font-size: 6.5rem !important;
            /* font-family: 'Arimo', sans-serif !important; */
        }

        h3 {
            font-size: 4rem !important;
            font-family: 'Arimo', sans-serif !important;
        }

        img {
            border-radius: 15px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 5px;
        }

        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            border-top: 0 !important;
        }

        .box {
            border-radius: 15px;
            /* box-shadow: 0 2px 5px 2px #efefef; */
            height: 100%;
            margin-bottom: 5%;
        }

        .box-body {
            padding: 15px;
            height: 100%;
        }

        /* .row {
            display: table;
        }

        [class*="col-"] {
            float: none;
            display: table-cell;
            vertical-align: top;
        } */
    </style>
    <?php $this->head()?>
</head>

<body class="m-3">
    <?php $this->beginBody()?>
    <div class="container-fluid">
        <div class="row" style="height: 100%">

            <div class="col-md-12">
                <div class="text-center" style="margin-top: 2%;margin-bottom: 1%;">
                    <h1>MONITORING SMEALTHY</h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6 text-left">
                    <h3 style="margin: 4rem 0;">Pengujung Hari ini : <span id="total_pengujung">0</span> Orang</h3>
                </div>
                <div class="col-md-6 text-right">
                    <h3 style="margin: 4rem 0;" id="time"> 0000-00-00 00:00:00</h3>
                </div>
            </div>

            <div class="col-lg-12 text-center">
            </div>
            <div class="col-md-7">
                <div class="box" id="color">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <img src="https://2.bp.blogspot.com/-muVbmju-gkA/Vir94NirTeI/AAAAAAAAT9c/VoHzHZzQmR4/s580/placeholder-image.jpg"
                                    alt="" class="img img-responsive" id="first_paint_image"
                                    style="height: 200px;margin: auto">
                            </div>
                            <div class="col-lg-12">
                                <div class="text-justify">
                                    <table class="table table-borderless table-stripped" style="font-size: 2.8rem;">
                                        <tr>
                                            <td>
                                                Piezoelektrik
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <span id="first_tegangan_piezoelektrik">0</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Tanggal
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <span id="first_date">2020-02-02</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Waktu
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <span id="first_time">12:00 AM</span>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td colspan="3" class="text-center">
                                                <span id="first_message"></span>
                                            </td>
                                        </tr> -->
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h3 id="first_message" class="text-center"></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div id="container"></div>
            </div>
        </div>
    </div>
    <?php $this->endBody()?>
</body>
<script>
    function firstData(data) {
        let first_piezoelektrik = $("#first_piezoelektrik");
        let date = $("#first_date");
        let time = $("#first_time");
        let first_image = $("#first_image");
        let first_message = $("#first_message");
        let first_color = $("#color");
        
        first_piezoelektrik.text(data.first_piezoelektrik);
        date.text(data.date);
        time.text(data.time);
        first_message.text(data.first_message);


        first_image.attr("src", data.foto);
        if (data.status == "fail") {
            first_color.attr("style", "background: rgba( 230, 38, 38, 0.25 );");
            first_message.attr("class", "text-center text-danger");
        } else {
            first_color.attr("style", "background: rgba( 236, 229, 229, 0.25 );");
            first_message.attr("class", "text-center text-white");
            // first_message.attr("class", "text-success");
        }
        first_message.text(data.message);

    }

    function moreData(data) {
        let result = "";
        let container = $("#container");
        data.map(item => {
            let messageColor = "";
            let bgColor = "";
            if (item.status == "fail") {
                bgColor = "background: rgba( 230, 38, 38, 0.25 );";
                messageColor = "text-danger";
            } else {
                bgColor = "background: rgba( 236, 229, 229, 0.25 );";
                messageColor = "text-white";
            }
            result += `
            <div class="row" style="height: 100%">
                <div class="col-md-12">
                    <div class="box" style="${bgColor}">
                        <div class="box-body">
                            <div class="row" style="height: 100%">
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <img src="${item.foto}" alt="${item.date}"
                                        class="img img-responsive">
                                </div>
                                <div class="col-sm-8 col-md-8 col-lg-8">
                                    <table class="table table-borderless table-stripped" style="font-size: 1.9rem">
                                    <tr>
                                            <td>
                                                Piezoelektrik
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <span>${item.tegangan_piezoelektrik}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Tanggal
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <span>${item.date}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Waktu
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <span>${item.time}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="text-center ${messageColor}" style='font-size: 2.5rem !important'>${item.message}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });

        container.html(result);
    }

    function loadData(data) {
        let first_data = data[0];
        data.shift(); // remove first data
        let more_data = data;

        firstData(first_data);
        moreData(more_data);
    }

    function formatDate() {
        const monthNames = [
            "Januari", "Februari", "maret", "April", "Mei", "Juni",
            "Juli", "Augustus", "September", "Oktober", "November", "Desember"
        ];
        var d = new Date(),
            month = '' + monthNames[d.getMonth()],
            day = '' + d.getDate(),
            year = d.getFullYear(),
            time = d.toLocaleTimeString(navigator.language, {
                hour: '2-digit',
                minute:'2-digit'
            }).replace(".", ":");

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [time, day, month, year].join(' ');
    }

    function init() {
        fetch("<?=Url::to(['api/pengunjung/list-data'])?>")
            .then(res => res.json())
            .then(res => {
                loadData(res.data)
                $("#total_pengujung").text(res.count_today);
                $("#time").text(formatDate());

            });
    }

    init(); // first load

    setInterval(() => {
        init();
    }, 3000);
</script>

</html>
<?php $this->endPage()?>
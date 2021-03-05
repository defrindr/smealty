<?php
namespace app\components;

class Constant {
    const STATUS_BARU = 1;
    const STATUS_ACC_SPV = 2;
    const STATUS_ACC_MGR = 3;
    const STATUS_ACC_DBM = 4;
    const STATUS_ACC_BM = 5;
    const STATUS_ACC_FRAINCHIESE = 6;
    const STATUS_SELESAI = 6;
    const STATUS_TOLAK = 7;


    const ROLE_USER = 3;
    const ROLE_SA = 1;
    const ROLE_SPV = 4;
    CONST ROLE_FRAINCAISE = 12;
    CONST ROLE_MGR = 2;
    CONST ROLE_DBM = 9;
    CONST ROLE_BM = 11;

    const AKTIVA_TAHUN = [
        2019 => "J",
        2020 => "K",
        2021 => "L",
        2022 => "M",
        2023 => "N",
        2024 => "O",
    ];

    const ROLE_DIVISION = [
        Constant::ROLE_USER,
        Constant::ROLE_SPV,
        Constant::ROLE_MGR
    ];

    const ACTION_ALLOW = [Constant::STATUS_BARU, Constant::STATUS_SELESAI, Constant::STATUS_TOLAK];
    const ACTION_ALLOW_INDEX = [Constant::STATUS_SELESAI, Constant::STATUS_TOLAK];

}
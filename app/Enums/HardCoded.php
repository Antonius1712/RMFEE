<?php
namespace App\Enums;

final class HardCoded {
    CONST NBRN = [
        'NB' => 'NB',
        'RN' => 'RN'
    ];

    CONST statusPremi = [
        'PAID',
        'UNPAID'
    ];

    CONST statusRealisasi = [
        'NEW',
        'DRAFT',
        'WAITING APPROVAL',
        'APPROVED',
        'REJECT',
        'ARCHIVE'
    ];

    CONST statusBudget = [
        'NEW',
        'DRAFT',
        'WAITING APPROVAL',
        'APPROVED',
        'REJECT',
        'ARCHIVE'
    ];

    CONST COB = [
        '01-PROPERTY' => '01-PROPERTY',
        '02-MOTOR VEHICLE' => '02-MOTOR VEHICLE'
    ];
}
?>
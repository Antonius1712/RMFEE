<?php
namespace App\Enums;

final class RealizationStatus {
    const DRAFT = 'DRAFT';
    const WAITING_APPROVAL_BU = 'WAITING APPROVAL BU';
    const WAITING_APPROVAL_FINANCE = 'WAITING APPROVAL FINANCE';
    const APPROVED_BY_FINANCE = 'APPROVED BY FINANCE';
    const ARCHIVED = 'ARCHIVED';
    const REJECTED = 'REJECTED';
}
?>
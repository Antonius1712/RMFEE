<?php
namespace App\Enums;

final class BudgetStatus {
    const DRAFT = 'DRAFT';
    const WAITING_APPROVAL = 'WAITING APPROVAL';
    const APPROVED = 'APPROVED';
    const ARCHIVED = 'ARCHIVED';
    const REJECTED = 'REJECTED';

    const OVERLIMIT = 'OVERLIMIT';
    const NOTOVERLIMIT = 'NOT OVERLIMIT';
}
?>
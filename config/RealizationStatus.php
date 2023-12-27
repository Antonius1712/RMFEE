<?php

use App\Enums\RealizationStatus;

return [
    'DRAFT' => RealizationStatus::DRAFT,
    'WAITINGAPPROVALBU' => RealizationStatus::WAITING_APPROVAL_BU,
    'WAITINGAPPROVALFINANCE' => RealizationStatus::WAITING_APPROVAL_FINANCE,
    'APPROVEDBYFINANCE' => RealizationStatus::APPROVED_BY_FINANCE,
    'ARCHIVED' => RealizationStatus::ARCHIVED,
    'REJECTED' => RealizationStatus::REJECTED,
]

?>
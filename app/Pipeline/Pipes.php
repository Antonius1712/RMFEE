<?php
namespace App\Pipeline;

use App\Pipeline\Budget\PrepareDataBudget;
use App\Pipeline\Budget\UpdateDataBudget;
use App\Pipeline\Realization\ProcessDataRealization;

class Pipes {
    CONST BUDGET_PIPELINE = [
        PrepareDataBudget::class,
        UpdateDataBudget::class
    ];

    CONST REALIZATION_PIPELINE = [
        ProcessDataRealization::class,
    ];
}
?>
<?php

namespace App\Model;

use App\Enums\Database;
use Illuminate\Database\Eloquent\Model;

class ReportGenerator_Documents_Engineering_Fee extends Model
{
    protected $connection = Database::REPORT_GENERATOR;
    protected $table = 'Documents_Engineering_Fee';
    protected $primaryKey = 'id'; // Set the primary key field

    // Optional: Define fillable or guarded properties for mass assignment
    protected $fillable = [
        'DocumentName', 'DocumentDescription', 'DocumentFile', 'UploadedBy', 'UploadedAt'
    ];

    // Optional: Disable timestamps if your table doesn't have created_at and updated_at fields
    public $timestamps = false;

}

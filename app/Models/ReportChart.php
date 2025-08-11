<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportChart extends Model
{
    use HasFactory;
    protected $table = "report_charts";
    protected $guarded = ['id'];
    public $timestamps = false;
}

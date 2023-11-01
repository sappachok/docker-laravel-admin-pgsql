<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KongLogs extends Model
{
    protected $table = 'kong_logs';

    protected $fillable = [
        "log_detail",
        "service",
        "request",
        "consumer",
        "upstream_uri",
        "agent_sender",
        "ip_sender",
        "create_datetime"
    ];

    protected $casts = [
        'consumer' => 'json',
        'request' => 'json',
        'service' => 'json',
        'upstream_uri' => 'json'
    ];

}

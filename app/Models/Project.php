<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'project_start_date' => 'datetime',
        'project_end_date' => 'datetime',
    ];
    public $dates = ['project_start_date', 'project_end_date'];

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
}

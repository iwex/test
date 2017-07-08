<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilesHistory extends Model
{
    protected $table = 'files_history';
    
    protected $guarded = ['id'];
}

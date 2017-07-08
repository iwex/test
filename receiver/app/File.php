<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = ['id'];
    
    /**
     * Encode array to json
     *
     * @param array $files
     */
    public function setContentAttribute(array $files)
    {
        $this->attributes['content'] = json_encode($files);
    }
}

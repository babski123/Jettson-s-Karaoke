<?php

namespace App\Models;

use CodeIgniter\Model;

class Songs extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'songs';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['title', 'vid'];
}

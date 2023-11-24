<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'notes';

    /**
     * The primary key associated with the table.
     * 
     * @var string
     */
    protected $primaryKey = 'note_id';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = [
      'notes',
      'user_id',
      'notes_title'
    
    ];
}

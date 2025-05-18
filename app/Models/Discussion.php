<?php
// app/Models/Discussion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $table = 'program_discussions'; // Explicitly set table name
    
    protected $fillable = ['program_id', 'user_id', 'content'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
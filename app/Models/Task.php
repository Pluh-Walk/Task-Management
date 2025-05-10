<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model

{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date'
    ];

    public function employee(){
    return $this->belongsTo(Employee::class, 'assigned_to');
}


    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function project()
{
    return $this->hasOne(Project::class);
}

}



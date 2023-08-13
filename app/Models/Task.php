<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    public function sbu()
    {
        return $this->belongsTo(Sbu::class, 'sbu_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function stageTracks()
    {
        return $this->hasMany(StageTrack::class, 'task_id', 'task_id');
    }

  

   
}

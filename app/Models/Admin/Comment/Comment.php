<?php

namespace App\Models\Admin\Comment;

use App\Models\Admin\User\User;
use App\Models\Admin\Animal\Animal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'answered_id',
        'body',
        'parent_id',
        'author_id',
        'commentable_id',
        'commentable_type',
        'status',
        'approved',
        'admin_answer',
        'seen'
    ];

    public function answerUser()
    {
        return $this->belongsTo(User::class, 'answered_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }
    public function childs()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function answers()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function adminAnswerParent()
    {
        return $this->hasOne($this, 'admin_answer');
    }

    public function adminAnswerChild()
    {
        return $this->belongsTo($this, 'admin_answer');
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Notifiable;
    //Table name
    protected $table = 'posts';
    //Primary Key
    public $primaryKey = 'id';
    //Timestamps
    public $timestamps = true;

    protected $fillable = [
        // 'id',
        'title',
        'body',
        'post_user_id',
        'post_user_name',
        'user_id',
        'file',
        'image',
        // 'register_by',
        // 'modified',
        // 'modified_by',
        // 'record_deleted',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function posts(){
        return $this->belongsTo('App\User');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }
}

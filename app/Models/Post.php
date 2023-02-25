<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags'];

    public function scopeFilter($query, array $filters) {
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }
    
        if($filters['search'] ?? false) {
            $query->where(function($query) {
                $query->where('title', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%')
                    ->orWhere('tags', 'like', '%' . request('search') . '%')
                    ->orWhereHas('categories', function($query) {
                        $query->where('name', 'like', '%' . request('search') . '%');
                    });
            });
        }
    }
    

    // Relationship To User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Categories::class);
    }
    public function comments()
{
    return $this->hasMany(Comment::class);
}
}

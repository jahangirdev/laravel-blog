<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', 'subcategory_id', 'user_id', 'title', 'slug', 'excerpt', 'content', 'post_date', 'thumbnail', 'tags', 'status'
    ];
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subcategory(){
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}

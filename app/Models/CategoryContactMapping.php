<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CategoryContactMapping extends Model
{
    protected $table = 'category_contact_mapping';

    protected $fillable = [
        'category_id', 'contact_id'
    ];
}
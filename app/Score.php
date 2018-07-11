<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
  protected $table = 'scores';
  protected $fillable = [
  'score', 'admin_id', 'master_id','area_id','date', 'header_id'
  ];
  protected $primaryKey = 'score_id';
}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'campaign';

	protected $fillable = ['title', 'about'];

	public function supporters() {
        return $this->belongsToMany('User');
    }
}

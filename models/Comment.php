<?php namespace Wiz\Comments\Models;

use Model;
use BackendAuth;

class Comment extends Model
{
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\SimpleTree;

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public $table = 'wiz_comments_comments';

    public $belongsTo = [
        'author' => [
            'Backend\Models\User',
            'key' => 'author_id'
        ],
    ];

    public $morphTo = [
        'commentable' => []
    ];

    public function beforeCreate()
    {
        $user = BackendAuth::getUser();
        if ($user)
            $this->author_id = $user->id;
    }
}
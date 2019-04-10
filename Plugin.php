<?php namespace Wiz\Comments;

use Backend;
use System\Classes\PluginBase;
use Wiz\Comments\Models\Comment;
use Illuminate\Support\Facades\Event;
use October\Rain\Database\Relations\Relation;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Comentarios',
            'description' => 'Permite la inclusión de comentarios en objetos de datos',
            'author'      => 'Wiz Comunicaciones',
            'icon'        => 'oc-icon-cogs',
            'iconSvg:'    => '/plugins/wiz/onboarding/assets/images/plugin-icon.svg',
            'homepage'    => 'https://github.com/wiz-comunicaciones/plugin-comments'
        ];
    }

    public $commentableModels = [
        Comment::class
    ];

    public function boot()
    {
        Event::fire('wiz.comments.registerCommentable', $this->commentableModels);

        $this->loadPolymorphicRelationMap();
        $this->registerCommentableModels();
    }

    protected function loadPolymorphicRelationMap()
    {
        # Polymorphic relation map (keep keys short)
        Relation::morphMap([
            'comment'   => \Wiz\Comments\Models\Comment::class,
        ]);
    }

    protected function registerCommentableModels()
    {
        # Add the relation to all model classes available in $commentableModels
        foreach ($this->commentableModels as $modelClass){

            # Extend the model with the Comments morph relation
            $modelClass::extend(function($model) {
                $model->morphMany['comments'] = [
                    'Wiz\Comments\Models\Comment',
                    'name' => 'commentable',
                ];
            });
        }
    }

    /**
     * In the boot method of your Plugin.php file, add something like this
     *
     * public function boot()
     * {
     *      Event::listen('wiz.comments.registerCommentable', function($commentModelArray) {
                array_push($commentModelArray, 'Acme\Plugin\Models\Model');
     *      });
     * }
     */
}
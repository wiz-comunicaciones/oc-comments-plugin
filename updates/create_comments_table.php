<?php namespace Wiz\Wlaver\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration101 extends Migration
{
    public function up()
    {
        Schema::create('wiz_comments_comments', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('author_id')->nullable()->unsigned();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->integer('commentable_id')->nullable()->unsigned();
            $table->string('commentable_type')->nullable();
            $table->text('content')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wiz_comments_comments');
    }
}
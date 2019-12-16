<?php

use App\Models\Common\Attachment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $userClass = Attachment::getAuthModelName();
        $userModel = new $userClass();

        Schema::create(Attachment::getModel()->getTable(), function (Blueprint $table) use ($userModel) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references($userModel->getKeyName())->on($userModel->getTable())->onDelete('set null');
            $table->bigInteger('model_id')->unsigned()->nullable();
            $table->string('model_type')->nullable();
            $table->string('path');
            $table->string('name')->nullable();
            $table->string('original_name');
            $table->string('extension');
            $table->string('mime_type')->nullable();
            $table->integer('size')->unsigned();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}

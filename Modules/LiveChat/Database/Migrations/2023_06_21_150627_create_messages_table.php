<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->boolean('is_seen')->default(0);
            $table->boolean('deleted_from_sender')->default(0);
            $table->boolean('deleted_from_receiver')->default(0);

            $table->foreignId('sender_id')->nullable();
            $table->foreignId('receiver_id')->nullable();
            $table->timestamps();
        });

        $attributes = [
            'live_chat' => ['read' => 'livechat_read', 'create' => 'livechat_create', 'settings' => 'livechat_settings'],
        ];

        // foreach ($attributes as $key => $attribute) {
        //     $permission = new \App\Models\Permission();
        //     $permission->attribute = $key;
        //     $permission->keywords = $attribute;
        //     $permission->save();
        // }
        // foreach (\App\Models\User::where('role_id', 1)->get() as $user) {
        //     $user->permissions = array_merge($user->permissions, array_values($permission));
        //     $user->save();
        // }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};

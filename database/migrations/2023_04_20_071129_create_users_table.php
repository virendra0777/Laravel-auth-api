<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('_id');
            $table->string('firstname',50);
            $table->string('lastname',50);
            $table->string('username',20);
            $table->string('dob',10);
            $table->string('mobile',15);
            $table->string('email',100);
            $table->string('referal_code',100);
            $table->string('referal_user',100)->nullable();
            $table->enum('email_verified',[1,0])->default(0)->comment('1 => verified, 0 => unverified');
            $table->enum('mobile_verified',[1,0])->default(0)->comment('1 => verified, 0 => unverified');
            $table->string('profilepic',100)->nullable();
            $table->string('appId',100)->nullable();
            $table->enum('gender',['m','f','o']);
            $table->enum('login_with',['app','google','fb','ios'])->default('app');
            $table->decimal('deposite_amount', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('winning_amount', $precision = 10, $scale = 2)->default(0.00);
            $table->decimal('bonus', $precision = 8, $scale = 2)->default(0.00);
            $table->enum('role',['user','admin'])->default('user');
            $table->integer('email_otp');
            $table->integer('mobile_otp');
            $table->string('password',100);
            $table->enum('status',[1,0])->default(0)->comment('1 => active, 0 => inactive');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        DB::table('users')->insert(
            [
                [
                    'firstname' => 'admin',
                    'lastname' => 'admin',
                    'username' => 'SuperAdmin',
                    'dob' => '2023-04-26',
                    'mobile' => '0000000000',
                    'email' => 'sportsapp@admin.com',
                    'referal_code' => 'XXXXXXXXXXXX',
                    'referal_user' => 'XXXXXXXXXXXX',
                    'email_verified' => 1,
                    'mobile_verified' => 1,
                    'role' => 'admin',
                    'email_otp' => 0,
                    'mobile_otp' => 0,
                    'password' => Hash::make('Test@123#')
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

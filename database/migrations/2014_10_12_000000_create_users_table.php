<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{

        $tableNamesCatalogos = config('pigsei.table_names.catalogos');
        $tableNames = config('pigsei.table_names.users');

        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nombre')->nullable();
            $table->string('ap_paterno')->nullable();
            $table->string('ap_materno')->nullable();
            $table->string('curp',18)->default('')->nullable();
            $table->string('emails',500)->default('')->nullable();
            $table->string('celulares',250)->default('')->nullable();
            $table->string('telefonos',250)->default('')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->smallInteger('genero')->default(0)->nullable();
            $table->string('root',150)->default('')->nullable();
            $table->string('filename',50)->nullable();
            $table->string('filename_png',50)->nullable();
            $table->string('filename_thumb',50)->nullable();
            $table->boolean('admin')->default(false);
            $table->boolean('alumno')->default(false);
            $table->boolean('delegado')->default(false);
            $table->string('session_id')->nullable();
            $table->unsignedInteger('ubicacion_id')->default(0)->index();
            $table->unsignedInteger('imagen_id')->default(0)->index();
            $table->uuid('uuid')->default(DB::raw('uuid_generate_v4()'))->unique();
            $table->unsignedSmallInteger('status_user')->default(1)->nullable();
            $table->unsignedSmallInteger('empresa_id')->default(0)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->index('empresa_id');
            $table->boolean('logged')->default(false)->index();
            $table->timestamp('logged_at')->nullable()->index();
            $table->timestamp('logout_at')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

        });

        Schema::create($tableNames['user_adress'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->string('calle',250)->default('')->nullable();
            $table->string('num_ext',100)->default('')->nullable();
            $table->string('num_int',100)->default('')->nullable();
            $table->string('colonia',150)->default('')->nullable();
            $table->string('localidad',150)->default('')->nullable();
            $table->string('municipio',50)->default('')->nullable();
            $table->string('estado',50)->default('TABASCO')->nullable();
            $table->string('pais',25)->default('MÉXICO')->nullable();
            $table->string('cp',10)->default('')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['user_extend'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->string('ocupacion',250)->default('')->nullable();
            $table->string('profesion',250)->default('')->nullable();
            $table->string('lugar_trabajo',250)->default('')->nullable();
            $table->string('lugar_nacimiento',250)->default('')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['categorias'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoria',150)->default('')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('logs', function (Blueprint $table) use ($tableNamesCatalogos){
            $table->id();
            $table->string('model_name',128)->default('');
            $table->integer('model_id')->default(0);
            $table->integer('trigger_type')->default(0);
            $table->string('trigger_status',128)->default('');
            $table->string('message',500)->default('');
            $table->string('icon',25)->default('');
            $table->string('status',5)->default('');
            $table->datetime('fecha')->default(now());
            $table->string('ip',250)->default('');
            $table->string('host',250)->default('');
            $table->integer('user_id')->default(0)->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNamesCatalogos['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNamesCatalogos['imagenes'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->dateTime('fecha')->nullable();
            $table->string('root',150)->default("")->nullable();
            $table->string('image',100)->default("")->nullable();
            $table->string('image_thumb',100)->default("")->nullable();
            $table->string('titulo',150)->default("")->nullable();
            $table->string('descripcion',500)->default("")->nullable();
            $table->string('momento',10)->default("ANTES")->nullable();
            $table->unsignedInteger('user__id')->default(0)->index();
            $table->unsignedInteger('denuncia__id')->default(0)->index();
            $table->unsignedInteger('parent__id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableNamesCatalogos['imagene_parent'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('imagene_id')->default(0)->index();
            $table->unsignedInteger('imagen_parent_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique([ 'imagene_id','imagen_parent_id']);

            $table->foreign('imagene_id')
                ->references('id')
                ->on($tableNamesCatalogos['imagenes'])
                ->onDelete('cascade');

            $table->foreign('imagen_parent_id')
                ->references('id')
                ->on($tableNamesCatalogos['imagenes'])
                ->onDelete('cascade');

        });

        Schema::create($tableNamesCatalogos['imagene_user'], function (Blueprint $table) use ($tableNamesCatalogos){
            $table->increments('id');
            $table->unsignedInteger('imagene_id')->default(0)->index();
            $table->unsignedInteger('user_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique([ 'imagene_id','user_id']);

            $table->foreign('imagene_id')
                ->references('id')
                ->on($tableNamesCatalogos['imagenes'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNamesCatalogos['users'])
                ->onDelete('cascade');

        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{

        $tableNamesCatalogos = config('pigsei.table_names.catalogos');
        Schema::dropIfExists($tableNamesCatalogos['logs']);
        Schema::dropIfExists($tableNamesCatalogos['images']);
        Schema::dropIfExists($tableNamesCatalogos['imagene_parent']);
        Schema::dropIfExists($tableNamesCatalogos['imagene_user']);

        $tableNames = config('pigsei.table_names.users');
        Schema::dropIfExists($tableNames['categorias']);
        Schema::dropIfExists($tableNames['user_adress']);
        Schema::dropIfExists($tableNames['user_extend']);
        Schema::dropIfExists($tableNames['users']);

    }
};

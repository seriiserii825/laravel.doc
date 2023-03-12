php artisan make:migration add_store_id_to_users_table --table=users

<?php 
 public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            // 1. Create new column
            // You probably want to make the new column nullable
            $table->integer('store_id')->unsigned()->nullable()->after('password');
            
            // 2. Create foreign key constraints
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            
            // 1. Drop foreign key constraints
            $table->dropForeign(['store_id']);

            // 2. Drop the column
            $table->dropColumn('store_id');
        });
    }

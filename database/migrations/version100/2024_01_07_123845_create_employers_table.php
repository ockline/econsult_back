<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alia');
            $table->integer('reg_no')->unique();
            $table->string('email')->unique();
            $table->string('contact_person');
            $table->string('contact_person_phone');
            $table->integer('tin')->unique();
            $table->integer('osha');
            $table->integer('wcf');
            $table->integer('nssf');
            $table->integer('vrn');
            $table->integer('nhif');
            $table->string('phone');
            $table->string('telephone');
            $table->string('fax');
            $table->integer('bank_id')->unsigned();
            $table->integer('bank_branch_id')->unsigned()->index('bank_branch_id');
            $table->string('account_no');
            $table->string('account_name');
            $table->string('postal_address');
            $table->integer('region_id')->unsigned();
            $table->integer('district_id')->unsigned()->index('district_id');
            $table->integer('location_type_id')->unsigned()->index('location_type_id');
            $table->integer('duplicate_id')->unsigned()->index('duplicate_id')->nullable();
            $table->integer('created_by')->comment('its user id');
            $table->integer('modified_by')->comment('its user id')->nullable();
            $table->string('street')->nullable();
            $table->string('road')->nullable();
            $table->string('plot_number')->nullable();
            $table->string('block_number')->nullable();
            $table->string('source')->default(2)->comment('1 - online (portal), 2 - inside(econsult)');
            $table->integer('working_hours');
            $table->integer('working_days');
            $table->integer('shift_id')->unsigned()->index('shift_id');
            $table->integer('allowance_id')->unsigned()->index('allowance_id');
            $table->integer('active')->default(1);
            $table->string('isonline')->default(0)->comment('0 - No, 1 - yes');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('deleted_by')->comment('its user id')->nullable();
            $table->string('deleted_reason')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('bank_branch_id')->references('id')->on('bank_branches')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('region_id')->references('id')->on('regions')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('location_type_id')->references('id')->on('location_types')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('allowance_id')->references('id')->on('allowances')->onUpdate('CASCADE')->onDelete('RESTRICT');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};

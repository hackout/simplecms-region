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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('社区名称');
            $table->string('city_code')->comment("城市代码");
            $table->string('city')->comment("城市名称");
            $table->string('province_code')->comment("省份名称");
            $table->string('province')->comment("省份名称");
            $table->string('county_code')->comment("县区名称");
            $table->string('county')->comment("县区名称");
            $table->string('address')->comment("地址");
            $table->geography('geo', subtype: 'point')->comment("地理信息");
            $table->string('model_id')->index()->nullable()->comment("模型ID");
            $table->string('model_type')->index()->nullable()->comment('关联类');
            $table->timestamps();
            $table->comment("地理信息储存表");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};

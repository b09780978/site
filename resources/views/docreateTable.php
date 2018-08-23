<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Schema::create('test', function(Blueprint $table){
	// Table definition.
	$table->string('student_id', 20)->unique();
	$table->string('class', 20);
	//->nullable()->change();
	$table->integer('grade')->nullable();
	$table->integer('class_index')->nullable();
	$table->integer('number')->nullable();
	$table->string('name', 30)->nullable();
	$table->string('sex', 10)->nullable();
	$table->string('social_id', 20)->nullable();
	$table->date('birthday')->nullable();
	$table->text('address')->nullable();
	$table->text('phone')->nullable();
	$table->string('guardian', 20)->nullable();
	$table->string('emergency_phone', 20)->nullable();

	$table->primary('student_id');
});
echo "test\n";
?>

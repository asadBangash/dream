<?php

use App\Models\WebsiteSetup\OnlineAdmissionSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_admission_settings', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('online_admission','student_admission');
            $table->string('field')->nullable();
            $table->boolean('is_show')->nullable()->default(true);
            $table->boolean('is_required')->nullable()->default(false);
            $table->boolean('is_system_required')->nullable()->default(false);
            $table->text('field_value')->default(null)->nullable();
            $table->timestamps();
        });

        $fields = ['student_first_name','student_last_name','student_phone','student_email','student_dob','student_document', 'student_photo',
            'session','class','section','shift','gender','religion', 'previous_school','previous_school_info', 'previous_school_doc', 'admission_payment', 'admission_payment_info',
            'place_of_birth','nationality','cpr_no','spoken_lang_at_home','residance_address','father_nationality',
            'gurdian_name','gurdian_email','gurdian_phone','gurdian_photo','gurdian_profession',
            'father_name','father_phone','father_photo','father_profession',
            'mother_name','mother_phone','mother_photo','mother_profession'
        ];

        $system_required_fields = ['student_first_name','student_last_name','session','class','section','gurdian_phone','gurdian_name'];
        $default_required = ['student_first_name','student_last_name','student_email','student_dob','session','class','section','gender','religion','gurdian_name','gurdian_phone'];

        foreach($fields as $field){
            $setting = new OnlineAdmissionSetting();
            $setting->field = $field;
            $setting->type = 'online_admission';
            $setting->is_show = 1;
            $setting->is_required = in_array($field ,$default_required);
            $setting->is_system_required = in_array($field ,$system_required_fields);
            if($field == 'admission_payment_info'){
                $setting->field_value = 'Enter Payment Information ,Bank Name . Swift Code, Account Number, Account Branch Information Or Any kind of special note you can wrote here ';
            }
            $setting->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_admission_settings');
    }
};

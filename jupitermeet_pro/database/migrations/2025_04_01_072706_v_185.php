<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class V185 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // rename golbal_config to settings
        Schema::rename('global_config', 'settings');
        
        // add welcome email to email templates
        DB::table('email_templates')->insert(array(
            array(
                'name' => 'Welcome',
                'slug' => 'welcome',
                'content' => '<p>Hello!&nbsp;[USER_NAME], Welcome to our site.</p>'
            )
        ));

        //  add plan features 
        $plans = Plan::all();

        // add video quality in plan features
        foreach ($plans as $plan) {
            $features = (array) $plan->features;
            $features['video_quality'] = 'VGA';
            $plan->features = (object) $features;
            $plan->update();
        }

        // add user limit in plans if not present in plan features
        foreach ($plans as $plan) {
            $features = (array) $plan->features;
            if (!isset($features['user_limit'])) {  
                $features['user_limit'] = '10';
                $plan->features = (object) $features;
                $plan->update();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

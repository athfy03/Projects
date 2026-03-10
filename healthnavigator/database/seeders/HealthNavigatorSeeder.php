<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthNavigatorSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('session_posteriors')->truncate();
        DB::table('session_answers')->truncate();
        DB::table('assessment_sessions')->truncate();

        DB::table('condition_option_likelihoods')->truncate();
        DB::table('question_options')->truncate();
        DB::table('questions')->truncate();

        DB::table('conditions')->truncate();
        DB::table('categories')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Categories
        $catChronic = DB::table('categories')->insertGetId([
            'name' => 'chronic', 'label' => 'Chronic Conditions', 'created_at'=>now(),'updated_at'=>now()
        ]);
        $catMental = DB::table('categories')->insertGetId([
            'name' => 'mental_health', 'label' => 'Mental Health', 'created_at'=>now(),'updated_at'=>now()
        ]);
        $catInfect = DB::table('categories')->insertGetId([
            'name' => 'infections', 'label' => 'Infections', 'created_at'=>now(),'updated_at'=>now()
        ]);

        $cond = function ($categoryId, $name, $slug, $triage = 'clinic') {
            return DB::table('conditions')->insertGetId([
                'category_id' => $categoryId,
                'name' => $name,
                'slug' => $slug,
                'triage_level' => $triage,
                'prior' => 1.0,
                'description' => null,
                'created_at'=>now(),'updated_at'=>now()
            ]);
        };

        // 3 per bucket
        $hypertension = $cond($catChronic, 'Hypertension', 'hypertension', 'clinic');
        $diabetes     = $cond($catChronic, 'Type 2 Diabetes', 'type-2-diabetes', 'clinic');
        $asthma       = $cond($catChronic, 'Asthma', 'asthma', 'clinic');

        $anxiety      = $cond($catMental, 'Generalized Anxiety', 'anxiety', 'clinic');
        $depression   = $cond($catMental, 'Major Depression', 'depression', 'clinic');
        $panic        = $cond($catMental, 'Panic Attacks', 'panic-attacks', 'clinic');

        $flu          = $cond($catInfect, 'Influenza-like Illness', 'flu', 'self_care');
        $strep        = $cond($catInfect, 'Strep Throat', 'strep', 'clinic');
        $gastro       = $cond($catInfect, 'Gastroenteritis', 'gastroenteritis', 'self_care');

        $allConds     = [$hypertension,$diabetes,$asthma,$anxiety,$depression,$panic,$flu,$strep,$gastro];
        $chronicConds = [$hypertension,$diabetes,$asthma];
        $mentalConds  = [$anxiety,$depression,$panic];
        $infectConds  = [$flu,$strep,$gastro];

        $makeQ = function (string $code, string $text, array $options) {
            $qid = DB::table('questions')->insertGetId([
                'code'=>$code,
                'text'=>$text,
                'is_active'=>true,
                'created_at'=>now(),'updated_at'=>now()
            ]);

            $optIds = [];
            $i = 0;
            foreach ($options as $value => $label) {
                $optIds[$value] = DB::table('question_options')->insertGetId([
                    'question_id'=>$qid,
                    'value'=>$value,
                    'label'=>$label,
                    'sort_order'=>$i++,
                    'created_at'=>now(),'updated_at'=>now()
                ]);
            }
            return [$qid, $optIds];
        };

        $L = function (int $conditionId, int $optionId, float $prob) {
            DB::table('condition_option_likelihoods')->updateOrInsert(
                ['condition_id' => $conditionId, 'question_option_id' => $optionId],
                ['prob' => $prob, 'updated_at' => now()]
            );
        };

        $setDistAll = function (array $conds, array $optMap, array $dist) use ($L) {
            foreach ($conds as $c) {
                foreach ($optMap as $optValue => $optId) {
                    $L($c, $optId, (float)($dist[$optValue] ?? 0.0));
                }
            }
        };

        $setDistCond = function (int $condId, array $optMap, array $dist) use ($L) {
            foreach ($optMap as $optValue => $optId) {
                $L($condId, $optId, (float)($dist[$optValue] ?? 0.0));
            }
        };

        // Starter questions (enough for demo + admin can expand)
        [$qFeeling, $oFeeling] = $makeQ('feeling', 'How are you today?', [
            'good'=>'Good','unwell'=>'Unwell','unsure'=>'Unsure'
        ]);

        [$qDuration, $oDuration] = $makeQ('duration', 'How long have you been feeling this way?', [
            'days'=>'A few days','weeks'=>'A few weeks','months'=>'Months or longer','unsure'=>'Unsure'
        ]);

        [$qFever, $oFever] = $makeQ('fever', 'Do you have a fever?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        [$qCough, $oCough] = $makeQ('cough', 'Do you have a cough or sore throat?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        [$qGI, $oGI] = $makeQ('gi', 'Do you have nausea, vomiting, or diarrhea?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        [$qLowMood, $oLowMood] = $makeQ('low_mood', 'Have you felt down or hopeless for 2+ weeks?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        [$qWorry, $oWorry] = $makeQ('worry', 'Do you feel excessive worry most days?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        [$qLongTerm, $oLongTerm] = $makeQ('long_term', 'Has this been ongoing for months or longer?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        [$qBpHistory, $oBpHistory] = $makeQ('bp_history', 'Have you been told you have high blood pressure before?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        [$qThirst, $oThirst] = $makeQ('thirst', 'Do you feel unusually thirsty often?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        [$qWheeze, $oWheeze] = $makeQ('wheeze', 'Do you have wheezing or shortness of breath?', [
            'yes'=>'Yes','no'=>'No','unsure'=>'Unsure'
        ]);

        // Likelihoods
        $setDistAll($allConds, $oFeeling, ['good'=>0.40,'unwell'=>0.40,'unsure'=>0.20]);
        foreach ($infectConds as $c)  $setDistCond($c, $oFeeling, ['good'=>0.25,'unwell'=>0.55,'unsure'=>0.20]);
        foreach ($mentalConds as $c)  $setDistCond($c, $oFeeling, ['good'=>0.30,'unwell'=>0.45,'unsure'=>0.25]);
        foreach ($chronicConds as $c) $setDistCond($c, $oFeeling, ['good'=>0.38,'unwell'=>0.40,'unsure'=>0.22]);

        $setDistAll($allConds, $oDuration, ['days'=>0.25,'weeks'=>0.25,'months'=>0.25,'unsure'=>0.25]);
        foreach ($infectConds as $c)  $setDistCond($c, $oDuration, ['days'=>0.70,'weeks'=>0.15,'months'=>0.05,'unsure'=>0.10]);
        foreach ($mentalConds as $c)  $setDistCond($c, $oDuration, ['days'=>0.10,'weeks'=>0.55,'months'=>0.20,'unsure'=>0.15]);
        foreach ($chronicConds as $c) $setDistCond($c, $oDuration, ['days'=>0.05,'weeks'=>0.15,'months'=>0.65,'unsure'=>0.15]);

        $YNUS_BASE = ['yes'=>0.10,'no'=>0.70,'unsure'=>0.20];

        $setDistAll($allConds, $oFever, $YNUS_BASE);
        $setDistCond($flu,   $oFever, ['yes'=>0.75,'no'=>0.15,'unsure'=>0.10]);
        $setDistCond($strep, $oFever, ['yes'=>0.55,'no'=>0.35,'unsure'=>0.10]);
        $setDistCond($gastro,$oFever, ['yes'=>0.40,'no'=>0.50,'unsure'=>0.10]);

        $setDistAll($allConds, $oCough, $YNUS_BASE);
        $setDistCond($flu,   $oCough, ['yes'=>0.65,'no'=>0.25,'unsure'=>0.10]);
        $setDistCond($strep, $oCough, ['yes'=>0.80,'no'=>0.10,'unsure'=>0.10]);

        $setDistAll($allConds, $oGI, $YNUS_BASE);
        $setDistCond($gastro,$oGI, ['yes'=>0.85,'no'=>0.10,'unsure'=>0.05]);
        $setDistCond($flu,   $oGI, ['yes'=>0.20,'no'=>0.70,'unsure'=>0.10]);

        $setDistAll($allConds, $oLowMood, $YNUS_BASE);
        $setDistCond($depression, $oLowMood, ['yes'=>0.85,'no'=>0.10,'unsure'=>0.05]);

        $setDistAll($allConds, $oWorry, $YNUS_BASE);
        $setDistCond($anxiety, $oWorry, ['yes'=>0.85,'no'=>0.10,'unsure'=>0.05]);

        $setDistAll($allConds, $oLongTerm, ['yes'=>0.20,'no'=>0.60,'unsure'=>0.20]);
        foreach ($chronicConds as $c) $setDistCond($c, $oLongTerm, ['yes'=>0.80,'no'=>0.10,'unsure'=>0.10]);

        $setDistAll($allConds, $oBpHistory, $YNUS_BASE);
        $setDistCond($hypertension, $oBpHistory, ['yes'=>0.85,'no'=>0.10,'unsure'=>0.05]);

        $setDistAll($allConds, $oThirst, $YNUS_BASE);
        $setDistCond($diabetes, $oThirst, ['yes'=>0.80,'no'=>0.15,'unsure'=>0.05]);

        $setDistAll($allConds, $oWheeze, $YNUS_BASE);
        $setDistCond($asthma, $oWheeze, ['yes'=>0.85,'no'=>0.10,'unsure'=>0.05]);
    }
}
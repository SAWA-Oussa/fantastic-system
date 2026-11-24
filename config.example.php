<?php
declare(strict_types=1);
return [
 'db'=>['host'=>'127.0.0.1','name'=>'afri_school','user'=>'afri_user','pass'=>'CHANGE_WITH_A_LONG_RANDOM_PASSWORD','charset'=>'utf8mb4'],
 'app'=>['name'=>'AFRI-SCHOOL','base_url'=>'https://votre-domaine.tld','timezone'=>'Africa/Porto-Novo','session_name'=>'AFRISCHOOL','debug'=>false],
 'security'=>['https_only'=>true,'login_max_attempts'=>8,'login_window_minutes'=>15,'session_idle_minutes'=>45,'max_upload_bytes'=>8388608],
 'integrations'=>[
  'mail'=>['driver'=>'http_api','from_email'=>'','from_name'=>'AFRI-SCHOOL','api_url'=>'','api_key'=>''],
  'whatsapp'=>['enabled'=>false,'base_url'=>'https://graph.facebook.com/v20.0','phone_number_id'=>'','access_token'=>'','verify_token'=>'','app_secret'=>''],
  'sms'=>['enabled'=>false,'endpoint'=>'','api_key'=>'','sender'=>'AFRISCHOOL'],
  'payments'=>['enabled'=>false,'provider'=>'','base_url'=>'','merchant_id'=>'','api_key'=>'','api_secret'=>'','webhook_secret'=>'','currency'=>'XOF'],
  'ai'=>['enabled'=>false,'provider'=>'openai-compatible','base_url'=>'','api_key'=>'','model'=>'','system_prompt'=>'Tu es le tuteur pédagogique AFRI-SCHOOL. Réponds en français, explique sans faire les devoirs à la place de l’étudiant.'],
  'video'=>['provider'=>'','api_key'=>'','base_url'=>''],
  'storage'=>['driver'=>'local','bucket'=>'','region'=>'','endpoint'=>'','access_key'=>'','secret_key'=>'']
 ]
];

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SenderController;
use Illuminate\Http\Request;
use App\Inbox;
use Carbon\Carbon;
use App\Facility;
use App\Result;
use App\User;

class TasksController extends Controller
{
    public function read($id){
		

                $msg = Inbox::find($id);

                $decr = base64_decode($msg->message);
                
	

		//SEND CURRENT RESULTS

                if(strpos($decr, '07') !== false){

                    $facility = Facility::where('mobile', $decr)->first();

                    if(!empty($facility)){
                        $mfl = $facility->code;

                        $results = Result::whereNull('date_sent')->where('processed', '0')->where('mfl_code', $mfl)->limit(2)->get();

                        foreach ($results as $result){
                
                            $id = $result->id;
                            $type = $result->result_type;
                            $client_id = $result->client_id;
                            $age = $result->age;
                            $gender = $result->gender;
                            $content = $result->result_content;
                            $units = $result->units;
                            $date_collected = $result->date_collected;
                            $mfl = $result->mfl_code;
                
                
                            if (strpos($date_collected, "00:00:00") !== false) {
                                $date_collected = substr($date_collected, 0, 10);
                            }
                            
                            if ($type == 1) {
                                $ftype = "VL";
                                $rtype = "FFViral Load Results";
                            } 
                            elseif ($type == 2) {
                                $ftype = "EID";
                                $rtype = "FFEID Results";
                            }
                
                            $dest = $facility->mobile;
                            $msgmlb = "$ftype PID:$client_id A:$age S:$gender DC:$date_collected R: :$content $units";
                        
                            $encr =  base64_encode($msgmlb);
                            $finalmsg = "<#> ". $encr . " ukmLMZrTc2e";
                
                            date_default_timezone_set('Africa/Nairobi');
                            $date = date('Y-m-d H:i:s', time());
                
                            $sender = new SenderController;
                            if($sender->send($dest, $finalmsg)){
                
                                $result->processed = '1';
                                $result->date_sent = $date;
                                $result->date_delivered = $date;
                                $result->updated_at = $date;
                
                
                                $result->save();
                
                            }
                            
                
                        }
                    }
                    else{
                        $sender = new SenderController;
                        $sender->send($decr, "Phone Number not attched to any Facility");
            
                    }

                }

                //HISTORICAL RESULTS
                if (strpos($decr, 'histr') !== false) {

                    $prevs = Inbox::where('id', '<', $unpro->id)->where('MSISDN',$unpro->MSISDN)->where("created_at",">",Carbon::now()->subDay())->where("created_at","<",$unpro->created_at)->get();
                    
                    $to_send = "NO";
                    foreach ($prevs as $prev) {

                        $prev_decr = base64_decode( $prev->message);

                        if (strpos($prev_decr, 'histr') !== false) {
                                                           
                                $msg = "You already made this request within the last 24 Hours. It will be processed  and sent to you shortly. mLab";

                                date_default_timezone_set('Africa/Nairobi');
                                $date = date('Y-m-d H:i:s', time());
                    
                                $sender = new SenderController;
                                if($sender->send($unpro->MSISDN, $msg)){
                    
                                    $unpro->processed = 1;
                                    $unpro->updated_at = $date;
                    
                                    $unpro->save();
                                }

                            $to_send = "NO";

                            break;
            
                        }
                        else{
                            $to_send = "YES";
                        }                       
                    

                    }

                    if ($to_send == "YES") {

                        $val = explode("*", $decr);

                        $mfl = $val[1];
                        $frm = $val[2];
                        $to = $val[3];
                        $number = '0'.substr($unpro->MSISDN, 4);

                        $fr =  Carbon::parse($frm)->format('Y-m-d');

                        $t = Carbon::parse($to)->format('Y-m-d');

                        $fac = Facility::where('mobile',$number)->where('code', $mfl)->first();

                        if (!empty($fac)) {
                            $results= Result::where('mfl_code',$mfl)->where('date_collected', '>=', $fr)->where('date_collected', '<=', $t)->orderBy('id', 'DESC')->get();

                            if(!empty($results)){
                                foreach ($results as $result){

                                    $id = $result->id;
                                    $type = $result->result_type;
                                    $client_id = $result->client_id;
                                    $age = $result->age;
                                    $gender = $result->gender;
                                    $content = $result->result_content;
                                    $units = $result->units;
                                    $date_collected = $result->date_collected;
                                    $mfl = $result->mfl_code;
                        
                        
                                    if (strpos($date_collected, "00:00:00") !== false) {
                                        $date_collected = substr($date_collected, 0, 10);
                                    }
                                    
                                    if ($type == 1) {
                                        $ftype = "VL";
                                        $rtype = "FFViral Load Results";
                                    } 
                                    elseif ($type == 2) {
                                        $ftype = "EID";
                                        $rtype = "FFEID Results";
                                    }
                        
                                    $msgmlb = "$ftype PID:$client_id A:$age S:$gender DC:$date_collected R: :$content $units";
                                 
                                    $encr =  base64_encode($msgmlb);
                        
                        
                                    $sender = new SenderController;
                                    $sender->send($number, $encr);

                                    $unpro->processed = 1;
                                    $unpro->updated_at = $date;
                    
                                    $unpro->save();
                                    
                        
                               }
                            }else{

                                $msgf = "No results were found for this period: ". $fr . " - ".$to;
                                $sender = new SenderController;
                                $sender->send($number, $msgf);

                                $unpro->processed = 1;
                                $unpro->updated_at = $date;
                
                                $unpro->save();
                            }
                        }                        
                        else{

                            $user = User::where('phone_no',$number)->where('facility_id', $mfl)->first();

                            if (!empty($user)) {
                                $results= Result::where('mfl_code',$mfl)->where('date_collected', '>=', $fr)->where('date_collected', '<=', $t)->orderBy('id', 'DESC')->get();

                                if(!empty($results)){
                                    foreach ($results as $result){

                                        $id = $result->id;
                                        $type = $result->result_type;
                                        $client_id = $result->client_id;
                                        $age = $result->age;
                                        $gender = $result->gender;
                                        $content = $result->result_content;
                                        $units = $result->units;
                                        $date_collected = $result->date_collected;
                                        $mfl = $result->mfl_code;
                            
                            
                                        if (strpos($date_collected, "00:00:00") !== false) {
                                            $date_collected = substr($date_collected, 0, 10);
                                        }
                                        
                                        if ($type == 1) {
                                            $ftype = "VL";
                                            $rtype = "FFViral Load Results";
                                        } 
                                        elseif ($type == 2) {
                                            $ftype = "EID";
                                            $rtype = "FFEID Results";
                                        }
                            
                                        $msgmlb = "$ftype PID:$client_id A:$age S:$gender DC:$date_collected R: :$content $units";
                                    
                                        $encr =  base64_encode($msgmlb);
                            
                            
                                        $sender = new SenderController;
                                        $sender->send($number, $encr);

                                        $unpro->processed = 1;
                                        $unpro->updated_at = $date;
                        
                                        $unpro->save();
                                        
                            
                                    }
                                }else{

                                    $msgf = "No results were found for this period: ". $fr . " - ".$to;
                                    $sender = new SenderController;
                                    $sender->send($number, $msgf);

                                    $unpro->processed = 1;
                                    $unpro->updated_at = $date;
                    
                                    $unpro->save();
                                }
                            }
                            else{
                                $msgf = "Phone Number not Authorised to receive results";
                                $sender = new SenderController;
                                $sender->send($number, $msgf);

                                $unpro->processed = 1;
                                $unpro->updated_at = $date;
                
                                $unpro->save();
                            }
                        }

                        
                    }
                }

                //END HISTORICAL RESULTS

                //READ RESULTS

                elseif ((strpos($decr, 'FFViral') !== false) || (strpos($decr, 'FFEID') !== false)) {
                        $cc = 0;
                        $number = $cc . substr($unpro->MSISDN, 4);




                        $res = Facility::where('mobile' ,$number)->first();

                        $code = $res->code;

                        $upds = Result::where('mfl_code', $code)->whereNull('date_read')->where('date_sent', '>=', Carbon::now()->subMonth())->get();
                        date_default_timezone_set('Africa/Nairobi');
                        $date = date('Y-m-d H:i:s', time());
                        
                        foreach($upds as $upd){

                            $upd->date_read = $date;
                            $upd->updated_at = $date;
                            $upd->save();
                        }

                        $unpro->processed = 1;
                        $unpro->updated_at = $date;
        
                        $unpro->save();
                        
                }

                //END READ

	  	$msg->processed = 1;
                $msg->save();
       
    }

    public function classify($id){

            $result  = Result::find($id); 

            $message = $result->result_content;

            $p_value = explode(" ", $message);

            if($result->result_type == 1){
                if ( (strpos($message, '<') !== false) || $p_value[0] < 1000 || (strpos($message, 'LDL') !== false)) {
                    $result->data_key = 1;

                    $result->save();
                } 
                if ($p_value[0] >= 1000) {
                    $result->data_key = 2;

                    $result->save();
                }
                if ((strpos($message, 'Invalid') !== false) || (strpos($message, 'Failed') !== false) || (strpos($message, 'Collect') !== false)) {
                    $result->data_key = 3;

                    $result->save();
                }
            }
            elseif($result->result_type == 2){
                if (strpos($message, 'Negative') !== false) {
                    $result->data_key = 4;

                    $result->save();
                } elseif (strpos($message, 'Positive') !== false) {
                    $result->data_key = 5;

                    $result->save();
                } elseif ((strpos($message, 'Invalid') !== false) || (strpos($message, 'Collect') !== false) || (strpos($message, 'Failed') !== false)) {
                    $result->data_key = 6;

                    $result->save();
                }

            }

            
            return true;
        
    }
}
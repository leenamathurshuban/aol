<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\InstructorMembership;
//use App\City;

class SubscriptionUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'subscription update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         //City::where(['id'=>243])->update(['name'=>date('Y-m-d h:i:s'),'slug'=>date('Y-m-d h:i:s')]);
           // $curenttime = Carbon::now();
           $braintree = config('braintree');
            $instructorSubscription=InstructorMembership::orderBy('id','desc')->where(['subscription' => 'Yes'])->whereBetween('end_time', [Carbon::yesterday(), Carbon::today()])->get();
            //print_r($instructorSubscription);die();
            foreach($instructorSubscription as $key => $val){
                //echo $val->transaction_id;echo '<br>';
                $memData = $braintree->subscription()->find($val->transaction_id);
                $lastDate=new Carbon($val->end_time);
                $endDate=$lastDate->addDays($memData->trialDuration);
                $array=[];
                $totPrice=0;
                foreach($memData->statusHistory as $subKey => $subVal){
                    $res=json_encode($subVal->timestamp);
                    $nres=json_decode($res);
                    $array[]=[
                            'planId'=>$subVal->planId,
                            'amount'=>$subVal->price,
                            'status'=>$subVal->status,
                            'trialDuration'=>$memData->trialDuration,
                            'day'=>$memData->trialDurationUnit,
                            'currencyIsoCode'=>$subVal->currencyIsoCode,
                            'date'=>Carbon::parse($nres->date, 'UTC')->format('Y-m-d H:i:s')
                        ];
                        if ($subVal->status=='Active') {
                            $totPrice=$totPrice+$subVal->price;
                        }
                        if($subKey==0){
                            $status=$subVal->status;
                        }
                }
                $updateData=InstructorMembership::where('transaction_id',$val->transaction_id)->first();
                $updateData->transaction_amount=$totPrice;
                $updateData->transaction_status=$status;
                $updateData->paypal_transaction_detail=json_encode($array);
                $updateData->end_time=$endDate;
                $updateData->save();
            }
       // $this->info('subscription:update Cummand Run successfully');
            /* cron
                /usr/local/bin/php /home/shubanso/public_html/DriveGo/admin/artisan subscription:update >> /dev/null 2>&1
				
				/opt/plesk/php/7.3/bin/php  /var/www/vhosts/drivego.co.uk/httpdocs/admin/artisan subscription:update
            */
    }
}

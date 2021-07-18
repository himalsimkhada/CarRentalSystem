<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Console\Command;

class CarAvailabilityAfterTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'availability:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to change availability of car when return date.';

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
        Car::select('*')
            ->join('bookings', 'bookings.car_id', 'cars.id')
            ->where('bookings.return_date', '=', date('Y-m-d'))
            ->update(['availability' => 1]);

            Booking::where('bookings.return_date', '=', date('Y-m-d'))
            ->update(['status' => 'cleared']);
    }
}

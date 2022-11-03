<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::truncate();
        $data = ['Qatar', 'Ecuador', 'Senegal', 'Hà Lan', 'Anh', 'Iran', 'Mỹ', 'Xứ Wales', 'Argentina', 'Saudi Arabia', 'Mexico', 'Ba Lan',
        'Pháp', 'Australia', 'Đan Mạch', 'Tunisia', 'Tây Ban Nha', 'Costa Rica', 'Đức', 'Nhật Bản', 'Bỉ', 'Canada', 'Ma-rốc', 'Croatia',
        'Brazil', 'Serbia', 'Thụy Sĩ', 'Cameroon', 'Bồ Đào Nha', 'Ghana', 'Uruguay', 'Hàn Quốc'];
        foreach ($data as $key => $item) {
            $country = new Country();
            $country->name = $item;
            $country->save();
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = new User();
        // $user->username = 'Yahia_A1';
        // $user->fname = 'Yahia';
        // $user->lname = 'Mohamed';
        // $user->password = Hash::make('12345');
        // $user->email = 'Yahia.M.Yahia96@gmail.com';
        // $user->city = 'Cairo';
        // $user->Address = 'Maboutheen City After Tharwat Bridge';
        // $user->gender = 'M';
        // $user->Bdate = '1996-11-01';
        // $user->privilage = 'admin';

        // $user->save();


        $user = new User();
        $user->username = 'Yahia_C11';
        $user->fname = 'Yahia';
        $user->lname = 'Mohamed';
        $user->password = Hash::make('12345');
        $user->email = 'C11@gmail.com';
        $user->city = 'Cairo';
        $user->Address = 'Maboutheen City After Tharwat Bridge';
        $user->gender = 'M';
        $user->Bdate = '1996-11-01';
        $user->privilage = 'customer';

        $user->save();
    }
}

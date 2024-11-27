<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaisTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('pais')->delete();
        
        \DB::table('pais')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nombre' => 'Germany',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            1 => 
            array (
                'id' => 2,
                'nombre' => 'Austria',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            2 => 
            array (
                'id' => 3,
                'nombre' => 'Belgium',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            3 => 
            array (
                'id' => 4,
                'nombre' => 'Canada',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            4 => 
            array (
                'id' => 5,
                'nombre' => 'China',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            5 => 
            array (
                'id' => 6,
                'nombre' => 'España',
                'activo' => 1,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            6 => 
            array (
                'id' => 7,
                'nombre' => 'Finland',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            7 => 
            array (
                'id' => 8,
                'nombre' => 'France',
                'activo' => 1,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            8 => 
            array (
                'id' => 9,
                'nombre' => 'Greece',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            9 => 
            array (
                'id' => 10,
                'nombre' => 'Italy',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            10 => 
            array (
                'id' => 11,
                'nombre' => 'Japan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            11 => 
            array (
                'id' => 12,
                'nombre' => 'Luxemburg',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            12 => 
            array (
                'id' => 13,
                'nombre' => 'Netherlands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            13 => 
            array (
                'id' => 14,
                'nombre' => 'Poland',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            14 => 
            array (
                'id' => 15,
                'nombre' => 'Portugal',
                'activo' => 1,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            15 => 
            array (
                'id' => 16,
                'nombre' => 'Czech Republic',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            16 => 
            array (
                'id' => 17,
                'nombre' => 'United Kingdom',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            17 => 
            array (
                'id' => 18,
                'nombre' => 'Sweden',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            18 => 
            array (
                'id' => 19,
                'nombre' => 'Switzerland',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            19 => 
            array (
                'id' => 20,
                'nombre' => 'Denmark',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            20 => 
            array (
                'id' => 21,
                'nombre' => 'United States',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            21 => 
            array (
                'id' => 22,
                'nombre' => 'HongKong',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            22 => 
            array (
                'id' => 23,
                'nombre' => 'Norway',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            23 => 
            array (
                'id' => 24,
                'nombre' => 'Australia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            24 => 
            array (
                'id' => 25,
                'nombre' => 'Singapore',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            25 => 
            array (
                'id' => 26,
                'nombre' => 'Ireland',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            26 => 
            array (
                'id' => 27,
                'nombre' => 'New Zealand',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            27 => 
            array (
                'id' => 28,
                'nombre' => 'South Korea',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            28 => 
            array (
                'id' => 29,
                'nombre' => 'Israel',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            29 => 
            array (
                'id' => 30,
                'nombre' => 'South Africa',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            30 => 
            array (
                'id' => 31,
                'nombre' => 'Nigeria',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            31 => 
            array (
                'id' => 32,
                'nombre' => 'Ivory Coast',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            32 => 
            array (
                'id' => 33,
                'nombre' => 'Togo',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            33 => 
            array (
                'id' => 34,
                'nombre' => 'Bolivia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            34 => 
            array (
                'id' => 35,
                'nombre' => 'Mauritius',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            35 => 
            array (
                'id' => 36,
                'nombre' => 'Romania',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            36 => 
            array (
                'id' => 37,
                'nombre' => 'Slovakia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            37 => 
            array (
                'id' => 38,
                'nombre' => 'Algeria',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            38 => 
            array (
                'id' => 39,
                'nombre' => 'American Samoa',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            39 => 
            array (
                'id' => 40,
                'nombre' => 'Andorra',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            40 => 
            array (
                'id' => 41,
                'nombre' => 'Angola',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            41 => 
            array (
                'id' => 42,
                'nombre' => 'Anguilla',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            42 => 
            array (
                'id' => 43,
                'nombre' => 'Antigua and Barbuda',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            43 => 
            array (
                'id' => 44,
                'nombre' => 'Argentina',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            44 => 
            array (
                'id' => 45,
                'nombre' => 'Armenia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            45 => 
            array (
                'id' => 46,
                'nombre' => 'Aruba',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            46 => 
            array (
                'id' => 47,
                'nombre' => 'Azerbaijan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            47 => 
            array (
                'id' => 48,
                'nombre' => 'Bahamas',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            48 => 
            array (
                'id' => 49,
                'nombre' => 'Bahrain',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            49 => 
            array (
                'id' => 50,
                'nombre' => 'Bangladesh',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            50 => 
            array (
                'id' => 51,
                'nombre' => 'Barbados',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            51 => 
            array (
                'id' => 52,
                'nombre' => 'Belarus',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            52 => 
            array (
                'id' => 53,
                'nombre' => 'Belize',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            53 => 
            array (
                'id' => 54,
                'nombre' => 'Benin',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            54 => 
            array (
                'id' => 55,
                'nombre' => 'Bermuda',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            55 => 
            array (
                'id' => 56,
                'nombre' => 'Bhutan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            56 => 
            array (
                'id' => 57,
                'nombre' => 'Botswana',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            57 => 
            array (
                'id' => 58,
                'nombre' => 'Brazil',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            58 => 
            array (
                'id' => 59,
                'nombre' => 'Brunei',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            59 => 
            array (
                'id' => 60,
                'nombre' => 'Burkina Faso',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            60 => 
            array (
                'id' => 61,
            'nombre' => 'Burma (Myanmar)',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            61 => 
            array (
                'id' => 62,
                'nombre' => 'Burundi',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            62 => 
            array (
                'id' => 63,
                'nombre' => 'Cambodia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            63 => 
            array (
                'id' => 64,
                'nombre' => 'Cameroon',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            64 => 
            array (
                'id' => 65,
                'nombre' => 'Cape Verde',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            65 => 
            array (
                'id' => 66,
                'nombre' => 'Central African Republic',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            66 => 
            array (
                'id' => 67,
                'nombre' => 'Chad',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            67 => 
            array (
                'id' => 68,
                'nombre' => 'Chile',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            68 => 
            array (
                'id' => 69,
                'nombre' => 'Colombia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            69 => 
            array (
                'id' => 70,
                'nombre' => 'Comoros',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            70 => 
            array (
                'id' => 71,
                'nombre' => 'Congo, Dem. Republic',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            71 => 
            array (
                'id' => 72,
                'nombre' => 'Congo, Republic',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            72 => 
            array (
                'id' => 73,
                'nombre' => 'Costa Rica',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            73 => 
            array (
                'id' => 74,
                'nombre' => 'Croatia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            74 => 
            array (
                'id' => 75,
                'nombre' => 'Cuba',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            75 => 
            array (
                'id' => 76,
                'nombre' => 'Cyprus',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            76 => 
            array (
                'id' => 77,
                'nombre' => 'Djibouti',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            77 => 
            array (
                'id' => 78,
                'nombre' => 'Dominica',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            78 => 
            array (
                'id' => 79,
                'nombre' => 'Dominican Republic',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            79 => 
            array (
                'id' => 80,
                'nombre' => 'East Timor',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            80 => 
            array (
                'id' => 81,
                'nombre' => 'Ecuador',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            81 => 
            array (
                'id' => 82,
                'nombre' => 'Egypt',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            82 => 
            array (
                'id' => 83,
                'nombre' => 'El Salvador',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            83 => 
            array (
                'id' => 84,
                'nombre' => 'Equatorial Guinea',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            84 => 
            array (
                'id' => 85,
                'nombre' => 'Eritrea',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            85 => 
            array (
                'id' => 86,
                'nombre' => 'Estonia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            86 => 
            array (
                'id' => 87,
                'nombre' => 'Ethiopia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            87 => 
            array (
                'id' => 88,
                'nombre' => 'Falkland Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            88 => 
            array (
                'id' => 89,
                'nombre' => 'Faroe Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            89 => 
            array (
                'id' => 90,
                'nombre' => 'Fiji',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            90 => 
            array (
                'id' => 91,
                'nombre' => 'Gabon',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            91 => 
            array (
                'id' => 92,
                'nombre' => 'Gambia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            92 => 
            array (
                'id' => 93,
                'nombre' => 'Georgia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            93 => 
            array (
                'id' => 94,
                'nombre' => 'Ghana',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            94 => 
            array (
                'id' => 95,
                'nombre' => 'Grenada',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            95 => 
            array (
                'id' => 96,
                'nombre' => 'Greenland',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            96 => 
            array (
                'id' => 97,
                'nombre' => 'Gibraltar',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            97 => 
            array (
                'id' => 98,
                'nombre' => 'Guadeloupe',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            98 => 
            array (
                'id' => 99,
                'nombre' => 'Guam',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            99 => 
            array (
                'id' => 100,
                'nombre' => 'Guatemala',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            100 => 
            array (
                'id' => 101,
                'nombre' => 'Guernsey',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            101 => 
            array (
                'id' => 102,
                'nombre' => 'Guinea',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            102 => 
            array (
                'id' => 103,
                'nombre' => 'Guinea-Bissau',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            103 => 
            array (
                'id' => 104,
                'nombre' => 'Guyana',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            104 => 
            array (
                'id' => 105,
                'nombre' => 'Haiti',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            105 => 
            array (
                'id' => 106,
                'nombre' => 'Heard Island and McDonald Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            106 => 
            array (
                'id' => 107,
                'nombre' => 'Vatican City State',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            107 => 
            array (
                'id' => 108,
                'nombre' => 'Honduras',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            108 => 
            array (
                'id' => 109,
                'nombre' => 'Iceland',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            109 => 
            array (
                'id' => 110,
                'nombre' => 'India',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            110 => 
            array (
                'id' => 111,
                'nombre' => 'Indonesia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            111 => 
            array (
                'id' => 112,
                'nombre' => 'Iran',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            112 => 
            array (
                'id' => 113,
                'nombre' => 'Iraq',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            113 => 
            array (
                'id' => 114,
                'nombre' => 'Man Island',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            114 => 
            array (
                'id' => 115,
                'nombre' => 'Jamaica',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            115 => 
            array (
                'id' => 116,
                'nombre' => 'Jersey',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            116 => 
            array (
                'id' => 117,
                'nombre' => 'Jordan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            117 => 
            array (
                'id' => 118,
                'nombre' => 'Kazakhstan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            118 => 
            array (
                'id' => 119,
                'nombre' => 'Kenya',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            119 => 
            array (
                'id' => 120,
                'nombre' => 'Kiribati',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            120 => 
            array (
                'id' => 121,
                'nombre' => 'Korea, Dem. Republic of',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            121 => 
            array (
                'id' => 122,
                'nombre' => 'Kuwait',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            122 => 
            array (
                'id' => 123,
                'nombre' => 'Kyrgyzstan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            123 => 
            array (
                'id' => 124,
                'nombre' => 'Laos',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            124 => 
            array (
                'id' => 125,
                'nombre' => 'Latvia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            125 => 
            array (
                'id' => 126,
                'nombre' => 'Lebanon',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            126 => 
            array (
                'id' => 127,
                'nombre' => 'Lesotho',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            127 => 
            array (
                'id' => 128,
                'nombre' => 'Liberia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            128 => 
            array (
                'id' => 129,
                'nombre' => 'Libya',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            129 => 
            array (
                'id' => 130,
                'nombre' => 'Liechtenstein',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            130 => 
            array (
                'id' => 131,
                'nombre' => 'Lithuania',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            131 => 
            array (
                'id' => 132,
                'nombre' => 'Macau',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            132 => 
            array (
                'id' => 133,
                'nombre' => 'Macedonia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            133 => 
            array (
                'id' => 134,
                'nombre' => 'Madagascar',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            134 => 
            array (
                'id' => 135,
                'nombre' => 'Malawi',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            135 => 
            array (
                'id' => 136,
                'nombre' => 'Malaysia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            136 => 
            array (
                'id' => 137,
                'nombre' => 'Maldives',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            137 => 
            array (
                'id' => 138,
                'nombre' => 'Mali',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            138 => 
            array (
                'id' => 139,
                'nombre' => 'Malta',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            139 => 
            array (
                'id' => 140,
                'nombre' => 'Marshall Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            140 => 
            array (
                'id' => 141,
                'nombre' => 'Martinique',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            141 => 
            array (
                'id' => 142,
                'nombre' => 'Mauritania',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            142 => 
            array (
                'id' => 143,
                'nombre' => 'Hungary',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            143 => 
            array (
                'id' => 144,
                'nombre' => 'Mayotte',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            144 => 
            array (
                'id' => 145,
                'nombre' => 'Mexico',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            145 => 
            array (
                'id' => 146,
                'nombre' => 'Micronesia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            146 => 
            array (
                'id' => 147,
                'nombre' => 'Moldova',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            147 => 
            array (
                'id' => 148,
                'nombre' => 'Monaco',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            148 => 
            array (
                'id' => 149,
                'nombre' => 'Mongolia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            149 => 
            array (
                'id' => 150,
                'nombre' => 'Montenegro',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            150 => 
            array (
                'id' => 151,
                'nombre' => 'Montserrat',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            151 => 
            array (
                'id' => 152,
                'nombre' => 'Morocco',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            152 => 
            array (
                'id' => 153,
                'nombre' => 'Mozambique',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            153 => 
            array (
                'id' => 154,
                'nombre' => 'Namibia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            154 => 
            array (
                'id' => 155,
                'nombre' => 'Nauru',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            155 => 
            array (
                'id' => 156,
                'nombre' => 'Nepal',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            156 => 
            array (
                'id' => 157,
                'nombre' => 'Netherlands Antilles',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            157 => 
            array (
                'id' => 158,
                'nombre' => 'New Caledonia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            158 => 
            array (
                'id' => 159,
                'nombre' => 'Nicaragua',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            159 => 
            array (
                'id' => 160,
                'nombre' => 'Niger',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            160 => 
            array (
                'id' => 161,
                'nombre' => 'Niue',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            161 => 
            array (
                'id' => 162,
                'nombre' => 'Norfolk Island',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            162 => 
            array (
                'id' => 163,
                'nombre' => 'Northern Mariana Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            163 => 
            array (
                'id' => 164,
                'nombre' => 'Oman',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            164 => 
            array (
                'id' => 165,
                'nombre' => 'Pakistan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            165 => 
            array (
                'id' => 166,
                'nombre' => 'Palau',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            166 => 
            array (
                'id' => 167,
                'nombre' => 'Palestinian Territories',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            167 => 
            array (
                'id' => 168,
                'nombre' => 'Panama',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            168 => 
            array (
                'id' => 169,
                'nombre' => 'Papua New Guinea',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            169 => 
            array (
                'id' => 170,
                'nombre' => 'Paraguay',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            170 => 
            array (
                'id' => 171,
                'nombre' => 'Peru',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            171 => 
            array (
                'id' => 172,
                'nombre' => 'Philippines',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            172 => 
            array (
                'id' => 173,
                'nombre' => 'Pitcairn',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            173 => 
            array (
                'id' => 174,
                'nombre' => 'Puerto Rico',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            174 => 
            array (
                'id' => 175,
                'nombre' => 'Qatar',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            175 => 
            array (
                'id' => 176,
                'nombre' => 'Reunion Island',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            176 => 
            array (
                'id' => 177,
                'nombre' => 'Russian Federation',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            177 => 
            array (
                'id' => 178,
                'nombre' => 'Rwanda',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            178 => 
            array (
                'id' => 179,
                'nombre' => 'Saint Barthelemy',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            179 => 
            array (
                'id' => 180,
                'nombre' => 'Saint Kitts and Nevis',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            180 => 
            array (
                'id' => 181,
                'nombre' => 'Saint Lucia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            181 => 
            array (
                'id' => 182,
                'nombre' => 'Saint Martin',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            182 => 
            array (
                'id' => 183,
                'nombre' => 'Saint Pierre and Miquelon',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            183 => 
            array (
                'id' => 184,
                'nombre' => 'Saint Vincent and the Grenadines',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            184 => 
            array (
                'id' => 185,
                'nombre' => 'Samoa',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            185 => 
            array (
                'id' => 186,
                'nombre' => 'San Marino',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            186 => 
            array (
                'id' => 187,
                'nombre' => 'São Tomé and Príncipe',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            187 => 
            array (
                'id' => 188,
                'nombre' => 'Saudi Arabia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            188 => 
            array (
                'id' => 189,
                'nombre' => 'Senegal',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            189 => 
            array (
                'id' => 190,
                'nombre' => 'Serbia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            190 => 
            array (
                'id' => 191,
                'nombre' => 'Seychelles',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            191 => 
            array (
                'id' => 192,
                'nombre' => 'Sierra Leone',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            192 => 
            array (
                'id' => 193,
                'nombre' => 'Slovenia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            193 => 
            array (
                'id' => 194,
                'nombre' => 'Solomon Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            194 => 
            array (
                'id' => 195,
                'nombre' => 'Somalia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            195 => 
            array (
                'id' => 196,
                'nombre' => 'South Georgia and the South Sandwich Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            196 => 
            array (
                'id' => 197,
                'nombre' => 'Sri Lanka',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            197 => 
            array (
                'id' => 198,
                'nombre' => 'Sudan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            198 => 
            array (
                'id' => 199,
                'nombre' => 'Suriname',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            199 => 
            array (
                'id' => 200,
                'nombre' => 'Svalbard and Jan Mayen',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            200 => 
            array (
                'id' => 201,
                'nombre' => 'Swaziland',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            201 => 
            array (
                'id' => 202,
                'nombre' => 'Syria',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            202 => 
            array (
                'id' => 203,
                'nombre' => 'Taiwan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            203 => 
            array (
                'id' => 204,
                'nombre' => 'Tajikistan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            204 => 
            array (
                'id' => 205,
                'nombre' => 'Tanzania',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            205 => 
            array (
                'id' => 206,
                'nombre' => 'Thailand',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            206 => 
            array (
                'id' => 207,
                'nombre' => 'Tokelau',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            207 => 
            array (
                'id' => 208,
                'nombre' => 'Tonga',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            208 => 
            array (
                'id' => 209,
                'nombre' => 'Trinidad and Tobago',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            209 => 
            array (
                'id' => 210,
                'nombre' => 'Tunisia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            210 => 
            array (
                'id' => 211,
                'nombre' => 'Turkey',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            211 => 
            array (
                'id' => 212,
                'nombre' => 'Turkmenistan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            212 => 
            array (
                'id' => 213,
                'nombre' => 'Turks and Caicos Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            213 => 
            array (
                'id' => 214,
                'nombre' => 'Tuvalu',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            214 => 
            array (
                'id' => 215,
                'nombre' => 'Uganda',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            215 => 
            array (
                'id' => 216,
                'nombre' => 'Ukraine',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            216 => 
            array (
                'id' => 217,
                'nombre' => 'United Arab Emirates',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            217 => 
            array (
                'id' => 218,
                'nombre' => 'Uruguay',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            218 => 
            array (
                'id' => 219,
                'nombre' => 'Uzbekistan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            219 => 
            array (
                'id' => 220,
                'nombre' => 'Vanuatu',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            220 => 
            array (
                'id' => 221,
                'nombre' => 'Venezuela',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            221 => 
            array (
                'id' => 222,
                'nombre' => 'Vietnam',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            222 => 
            array (
                'id' => 223,
            'nombre' => 'Virgin Islands (British)',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            223 => 
            array (
                'id' => 224,
            'nombre' => 'Virgin Islands (U.S.)',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            224 => 
            array (
                'id' => 225,
                'nombre' => 'Wallis and Futuna',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            225 => 
            array (
                'id' => 226,
                'nombre' => 'Western Sahara',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            226 => 
            array (
                'id' => 227,
                'nombre' => 'Yemen',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            227 => 
            array (
                'id' => 228,
                'nombre' => 'Zambia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            228 => 
            array (
                'id' => 229,
                'nombre' => 'Zimbabwe',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            229 => 
            array (
                'id' => 230,
                'nombre' => 'Albania',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            230 => 
            array (
                'id' => 231,
                'nombre' => 'Afghanistan',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            231 => 
            array (
                'id' => 232,
                'nombre' => 'Antarctica',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            232 => 
            array (
                'id' => 233,
                'nombre' => 'Bosnia and Herzegovina',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            233 => 
            array (
                'id' => 234,
                'nombre' => 'Bouvet Island',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            234 => 
            array (
                'id' => 235,
                'nombre' => 'British Indian Ocean Territory',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            235 => 
            array (
                'id' => 236,
                'nombre' => 'Bulgaria',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            236 => 
            array (
                'id' => 237,
                'nombre' => 'Cayman Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            237 => 
            array (
                'id' => 238,
                'nombre' => 'Christmas Island',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            238 => 
            array (
                'id' => 239,
            'nombre' => 'Cocos (Keeling) Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            239 => 
            array (
                'id' => 240,
                'nombre' => 'Cook Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            240 => 
            array (
                'id' => 241,
                'nombre' => 'French Guiana',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            241 => 
            array (
                'id' => 242,
                'nombre' => 'French Polynesia',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            242 => 
            array (
                'id' => 243,
                'nombre' => 'French Southern Territories',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            243 => 
            array (
                'id' => 244,
                'nombre' => 'Åland Islands',
                'activo' => 0,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
        ));
        
        
    }
}
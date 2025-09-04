<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks temporarily to avoid issues with existing data
        // if this seeder is run multiple times or in a specific order.
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data in the 'countries' table to prevent duplicate entries
        // if the seeder is run multiple times.
        DB::table('countries')->truncate();

        // Define the country data as an array of associative arrays.
        // Each inner array represents a row in the 'countries' table.
        $countries = [
            [
                'name' => 'Afghanistan',
                'abv' => 'AF',
                'abv3' => 'AFG',
                'abv3_alt' => null,
                'code' => 4,
                'slug' => 'afghanistan',
                'phonecode' => '93'
            ],
            [
                'name' => 'Aland Islands',
                'abv' => 'AX',
                'abv3' => 'ALA',
                'abv3_alt' => null,
                'code' => 248,
                'slug' => 'aland-islands',
                'phonecode' => '358'
            ],
            [
                'name' => 'Albania',
                'abv' => 'AL',
                'abv3' => 'ALB',
                'abv3_alt' => null,
                'code' => 8,
                'slug' => 'albania',
                'phonecode' => '355'
            ],
            [
                'name' => 'Algeria',
                'abv' => 'DZ',
                'abv3' => 'DZA',
                'abv3_alt' => null,
                'code' => 12,
                'slug' => 'algeria',
                'phonecode' => '213'
            ],
            [
                'name' => 'American Samoa',
                'abv' => 'AS',
                'abv3' => 'ASM',
                'abv3_alt' => null,
                'code' => 16,
                'slug' => 'american-samoa',
                'phonecode' => '1684'
            ],
            [
                'name' => 'Andorra',
                'abv' => 'AD',
                'abv3' => 'AND',
                'abv3_alt' => null,
                'code' => 20,
                'slug' => 'andorra',
                'phonecode' => '376'
            ],
            [
                'name' => 'Angola',
                'abv' => 'AO',
                'abv3' => 'AGO',
                'abv3_alt' => null,
                'code' => 24,
                'slug' => 'angola',
                'phonecode' => '244'
            ],
            [
                'name' => 'Anguilla',
                'abv' => 'AI',
                'abv3' => 'AIA',
                'abv3_alt' => null,
                'code' => 660,
                'slug' => 'anguilla',
                'phonecode' => '1264'
            ],
            [
                'name' => 'Antigua and Barbuda',
                'abv' => 'AG',
                'abv3' => 'ATG',
                'abv3_alt' => null,
                'code' => 28,
                'slug' => 'antigua-and-barbuda',
                'phonecode' => '1268'
            ],
            [
                'name' => 'Argentina',
                'abv' => 'AR',
                'abv3' => 'ARG',
                'abv3_alt' => null,
                'code' => 32,
                'slug' => 'argentina',
                'phonecode' => '54'
            ],
            [
                'name' => 'Armenia',
                'abv' => 'AM',
                'abv3' => 'ARM',
                'abv3_alt' => null,
                'code' => 51,
                'slug' => 'armenia',
                'phonecode' => '374'
            ],
            [
                'name' => 'Aruba',
                'abv' => 'AW',
                'abv3' => 'ABW',
                'abv3_alt' => null,
                'code' => 533,
                'slug' => 'aruba',
                'phonecode' => '297'
            ],
            [
                'name' => 'Australia',
                'abv' => 'AU',
                'abv3' => 'AUS',
                'abv3_alt' => null,
                'code' => 36,
                'slug' => 'australia',
                'phonecode' => '61'
            ],
            [
                'name' => 'Austria',
                'abv' => 'AT',
                'abv3' => 'AUT',
                'abv3_alt' => null,
                'code' => 40,
                'slug' => 'austria',
                'phonecode' => '43'
            ],
            [
                'name' => 'Azerbaijan',
                'abv' => 'AZ',
                'abv3' => 'AZE',
                'abv3_alt' => null,
                'code' => 31,
                'slug' => 'azerbaijan',
                'phonecode' => '994'
            ],
            [
                'name' => 'Bahamas',
                'abv' => 'BS',
                'abv3' => 'BHS',
                'abv3_alt' => null,
                'code' => 44,
                'slug' => 'bahamas',
                'phonecode' => '1242'
            ],
            [
                'name' => 'Bahrain',
                'abv' => 'BH',
                'abv3' => 'BHR',
                'abv3_alt' => null,
                'code' => 48,
                'slug' => 'bahrain',
                'phonecode' => '973'
            ],
            [
                'name' => 'Bangladesh',
                'abv' => 'BD',
                'abv3' => 'BGD',
                'abv3_alt' => null,
                'code' => 50,
                'slug' => 'bangladesh',
                'phonecode' => '880'
            ],
            [
                'name' => 'Barbados',
                'abv' => 'BB',
                'abv3' => 'BRB',
                'abv3_alt' => null,
                'code' => 52,
                'slug' => 'barbados',
                'phonecode' => '1246'
            ],
            [
                'name' => 'Belarus',
                'abv' => 'BY',
                'abv3' => 'BLR',
                'abv3_alt' => null,
                'code' => 112,
                'slug' => 'belarus',
                'phonecode' => '375'
            ],
            [
                'name' => 'Belgium',
                'abv' => 'BE',
                'abv3' => 'BEL',
                'abv3_alt' => null,
                'code' => 56,
                'slug' => 'belgium',
                'phonecode' => '32'
            ],
            [
                'name' => 'Belize',
                'abv' => 'BZ',
                'abv3' => 'BLZ',
                'abv3_alt' => null,
                'code' => 84,
                'slug' => 'belize',
                'phonecode' => '501'
            ],
            [
                'name' => 'Benin',
                'abv' => 'BJ',
                'abv3' => 'BEN',
                'abv3_alt' => null,
                'code' => 204,
                'slug' => 'benin',
                'phonecode' => '229'
            ],
            [
                'name' => 'Bermuda',
                'abv' => 'BM',
                'abv3' => 'BMU',
                'abv3_alt' => null,
                'code' => 60,
                'slug' => 'bermuda',
                'phonecode' => '1441'
            ],
            [
                'name' => 'Bhutan',
                'abv' => 'BT',
                'abv3' => 'BTN',
                'abv3_alt' => null,
                'code' => 64,
                'slug' => 'bhutan',
                'phonecode' => '975'
            ],
            [
                'name' => 'Bolivia',
                'abv' => 'BO',
                'abv3' => 'BOL',
                'abv3_alt' => null,
                'code' => 68,
                'slug' => 'bolivia',
                'phonecode' => '591'
            ],
            [
                'name' => 'Bosnia and Herzegovina',
                'abv' => 'BA',
                'abv3' => 'BIH',
                'abv3_alt' => null,
                'code' => 70,
                'slug' => 'bosnia-and-herzegovina',
                'phonecode' => '387'
            ],
            [
                'name' => 'Botswana',
                'abv' => 'BW',
                'abv3' => 'BWA',
                'abv3_alt' => null,
                'code' => 72,
                'slug' => 'botswana',
                'phonecode' => '267'
            ],
            [
                'name' => 'Brazil',
                'abv' => 'BR',
                'abv3' => 'BRA',
                'abv3_alt' => null,
                'code' => 76,
                'slug' => 'brazil',
                'phonecode' => '55'
            ],
            [
                'name' => 'British Virgin Islands',
                'abv' => 'VG',
                'abv3' => 'VGB',
                'abv3_alt' => null,
                'code' => 92,
                'slug' => 'british-virgin-islands',
                'phonecode' => '1284'
            ],
            [
                'name' => 'Brunei Darussalam',
                'abv' => 'BN',
                'abv3' => 'BRN',
                'abv3_alt' => null,
                'code' => 96,
                'slug' => 'brunei-darussalam',
                'phonecode' => '673'
            ],
            [
                'name' => 'Bulgaria',
                'abv' => 'BG',
                'abv3' => 'BGR',
                'abv3_alt' => null,
                'code' => 100,
                'slug' => 'bulgaria',
                'phonecode' => '359'
            ],
            [
                'name' => 'Burkina Faso',
                'abv' => 'BF',
                'abv3' => 'BFA',
                'abv3_alt' => null,
                'code' => 854,
                'slug' => 'burkina-faso',
                'phonecode' => '226'
            ],
            [
                'name' => 'Burundi',
                'abv' => 'BI',
                'abv3' => 'BDI',
                'abv3_alt' => null,
                'code' => 108,
                'slug' => 'burundi',
                'phonecode' => '257'
            ],
            [
                'name' => 'Cambodia',
                'abv' => 'KH',
                'abv3' => 'KHM',
                'abv3_alt' => null,
                'code' => 116,
                'slug' => 'cambodia',
                'phonecode' => '855'
            ],
            [
                'name' => 'Cameroon',
                'abv' => 'CM',
                'abv3' => 'CMR',
                'abv3_alt' => null,
                'code' => 120,
                'slug' => 'cameroon',
                'phonecode' => '237'
            ],
            [
                'name' => 'Canada',
                'abv' => 'CA',
                'abv3' => 'CAN',
                'abv3_alt' => null,
                'code' => 124,
                'slug' => 'canada',
                'phonecode' => '1'
            ],
            [
                'name' => 'Cape Verde',
                'abv' => 'CV',
                'abv3' => 'CPV',
                'abv3_alt' => null,
                'code' => 132,
                'slug' => 'cape-verde',
                'phonecode' => '238'
            ],
            [
                'name' => 'Cayman Islands',
                'abv' => 'KY',
                'abv3' => 'CYM',
                'abv3_alt' => null,
                'code' => 136,
                'slug' => 'cayman-islands',
                'phonecode' => '1345'
            ],
            [
                'name' => 'Central African Republic',
                'abv' => 'CF',
                'abv3' => 'CAF',
                'abv3_alt' => null,
                'code' => 140,
                'slug' => 'central-african-republic',
                'phonecode' => '236'
            ],
            [
                'name' => 'Chad',
                'abv' => 'TD',
                'abv3' => 'TCD',
                'abv3_alt' => null,
                'code' => 148,
                'slug' => 'chad',
                'phonecode' => '235'
            ],
            [
                'name' => 'Chile',
                'abv' => 'CL',
                'abv3' => 'CHL',
                'abv3_alt' => 'CHI',
                'code' => 152,
                'slug' => 'chile',
                'phonecode' => '56'
            ],
            [
                'name' => 'China',
                'abv' => 'CN',
                'abv3' => 'CHN',
                'abv3_alt' => null,
                'code' => 156,
                'slug' => 'china',
                'phonecode' => '86'
            ],
            [
                'name' => 'Colombia',
                'abv' => 'CO',
                'abv3' => 'COL',
                'abv3_alt' => null,
                'code' => 170,
                'slug' => 'colombia',
                'phonecode' => '57'
            ],
            [
                'name' => 'Comoros',
                'abv' => 'KM',
                'abv3' => 'COM',
                'abv3_alt' => null,
                'code' => 174,
                'slug' => 'comoros',
                'phonecode' => '269'
            ],
            [
                'name' => 'Congo',
                'abv' => 'CG',
                'abv3' => 'COG',
                'abv3_alt' => null,
                'code' => 178,
                'slug' => 'congo',
                'phonecode' => '242'
            ],
            [
                'name' => 'Cook Islands',
                'abv' => 'CK',
                'abv3' => 'COK',
                'abv3_alt' => null,
                'code' => 184,
                'slug' => 'cook-islands',
                'phonecode' => '682'
            ],
            [
                'name' => 'Costa Rica',
                'abv' => 'CR',
                'abv3' => 'CRI',
                'abv3_alt' => null,
                'code' => 188,
                'slug' => 'costa-rica',
                'phonecode' => '506'
            ],
            [
                'name' => 'Cote d\'Ivoire',
                'abv' => 'CI',
                'abv3' => 'CIV',
                'abv3_alt' => null,
                'code' => 384,
                'slug' => 'cote-divoire',
                'phonecode' => '225'
            ],
            [
                'name' => 'Croatia',
                'abv' => 'HR',
                'abv3' => 'HRV',
                'abv3_alt' => null,
                'code' => 191,
                'slug' => 'croatia',
                'phonecode' => '385'
            ],
            [
                'name' => 'Cuba',
                'abv' => 'CU',
                'abv3' => 'CUB',
                'abv3_alt' => null,
                'code' => 192,
                'slug' => 'cuba',
                'phonecode' => '53'
            ],
            [
                'name' => 'Cyprus',
                'abv' => 'CY',
                'abv3' => 'CYP',
                'abv3_alt' => null,
                'code' => 196,
                'slug' => 'cyprus',
                'phonecode' => '357'
            ],
            [
                'name' => 'Czech Republic',
                'abv' => 'CZ',
                'abv3' => 'CZE',
                'abv3_alt' => null,
                'code' => 203,
                'slug' => 'czech-republic',
                'phonecode' => '420'
            ],
            [
                'name' => 'Democratic Republic of the Congo',
                'abv' => 'CD',
                'abv3' => 'COD',
                'abv3_alt' => null,
                'code' => 180,
                'slug' => 'democratic-republic-of-congo',
                'phonecode' => '243'
            ],
            [
                'name' => 'Denmark',
                'abv' => 'DK',
                'abv3' => 'DNK',
                'abv3_alt' => null,
                'code' => 208,
                'slug' => 'denmark',
                'phonecode' => '45'
            ],
            [
                'name' => 'Djibouti',
                'abv' => 'DJ',
                'abv3' => 'DJI',
                'abv3_alt' => null,
                'code' => 262,
                'slug' => 'djibouti',
                'phonecode' => '253'
            ],
            [
                'name' => 'Dominica',
                'abv' => 'DM',
                'abv3' => 'DMA',
                'abv3_alt' => null,
                'code' => 212,
                'slug' => 'dominica',
                'phonecode' => '1767'
            ],
            [
                'name' => 'Dominican Republic',
                'abv' => 'DO',
                'abv3' => 'DOM',
                'abv3_alt' => null,
                'code' => 214,
                'slug' => 'dominican-republic',
                'phonecode' => '1809'
            ],
            [
                'name' => 'Ecuador',
                'abv' => 'EC',
                'abv3' => 'ECU',
                'abv3_alt' => null,
                'code' => 218,
                'slug' => 'ecuador',
                'phonecode' => '593'
            ],
            [
                'name' => 'Egypt',
                'abv' => 'EG',
                'abv3' => 'EGY',
                'abv3_alt' => null,
                'code' => 818,
                'slug' => 'egypt',
                'phonecode' => '20'
            ],
            [
                'name' => 'El Salvador',
                'abv' => 'SV',
                'abv3' => 'SLV',
                'abv3_alt' => null,
                'code' => 222,
                'slug' => 'el-salvador',
                'phonecode' => '503'
            ],
            [
                'name' => 'Equatorial Guinea',
                'abv' => 'GQ',
                'abv3' => 'GNQ',
                'abv3_alt' => null,
                'code' => 226,
                'slug' => 'equatorial-guinea',
                'phonecode' => '240'
            ],
            [
                'name' => 'Eritrea',
                'abv' => 'ER',
                'abv3' => 'ERI',
                'abv3_alt' => null,
                'code' => 232,
                'slug' => 'eritrea',
                'phonecode' => '291'
            ],
            [
                'name' => 'Estonia',
                'abv' => 'EE',
                'abv3' => 'EST',
                'abv3_alt' => null,
                'code' => 233,
                'slug' => 'estonia',
                'phonecode' => '372'
            ],
            [
                'name' => 'Ethiopia',
                'abv' => 'ET',
                'abv3' => 'ETH',
                'abv3_alt' => null,
                'code' => 231,
                'slug' => 'ethiopia',
                'phonecode' => '251'
            ],
            [
                'name' => 'Faeroe Islands',
                'abv' => 'FO',
                'abv3' => 'FRO',
                'abv3_alt' => null,
                'code' => 234,
                'slug' => 'faeroe-islands',
                'phonecode' => '298'
            ],
            [
                'name' => 'Falkland Islands',
                'abv' => 'FK',
                'abv3' => 'FLK',
                'abv3_alt' => null,
                'code' => 238,
                'slug' => 'falkland-islands',
                'phonecode' => '500'
            ],
            [
                'name' => 'Fiji',
                'abv' => 'FJ',
                'abv3' => 'FJI',
                'abv3_alt' => null,
                'code' => 242,
                'slug' => 'fiji',
                'phonecode' => '679'
            ],
            [
                'name' => 'Finland',
                'abv' => 'FI',
                'abv3' => 'FIN',
                'abv3_alt' => null,
                'code' => 246,
                'slug' => 'finland',
                'phonecode' => '358'
            ],
            [
                'name' => 'France',
                'abv' => 'FR',
                'abv3' => 'FRA',
                'abv3_alt' => null,
                'code' => 250,
                'slug' => 'france',
                'phonecode' => '33'
            ],
            [
                'name' => 'French Guiana',
                'abv' => 'GF',
                'abv3' => 'GUF',
                'abv3_alt' => null,
                'code' => 254,
                'slug' => 'french-guiana',
                'phonecode' => '594'
            ],
            [
                'name' => 'French Polynesia',
                'abv' => 'PF',
                'abv3' => 'PYF',
                'abv3_alt' => null,
                'code' => 258,
                'slug' => 'french-polynesia',
                'phonecode' => '689'
            ],
            [
                'name' => 'Gabon',
                'abv' => 'GA',
                'abv3' => 'GAB',
                'abv3_alt' => null,
                'code' => 266,
                'slug' => 'gabon',
                'phonecode' => '241'
            ],
            [
                'name' => 'Gambia',
                'abv' => 'GM',
                'abv3' => 'GMB',
                'abv3_alt' => null,
                'code' => 270,
                'slug' => 'gambia',
                'phonecode' => '220'
            ],
            [
                'name' => 'Georgia',
                'abv' => 'GE',
                'abv3' => 'GEO',
                'abv3_alt' => null,
                'code' => 268,
                'slug' => 'georgia',
                'phonecode' => '995'
            ],
            [
                'name' => 'Germany',
                'abv' => 'DE',
                'abv3' => 'DEU',
                'abv3_alt' => null,
                'code' => 276,
                'slug' => 'germany',
                'phonecode' => '49'
            ],
            [
                'name' => 'Ghana',
                'abv' => 'GH',
                'abv3' => 'GHA',
                'abv3_alt' => null,
                'code' => 288,
                'slug' => 'ghana',
                'phonecode' => '233'
            ],
            [
                'name' => 'Gibraltar',
                'abv' => 'GI',
                'abv3' => 'GIB',
                'abv3_alt' => null,
                'code' => 292,
                'slug' => 'gibraltar',
                'phonecode' => '350'
            ],
            [
                'name' => 'Greece',
                'abv' => 'GR',
                'abv3' => 'GRC',
                'abv3_alt' => null,
                'code' => 300,
                'slug' => 'greece',
                'phonecode' => '30'
            ],
            [
                'name' => 'Greenland',
                'abv' => 'GL',
                'abv3' => 'GRL',
                'abv3_alt' => null,
                'code' => 304,
                'slug' => 'greenland',
                'phonecode' => '299'
            ],
            [
                'name' => 'Grenada',
                'abv' => 'GD',
                'abv3' => 'GRD',
                'abv3_alt' => null,
                'code' => 308,
                'slug' => 'grenada',
                'phonecode' => '1473'
            ],
            [
                'name' => 'Guadeloupe',
                'abv' => 'GP',
                'abv3' => 'GLP',
                'abv3_alt' => null,
                'code' => 312,
                'slug' => 'guadeloupe',
                'phonecode' => '590'
            ],
            [
                'name' => 'Guam',
                'abv' => 'GU',
                'abv3' => 'GUM',
                'abv3_alt' => null,
                'code' => 316,
                'slug' => 'guam',
                'phonecode' => '1671'
            ],
            [
                'name' => 'Guatemala',
                'abv' => 'GT',
                'abv3' => 'GTM',
                'abv3_alt' => null,
                'code' => 320,
                'slug' => 'guatemala',
                'phonecode' => '502'
            ],
            [
                'name' => 'Guernsey',
                'abv' => 'GG',
                'abv3' => 'GGY',
                'abv3_alt' => null,
                'code' => 831,
                'slug' => 'guernsey',
                'phonecode' => '44'
            ],
            [
                'name' => 'Guinea',
                'abv' => 'GN',
                'abv3' => 'GIN',
                'abv3_alt' => null,
                'code' => 324,
                'slug' => 'guinea',
                'phonecode' => '224'
            ],
            [
                'name' => 'Guinea-Bissau',
                'abv' => 'GW',
                'abv3' => 'GNB',
                'abv3_alt' => null,
                'code' => 624,
                'slug' => 'guinea-bissau',
                'phonecode' => '245'
            ],
            [
                'name' => 'Guyana',
                'abv' => 'GY',
                'abv3' => 'GUY',
                'abv3_alt' => null,
                'code' => 328,
                'slug' => 'guyana',
                'phonecode' => '592'
            ],
            [
                'name' => 'Haiti',
                'abv' => 'HT',
                'abv3' => 'HTI',
                'abv3_alt' => null,
                'code' => 332,
                'slug' => 'haiti',
                'phonecode' => '509'
            ],
            [
                'name' => 'Holy See',
                'abv' => 'VA',
                'abv3' => 'VAT',
                'abv3_alt' => null,
                'code' => 336,
                'slug' => 'holy-see',
                'phonecode' => '39'
            ],
            [
                'name' => 'Honduras',
                'abv' => 'HN',
                'abv3' => 'HND',
                'abv3_alt' => null,
                'code' => 340,
                'slug' => 'honduras',
                'phonecode' => '504'
            ],
            [
                'name' => 'Hong Kong',
                'abv' => 'HK',
                'abv3' => 'HKG',
                'abv3_alt' => null,
                'code' => 344,
                'slug' => 'hong-kong',
                'phonecode' => '852'
            ],
            [
                'name' => 'Hungary',
                'abv' => 'HU',
                'abv3' => 'HUN',
                'abv3_alt' => null,
                'code' => 348,
                'slug' => 'hungary',
                'phonecode' => '36'
            ],
            [
                'name' => 'Iceland',
                'abv' => 'IS',
                'abv3' => 'ISL',
                'abv3_alt' => null,
                'code' => 352,
                'slug' => 'iceland',
                'phonecode' => '354'
            ],
            [
                'name' => 'India',
                'abv' => 'IN',
                'abv3' => 'IND',
                'abv3_alt' => null,
                'code' => 356,
                'slug' => 'india',
                'phonecode' => '91'
            ],
            [
                'name' => 'Indonesia',
                'abv' => 'ID',
                'abv3' => 'IDN',
                'abv3_alt' => null,
                'code' => 360,
                'slug' => 'indonesia',
                'phonecode' => '62'
            ],
            [
                'name' => 'Iran',
                'abv' => 'IR',
                'abv3' => 'IRN',
                'abv3_alt' => null,
                'code' => 364,
                'slug' => 'iran',
                'phonecode' => '98'
            ],
            [
                'name' => 'Iraq',
                'abv' => 'IQ',
                'abv3' => 'IRQ',
                'abv3_alt' => null,
                'code' => 368,
                'slug' => 'iraq',
                'phonecode' => '964'
            ],
            [
                'name' => 'Ireland',
                'abv' => 'IE',
                'abv3' => 'IRL',
                'abv3_alt' => null,
                'code' => 372,
                'slug' => 'ireland',
                'phonecode' => '353'
            ],
            [
                'name' => 'Isle of Man',
                'abv' => 'IM',
                'abv3' => 'IMN',
                'abv3_alt' => null,
                'code' => 833,
                'slug' => 'isle-of-man',
                'phonecode' => '44'
            ],
            [
                'name' => 'Israel',
                'abv' => 'IL',
                'abv3' => 'ISR',
                'abv3_alt' => null,
                'code' => 376,
                'slug' => 'israel',
                'phonecode' => '972'
            ],
            [
                'name' => 'Italy',
                'abv' => 'IT',
                'abv3' => 'ITA',
                'abv3_alt' => null,
                'code' => 380,
                'slug' => 'italy',
                'phonecode' => '39'
            ],
            [
                'name' => 'Jamaica',
                'abv' => 'JM',
                'abv3' => 'JAM',
                'abv3_alt' => null,
                'code' => 388,
                'slug' => 'jamaica',
                'phonecode' => '1876'
            ],
            [
                'name' => 'Japan',
                'abv' => 'JP',
                'abv3' => 'JPN',
                'abv3_alt' => null,
                'code' => 392,
                'slug' => 'japan',
                'phonecode' => '81'
            ],
            [
                'name' => 'Jersey',
                'abv' => 'JE',
                'abv3' => 'JEY',
                'abv3_alt' => null,
                'code' => 832,
                'slug' => 'jersey',
                'phonecode' => '44'
            ],
            [
                'name' => 'Jordan',
                'abv' => 'JO',
                'abv3' => 'JOR',
                'abv3_alt' => null,
                'code' => 400,
                'slug' => 'jordan',
                'phonecode' => '962'
            ],
            [
                'name' => 'Kazakhstan',
                'abv' => 'KZ',
                'abv3' => 'KAZ',
                'abv3_alt' => null,
                'code' => 398,
                'slug' => 'kazakhstan',
                'phonecode' => '7'
            ],
            [
                'name' => 'Kenya',
                'abv' => 'KE',
                'abv3' => 'KEN',
                'abv3_alt' => null,
                'code' => 404,
                'slug' => 'kenya',
                'phonecode' => '254'
            ],
            [
                'name' => 'Kiribati',
                'abv' => 'KI',
                'abv3' => 'KIR',
                'abv3_alt' => null,
                'code' => 296,
                'slug' => 'kiribati',
                'phonecode' => '686'
            ],
            [
                'name' => 'Kuwait',
                'abv' => 'KW',
                'abv3' => 'KWT',
                'abv3_alt' => null,
                'code' => 414,
                'slug' => 'kuwait',
                'phonecode' => '965'
            ],
            [
                'name' => 'Kyrgyzstan',
                'abv' => 'KG',
                'abv3' => 'KGZ',
                'abv3_alt' => null,
                'code' => 417,
                'slug' => 'kyrgyzstan',
                'phonecode' => '996'
            ],
            [
                'name' => 'Laos',
                'abv' => 'LA',
                'abv3' => 'LAO',
                'abv3_alt' => null,
                'code' => 418,
                'slug' => 'laos',
                'phonecode' => '856'
            ],
            [
                'name' => 'Latvia',
                'abv' => 'LV',
                'abv3' => 'LVA',
                'abv3_alt' => null,
                'code' => 428,
                'slug' => 'latvia',
                'phonecode' => '371'
            ],
            [
                'name' => 'Lebanon',
                'abv' => 'LB',
                'abv3' => 'LBN',
                'abv3_alt' => null,
                'code' => 422,
                'slug' => 'lebanoon',
                'phonecode' => '961'
            ],
            [
                'name' => 'Lesotho',
                'abv' => 'LS',
                'abv3' => 'LSO',
                'abv3_alt' => null,
                'code' => 426,
                'slug' => 'lesotho',
                'phonecode' => '266'
            ],
            [
                'name' => 'Liberia',
                'abv' => 'LR',
                'abv3' => 'LBR',
                'abv3_alt' => null,
                'code' => 430,
                'slug' => 'liberia',
                'phonecode' => '231'
            ],
            [
                'name' => 'Libyan Arab Jamahiriya',
                'abv' => 'LY',
                'abv3' => 'LBY',
                'abv3_alt' => null,
                'code' => 434,
                'slug' => 'libyan-arab-jamahiriya',
                'phonecode' => '218'
            ],
            [
                'name' => 'Liechtenstein',
                'abv' => 'LI',
                'abv3' => 'LIE',
                'abv3_alt' => null,
                'code' => 438,
                'slug' => 'liechtenstein',
                'phonecode' => '423'
            ],
            [
                'name' => 'Lithuania',
                'abv' => 'LT',
                'abv3' => 'LTU',
                'abv3_alt' => null,
                'code' => 440,
                'slug' => 'lithuania',
                'phonecode' => '370'
            ],
            [
                'name' => 'Luxembourg',
                'abv' => 'LU',
                'abv3' => 'LUX',
                'abv3_alt' => null,
                'code' => 442,
                'slug' => 'luxembourg',
                'phonecode' => '352'
            ],
            [
                'name' => 'Macao',
                'abv' => 'MO',
                'abv3' => 'MAC',
                'abv3_alt' => null,
                'code' => 446,
                'slug' => 'macao',
                'phonecode' => '853'
            ],
            [
                'name' => 'Macedonia',
                'abv' => 'MK',
                'abv3' => 'MKD',
                'abv3_alt' => null,
                'code' => 807,
                'slug' => 'macedonia',
                'phonecode' => '389'
            ],
            [
                'name' => 'Madagascar',
                'abv' => 'MG',
                'abv3' => 'MDG',
                'abv3_alt' => null,
                'code' => 450,
                'slug' => 'madagascar',
                'phonecode' => '261'
            ],
            [
                'name' => 'Malawi',
                'abv' => 'MW',
                'abv3' => 'MWI',
                'abv3_alt' => null,
                'code' => 454,
                'slug' => 'malawi',
                'phonecode' => '265'
            ],
            [
                'name' => 'Malaysia',
                'abv' => 'MY',
                'abv3' => 'MYS',
                'abv3_alt' => null,
                'code' => 458,
                'slug' => 'malaysia',
                'phonecode' => '60'
            ],
            [
                'name' => 'Maldives',
                'abv' => 'MV',
                'abv3' => 'MDV',
                'abv3_alt' => null,
                'code' => 462,
                'slug' => 'maldives',
                'phonecode' => '960'
            ],
            [
                'name' => 'Mali',
                'abv' => 'ML',
                'abv3' => 'MLI',
                'abv3_alt' => null,
                'code' => 466,
                'slug' => 'mali',
                'phonecode' => '223'
            ],
            [
                'name' => 'Malta',
                'abv' => 'MT',
                'abv3' => 'MLT',
                'abv3_alt' => null,
                'code' => 470,
                'slug' => 'malta',
                'phonecode' => '356'
            ],
            [
                'name' => 'Marshall Islands',
                'abv' => 'MH',
                'abv3' => 'MHL',
                'abv3_alt' => null,
                'code' => 584,
                'slug' => 'marshall-islands',
                'phonecode' => '692'
            ],
            [
                'name' => 'Martinique',
                'abv' => 'MQ',
                'abv3' => 'MTQ',
                'abv3_alt' => null,
                'code' => 474,
                'slug' => 'martinique',
                'phonecode' => '596'
            ],
            [
                'name' => 'Mauritania',
                'abv' => 'MR',
                'abv3' => 'MRT',
                'abv3_alt' => null,
                'code' => 478,
                'slug' => 'mauritaania',
                'phonecode' => '222'
            ],
            [
                'name' => 'Mauritius',
                'abv' => 'MU',
                'abv3' => 'MUS',
                'abv3_alt' => null,
                'code' => 480,
                'slug' => 'mauritius',
                'phonecode' => '230'
            ],
            [
                'name' => 'Mayotte',
                'abv' => 'YT',
                'abv3' => 'MYT',
                'abv3_alt' => null,
                'code' => 175,
                'slug' => 'mayotte',
                'phonecode' => '262'
            ],
            [
                'name' => 'Mexico',
                'abv' => 'MX',
                'abv3' => 'MEX',
                'abv3_alt' => null,
                'code' => 484,
                'slug' => 'mexico',
                'phonecode' => '52'
            ],
            [
                'name' => 'Micronesia',
                'abv' => 'FM',
                'abv3' => 'FSM',
                'abv3_alt' => null,
                'code' => 583,
                'slug' => 'micronesia',
                'phonecode' => '691'
            ],
            [
                'name' => 'Moldova',
                'abv' => 'MD',
                'abv3' => 'MDA',
                'abv3_alt' => null,
                'code' => 498,
                'slug' => 'moldova',
                'phonecode' => '373'
            ],
            [
                'name' => 'Monaco',
                'abv' => 'MC',
                'abv3' => 'MCO',
                'abv3_alt' => null,
                'code' => 492,
                'slug' => 'monaco',
                'phonecode' => '377'
            ],
            [
                'name' => 'Mongolia',
                'abv' => 'MN',
                'abv3' => 'MNG',
                'abv3_alt' => null,
                'code' => 496,
                'slug' => 'mongolia',
                'phonecode' => '976'
            ],
            [
                'name' => 'Montenegro',
                'abv' => 'ME',
                'abv3' => 'MNE',
                'abv3_alt' => null,
                'code' => 499,
                'slug' => 'montenegro',
                'phonecode' => '382'
            ],
            [
                'name' => 'Montserrat',
                'abv' => 'MS',
                'abv3' => 'MSR',
                'abv3_alt' => null,
                'code' => 500,
                'slug' => 'montserrat',
                'phonecode' => '1664'
            ],
            [
                'name' => 'Morocco',
                'abv' => 'MA',
                'abv3' => 'MAR',
                'abv3_alt' => null,
                'code' => 504,
                'slug' => 'morocco',
                'phonecode' => '212'
            ],
            [
                'name' => 'Mozambique',
                'abv' => 'MZ',
                'abv3' => 'MOZ',
                'abv3_alt' => null,
                'code' => 508,
                'slug' => 'mozambique',
                'phonecode' => '258'
            ],
            [
                'name' => 'Myanmar',
                'abv' => 'MM',
                'abv3' => 'MMR',
                'abv3_alt' => 'BUR',
                'code' => 104,
                'slug' => 'myanmar',
                'phonecode' => '95'
            ],
            [
                'name' => 'Namibia',
                'abv' => 'NA',
                'abv3' => 'NAM',
                'abv3_alt' => null,
                'code' => 516,
                'slug' => 'namibia',
                'phonecode' => '264'
            ],
            [
                'name' => 'Nauru',
                'abv' => 'NR',
                'abv3' => 'NRU',
                'abv3_alt' => null,
                'code' => 520,
                'slug' => 'nauru',
                'phonecode' => '674'
            ],
            [
                'name' => 'Nepal',
                'abv' => 'NP',
                'abv3' => 'NPL',
                'abv3_alt' => null,
                'code' => 524,
                'slug' => 'nepal',
                'phonecode' => '977'
            ],
            [
                'name' => 'Netherlands',
                'abv' => 'NL',
                'abv3' => 'NLD',
                'abv3_alt' => null,
                'code' => 528,
                'slug' => 'netherlands',
                'phonecode' => '31'
            ],
            [
                'name' => 'Netherlands Antilles',
                'abv' => 'AN',
                'abv3' => 'ANT',
                'abv3_alt' => null,
                'code' => 530,
                'slug' => 'netherlands-antilles',
                'phonecode' => '599'
            ],
            [
                'name' => 'New Caledonia',
                'abv' => 'NC',
                'abv3' => 'NCL',
                'abv3_alt' => null,
                'code' => 540,
                'slug' => 'new-caledonia',
                'phonecode' => '687'
            ],
            [
                'name' => 'New Zealand',
                'abv' => 'NZ',
                'abv3' => 'NZL',
                'abv3_alt' => null,
                'code' => 554,
                'slug' => 'new-zealand',
                'phonecode' => '64'
            ],
            [
                'name' => 'Nicaragua',
                'abv' => 'NI',
                'abv3' => 'NIC',
                'abv3_alt' => null,
                'code' => 558,
                'slug' => 'nicaragua',
                'phonecode' => '505'
            ],
            [
                'name' => 'Niger',
                'abv' => 'NE',
                'abv3' => 'NER',
                'abv3_alt' => null,
                'code' => 562,
                'slug' => 'niger',
                'phonecode' => '227'
            ],
            [
                'name' => 'Nigeria',
                'abv' => 'NG',
                'abv3' => 'NGA',
                'abv3_alt' => null,
                'code' => 566,
                'slug' => 'nigeria',
                'phonecode' => '234'
            ],
            [
                'name' => 'Niue',
                'abv' => 'NU',
                'abv3' => 'NIU',
                'abv3_alt' => null,
                'code' => 570,
                'slug' => 'niue',
                'phonecode' => '683'
            ],
            [
                'name' => 'Norfolk Island',
                'abv' => 'NF',
                'abv3' => 'NFK',
                'abv3_alt' => null,
                'code' => 574,
                'slug' => 'norfolk-island',
                'phonecode' => '672'
            ],
            [
                'name' => 'North Korea',
                'abv' => 'KP',
                'abv3' => 'PRK',
                'abv3_alt' => null,
                'code' => 408,
                'slug' => 'north-korea',
                'phonecode' => '850'
            ],
            [
                'name' => 'Northern Mariana Islands',
                'abv' => 'MP',
                'abv3' => 'MNP',
                'abv3_alt' => null,
                'code' => 580,
                'slug' => 'northern-mariana-islands',
                'phonecode' => '1670'
            ],
            [
                'name' => 'Norway',
                'abv' => 'NO',
                'abv3' => 'NOR',
                'abv3_alt' => null,
                'code' => 578,
                'slug' => 'norway',
                'phonecode' => '47'
            ],
            [
                'name' => 'Oman',
                'abv' => 'OM',
                'abv3' => 'OMN',
                'abv3_alt' => null,
                'code' => 512,
                'slug' => 'oman',
                'phonecode' => '968'
            ],
            [
                'name' => 'Pakistan',
                'abv' => 'PK',
                'abv3' => 'PAK',
                'abv3_alt' => null,
                'code' => 586,
                'slug' => 'pakistan',
                'phonecode' => '92'
            ],
            [
                'name' => 'Palau',
                'abv' => 'PW',
                'abv3' => 'PLW',
                'abv3_alt' => null,
                'code' => 585,
                'slug' => 'palau',
                'phonecode' => '680'
            ],
            [
                'name' => 'Palestine',
                'abv' => 'PS',
                'abv3' => 'PSE',
                'abv3_alt' => null,
                'code' => 275,
                'slug' => 'palestine',
                'phonecode' => '970'
            ],
            [
                'name' => 'Panama',
                'abv' => 'PA',
                'abv3' => 'PAN',
                'abv3_alt' => null,
                'code' => 591,
                'slug' => 'panama',
                'phonecode' => '507'
            ],
            [
                'name' => 'Papua New Guinea',
                'abv' => 'PG',
                'abv3' => 'PNG',
                'abv3_alt' => null,
                'code' => 598,
                'slug' => 'papua-new-guinea',
                'phonecode' => '675'
            ],
            [
                'name' => 'Paraguay',
                'abv' => 'PY',
                'abv3' => 'PRY',
                'abv3_alt' => null,
                'code' => 600,
                'slug' => 'paraguay',
                'phonecode' => '595'
            ],
            [
                'name' => 'Peru',
                'abv' => 'PE',
                'abv3' => 'PER',
                'abv3_alt' => null,
                'code' => 604,
                'slug' => 'peru',
                'phonecode' => '51'
            ],
            [
                'name' => 'Philippines',
                'abv' => 'PH',
                'abv3' => 'PHL',
                'abv3_alt' => null,
                'code' => 608,
                'slug' => 'philippines',
                'phonecode' => '63'
            ],
            [
                'name' => 'Pitcairn',
                'abv' => 'PN',
                'abv3' => 'PCN',
                'abv3_alt' => null,
                'code' => 612,
                'slug' => 'pitcairn',
                'phonecode' => '64'
            ],
            [
                'name' => 'Poland',
                'abv' => 'PL',
                'abv3' => 'POL',
                'abv3_alt' => null,
                'code' => 616,
                'slug' => 'poland',
                'phonecode' => '48'
            ],
            [
                'name' => 'Portugal',
                'abv' => 'PT',
                'abv3' => 'PRT',
                'abv3_alt' => null,
                'code' => 620,
                'slug' => 'portugal',
                'phonecode' => '351'
            ],
            [
                'name' => 'Puerto Rico',
                'abv' => 'PR',
                'abv3' => 'PRI',
                'abv3_alt' => null,
                'code' => 630,
                'slug' => 'puerto-rico',
                'phonecode' => '1'
            ],
            [
                'name' => 'Qatar',
                'abv' => 'QA',
                'abv3' => 'QAT',
                'abv3_alt' => null,
                'code' => 634,
                'slug' => 'qatar',
                'phonecode' => '974'
            ],
            [
                'name' => 'Reunion',
                'abv' => 'RE',
                'abv3' => 'REU',
                'abv3_alt' => null,
                'code' => 638,
                'slug' => 'reunion',
                'phonecode' => '262'
            ],
            [
                'name' => 'Romania',
                'abv' => 'RO',
                'abv3' => 'ROU',
                'abv3_alt' => 'ROM',
                'code' => 642,
                'slug' => 'romania',
                'phonecode' => '40'
            ],
            [
                'name' => 'Russian Federation',
                'abv' => 'RU',
                'abv3' => 'RUS',
                'abv3_alt' => null,
                'code' => 643,
                'slug' => 'russian-federation',
                'phonecode' => '7'
            ],
            [
                'name' => 'Rwanda',
                'abv' => 'RW',
                'abv3' => 'RWA',
                'abv3_alt' => null,
                'code' => 646,
                'slug' => 'rwanda',
                'phonecode' => '250'
            ],
            [
                'name' => 'Saint Helena',
                'abv' => 'SH',
                'abv3' => 'SHN',
                'abv3_alt' => null,
                'code' => 654,
                'slug' => 'saint-helena',
                'phonecode' => '290'
            ],
            [
                'name' => 'Saint Kitts and Nevis',
                'abv' => 'KN',
                'abv3' => 'KNA',
                'abv3_alt' => null,
                'code' => 659,
                'slug' => 'saint-kitts-and-nevis',
                'phonecode' => '1869'
            ],
            [
                'name' => 'Saint Lucia',
                'abv' => 'LC',
                'abv3' => 'LCA',
                'abv3_alt' => null,
                'code' => 662,
                'slug' => 'saint-lucia',
                'phonecode' => '1758'
            ],
            [
                'name' => 'Saint Pierre and Miquelon',
                'abv' => 'PM',
                'abv3' => 'SPM',
                'abv3_alt' => null,
                'code' => 666,
                'slug' => 'saint-pierre-and-miquelon',
                'phonecode' => '508'
            ],
            [
                'name' => 'Saint Vincent and the Grenadines',
                'abv' => 'VC',
                'abv3' => 'VCT',
                'abv3_alt' => null,
                'code' => 670,
                'slug' => 'saint-vincent-and-grenadines',
                'phonecode' => '1784'
            ],
            [
                'name' => 'Saint-Barthelemy',
                'abv' => 'BL',
                'abv3' => 'BLM',
                'abv3_alt' => null,
                'code' => 652,
                'slug' => 'saint-barthelemy',
                'phonecode' => '590'
            ],
            [
                'name' => 'Saint-Martin',
                'abv' => 'MF',
                'abv3' => 'MAF',
                'abv3_alt' => null,
                'code' => 663,
                'slug' => 'saint-martin',
                'phonecode' => '590'
            ],
            [
                'name' => 'Samoa',
                'abv' => 'WS',
                'abv3' => 'WSM',
                'abv3_alt' => null,
                'code' => 882,
                'slug' => 'samoa',
                'phonecode' => '685'
            ],
            [
                'name' => 'San Marino',
                'abv' => 'SM',
                'abv3' => 'SMR',
                'abv3_alt' => null,
                'code' => 674,
                'slug' => 'san-marino',
                'phonecode' => '378'
            ],
            [
                'name' => 'Sao Tome and Principe',
                'abv' => 'ST',
                'abv3' => 'STP',
                'abv3_alt' => null,
                'code' => 678,
                'slug' => 'sao-tome-and-principe',
                'phonecode' => '239'
            ],
            [
                'name' => 'Saudi Arabia',
                'abv' => 'SA',
                'abv3' => 'SAU',
                'abv3_alt' => null,
                'code' => 682,
                'slug' => 'saudi-arabia',
                'phonecode' => '966'
            ],
            [
                'name' => 'Senegal',
                'abv' => 'SN',
                'abv3' => 'SEN',
                'abv3_alt' => null,
                'code' => 686,
                'slug' => 'senegal',
                'phonecode' => '221'
            ],
            [
                'name' => 'Serbia',
                'abv' => 'RS',
                'abv3' => 'SRB',
                'abv3_alt' => null,
                'code' => 688,
                'slug' => 'serbia',
                'phonecode' => '381'
            ],
            [
                'name' => 'Seychelles',
                'abv' => 'SC',
                'abv3' => 'SYC',
                'abv3_alt' => null,
                'code' => 690,
                'slug' => 'seychelles',
                'phonecode' => '248'
            ],
            [
                'name' => 'Sierra Leone',
                'abv' => 'SL',
                'abv3' => 'SLE',
                'abv3_alt' => null,
                'code' => 694,
                'slug' => 'sierra-leone',
                'phonecode' => '232'
            ],
            [
                'name' => 'Singapore',
                'abv' => 'SG',
                'abv3' => 'SGP',
                'abv3_alt' => null,
                'code' => 702,
                'slug' => 'singapore',
                'phonecode' => '65'
            ],
            [
                'name' => 'Slovakia',
                'abv' => 'SK',
                'abv3' => 'SVK',
                'abv3_alt' => null,
                'code' => 703,
                'slug' => 'slovakia',
                'phonecode' => '421'
            ],
            [
                'name' => 'Slovenia',
                'abv' => 'SI',
                'abv3' => 'SVN',
                'abv3_alt' => null,
                'code' => 705,
                'slug' => 'slovenia',
                'phonecode' => '386'
            ],
            [
                'name' => 'Solomon Islands',
                'abv' => 'SB',
                'abv3' => 'SLB',
                'abv3_alt' => null,
                'code' => 90,
                'slug' => 'solomon-islands',
                'phonecode' => '677'
            ],
            [
                'name' => 'Somalia',
                'abv' => 'SO',
                'abv3' => 'SOM',
                'abv3_alt' => null,
                'code' => 706,
                'slug' => 'somalia',
                'phonecode' => '252'
            ],
            [
                'name' => 'South Africa',
                'abv' => 'ZA',
                'abv3' => 'ZAF',
                'abv3_alt' => null,
                'code' => 710,
                'slug' => 'south-africa',
                'phonecode' => '27'
            ],
            [
                'name' => 'South Korea',
                'abv' => 'KR',
                'abv3' => 'KOR',
                'abv3_alt' => null,
                'code' => 410,
                'slug' => 'south-korea',
                'phonecode' => '82'
            ],
            [
                'name' => 'South Sudan',
                'abv' => 'SS',
                'abv3' => 'SSD',
                'abv3_alt' => null,
                'code' => 728,
                'slug' => 'south-sudan',
                'phonecode' => '211'
            ],
            [
                'name' => 'Spain',
                'abv' => 'ES',
                'abv3' => 'ESP',
                'abv3_alt' => null,
                'code' => 724,
                'slug' => 'spain',
                'phonecode' => '34'
            ],
            [
                'name' => 'Sri Lanka',
                'abv' => 'LK',
                'abv3' => 'LKA',
                'abv3_alt' => null,
                'code' => 144,
                'slug' => 'sri-lanka',
                'phonecode' => '94'
            ],
            [
                'name' => 'Sudan',
                'abv' => 'SD',
                'abv3' => 'SDN',
                'abv3_alt' => null,
                'code' => 729,
                'slug' => 'sudan',
                'phonecode' => '249'
            ],
            [
                'name' => 'Suriname',
                'abv' => 'SR',
                'abv3' => 'SUR',
                'abv3_alt' => null,
                'code' => 740,
                'slug' => 'suriname',
                'phonecode' => '597'
            ],
            [
                'name' => 'Svalbard and Jan Mayen Islands',
                'abv' => 'SJ',
                'abv3' => 'SJM',
                'abv3_alt' => null,
                'code' => 744,
                'slug' => 'svalbard-and-jan-mayen-islands',
                'phonecode' => '47'
            ],
            [
                'name' => 'Swaziland',
                'abv' => 'SZ',
                'abv3' => 'SWZ',
                'abv3_alt' => null,
                'code' => 748,
                'slug' => 'swaziland',
                'phonecode' => '268'
            ],
            [
                'name' => 'Sweden',
                'abv' => 'SE',
                'abv3' => 'SWE',
                'abv3_alt' => null,
                'code' => 752,
                'slug' => 'sweden',
                'phonecode' => '46'
            ],
            [
                'name' => 'Switzerland',
                'abv' => 'CH',
                'abv3' => 'CHE',
                'abv3_alt' => null,
                'code' => 756,
                'slug' => 'switzerland',
                'phonecode' => '41'
            ],
            [
                'name' => 'Syrian Arab Republic',
                'abv' => 'SY',
                'abv3' => 'SYR',
                'abv3_alt' => null,
                'code' => 760,
                'slug' => 'syrian-arab-republic',
                'phonecode' => '963'
            ],
            [
                'name' => 'Tajikistan',
                'abv' => 'TJ',
                'abv3' => 'TJK',
                'abv3_alt' => null,
                'code' => 762,
                'slug' => 'tajikistan',
                'phonecode' => '992'
            ],
            [
                'name' => 'Tanzania',
                'abv' => 'TZ',
                'abv3' => 'TZA',
                'abv3_alt' => null,
                'code' => 834,
                'slug' => 'tanzania',
                'phonecode' => '255'
            ],
            [
                'name' => 'Thailand',
                'abv' => 'TH',
                'abv3' => 'THA',
                'abv3_alt' => null,
                'code' => 764,
                'slug' => 'thailand',
                'phonecode' => '66'
            ],
            [
                'name' => 'Timor-Leste',
                'abv' => 'TP',
                'abv3' => 'TLS',
                'abv3_alt' => null,
                'code' => 626,
                'slug' => 'timor-leste',
                'phonecode' => '670'
            ],
            [
                'name' => 'Togo',
                'abv' => 'TG',
                'abv3' => 'TGO',
                'abv3_alt' => null,
                'code' => 768,
                'slug' => 'togo',
                'phonecode' => '228'
            ],
            [
                'name' => 'Tokelau',
                'abv' => 'TK',
                'abv3' => 'TKL',
                'abv3_alt' => null,
                'code' => 772,
                'slug' => 'tokelau',
                'phonecode' => '690'
            ],
            [
                'name' => 'Tonga',
                'abv' => 'TO',
                'abv3' => 'TON',
                'abv3_alt' => null,
                'code' => 776,
                'slug' => 'tonga',
                'phonecode' => '676'
            ],
            [
                'name' => 'Trinidad and Tobago',
                'abv' => 'TT',
                'abv3' => 'TTO',
                'abv3_alt' => null,
                'code' => 780,
                'slug' => 'trinidad-and-tobago',
                'phonecode' => '1868'
            ],
            [
                'name' => 'Tunisia',
                'abv' => 'TN',
                'abv3' => 'TUN',
                'abv3_alt' => null,
                'code' => 788,
                'slug' => 'tunisia',
                'phonecode' => '216'
            ],
            [
                'name' => 'Turkey',
                'abv' => 'TR',
                'abv3' => 'TUR',
                'abv3_alt' => null,
                'code' => 792,
                'slug' => 'turkey',
                'phonecode' => '90'
            ],
            [
                'name' => 'Turkmenistan',
                'abv' => 'TM',
                'abv3' => 'TKM',
                'abv3_alt' => null,
                'code' => 795,
                'slug' => 'turkmenistan',
                'phonecode' => '993'
            ],
            [
                'name' => 'Turks and Caicos Islands',
                'abv' => 'TC',
                'abv3' => 'TCA',
                'abv3_alt' => null,
                'code' => 796,
                'slug' => 'turks-and-caicos-islands',
                'phonecode' => '1649'
            ],
            [
                'name' => 'Tuvalu',
                'abv' => 'TV',
                'abv3' => 'TUV',
                'abv3_alt' => null,
                'code' => 798,
                'slug' => 'tuvalu',
                'phonecode' => '688'
            ],
            [
                'name' => 'U.S. Virgin Islands',
                'abv' => 'VI',
                'abv3' => 'VIR',
                'abv3_alt' => null,
                'code' => 850,
                'slug' => 'us-virgin-islands',
                'phonecode' => '1340'
            ],
            [
                'name' => 'Uganda',
                'abv' => 'UG',
                'abv3' => 'UGA',
                'abv3_alt' => null,
                'code' => 800,
                'slug' => 'uganda',
                'phonecode' => '256'
            ],
            [
                'name' => 'Ukraine',
                'abv' => 'UA',
                'abv3' => 'UKR',
                'abv3_alt' => null,
                'code' => 804,
                'slug' => 'ukraine',
                'phonecode' => '380'
            ],
            [
                'name' => 'United Arab Emirates',
                'abv' => 'AE',
                'abv3' => 'ARE',
                'abv3_alt' => null,
                'code' => 784,
                'slug' => 'united-arab-emirates',
                'phonecode' => '971'
            ],
            [
                'name' => 'United Kingdom',
                'abv' => 'UK',
                'abv3' => 'GBR',
                'abv3_alt' => null,
                'code' => 826,
                'slug' => 'united-kingdom',
                'phonecode' => '44'
            ],
            [
                'name' => 'United States',
                'abv' => 'US',
                'abv3' => 'USA',
                'abv3_alt' => null,
                'code' => 840,
                'slug' => 'united-states',
                'phonecode' => '1'
            ],
            [
                'name' => 'Uruguay',
                'abv' => 'UY',
                'abv3' => 'URY',
                'abv3_alt' => null,
                'code' => 858,
                'slug' => 'uruguay',
                'phonecode' => '598'
            ],
            [
                'name' => 'Uzbekistan',
                'abv' => 'UZ',
                'abv3' => 'UZB',
                'abv3_alt' => null,
                'code' => 860,
                'slug' => 'uzbekistan',
                'phonecode' => '998'
            ],
            [
                'name' => 'Vanuatu',
                'abv' => 'VU',
                'abv3' => 'VUT',
                'abv3_alt' => null,
                'code' => 548,
                'slug' => 'vanuatu',
                'phonecode' => '678'
            ],
            [
                'name' => 'Venezuela',
                'abv' => 'VE',
                'abv3' => 'VEN',
                'abv3_alt' => null,
                'code' => 862,
                'slug' => 'venezuela',
                'phonecode' => '58'
            ],
            [
                'name' => 'Viet Nam',
                'abv' => 'VN',
                'abv3' => 'VNM',
                'abv3_alt' => null,
                'code' => 704,
                'slug' => 'viet-nam',
                'phonecode' => '84'
            ],
            [
                'name' => 'Wallis and Futuna Islands',
                'abv' => 'WF',
                'abv3' => 'WLF',
                'abv3_alt' => null,
                'code' => 876,
                'slug' => 'wallis-and-futuna-islands',
                'phonecode' => '681'
            ],
            [
                'name' => 'Western Sahara',
                'abv' => 'EH',
                'abv3' => 'ESH',
                'abv3_alt' => null,
                'code' => 732,
                'slug' => 'western-sahara',
                'phonecode' => '212'
            ],
            [
                'name' => 'Yemen',
                'abv' => 'YE',
                'abv3' => 'YEM',
                'abv3_alt' => null,
                'code' => 887,
                'slug' => 'yemen',
                'phonecode' => '967'
            ],
            [
                'name' => 'Zambia',
                'abv' => 'ZM',
                'abv3' => 'ZMB',
                'abv3_alt' => null,
                'code' => 894,
                'slug' => 'zambia',
                'phonecode' => '260'
            ],
            [
                'name' => 'Zimbabwe',
                'abv' => 'ZW',
                'abv3' => 'ZWE',
                'abv3_alt' => null,
                'code' => 716,
                'slug' => 'zimbabwe',
                'phonecode' => '263'
            ],
        ];

        // Insert the data into the 'countries' table.
        DB::table('countries')->insert($countries);

        // Re-enable foreign key checks after the data insertion.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
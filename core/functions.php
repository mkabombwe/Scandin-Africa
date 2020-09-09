<?php
function random_string($length) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

function logged_in() {
	return (isset($_SESSION['username'])) ? true : false;
}

function user_exists($username, $mysqli) {
	if ($stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?")) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		while (mysqli_num_rows($result)) {
			return true;
		}

		$stmt->close();
	} 
}
function user_id_exists($profile_id, $mysqli) {
	if ($stmt = $mysqli->prepare("SELECT * FROM users WHERE profile_id = ?")) {
		$stmt->bind_param("s", $profile_id);
		$stmt->execute();
		$result = $stmt->get_result();

		while (mysqli_num_rows($result)) {
			return true;
		}

		$stmt->close();
	} 
}
function user_active($username, $mysqli) {
	if ($stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ? AND active = 1")) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		while (mysqli_num_rows($result)) {
			return true;
		}

		$stmt->close();
	} 
}
function user_id_from_username($username, $mysqli) {
	if ($stmt = $mysqli->prepare("SELECT user_id FROM users WHERE username = ?")) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$result = $stmt->get_result();

		return $result;

		$stmt->close();
	} 
}
function login($username, $password, $mysqli) {	
	if ($stmt = $mysqli->prepare("SELECT user_id, username, password, salt FROM users WHERE username = ?")) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($us_id, $u_name, $pass, $salt);
        $stmt->fetch();
        

		$options = [
		'cost' => 12,
		'salt' => $salt,
		];
		$pre_psd = password_hash(trim($password), PASSWORD_BCRYPT, $options);
		$fin_psd = openssl_digest($pre_psd, 'sha512');


		if ($fin_psd == $pass) {
			return true;
		}

		$stmt->close();

	}
}
function ago($time){
   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }

   return "$difference $periods[$j] $tense ";
}
$every_country = array(
	'Afghanistan',
	'Aland Islands',
	'Albania',
	'Algeria',
	'American Samoa',
	'Andorra',
	'Angola',
	'Anguilla',
	'Antarctica',
	'Antigua And Barbuda',
	'Argentina',
	'Armenia',
	'Aruba',
	'Australia',
	'Austria',
	'Azerbaijan',
	'Bahamas',
	'Bahrain',
	'Bangladesh',
	'Barbados',
	'Belarus',
	'Belgium',
	'Belize',
	'Benin',
	'Bermuda',
	'Bhutan',
	'Bolivia',
	'Bosnia And Herzegovina',
	'Botswana',
	'Bouvet Island',
	'Brazil',
	'British Indian Ocean Territory',
	'Brunei Darussalam',
	'Bulgaria',
	'Burkina Faso',
	'Burundi',
	'Cambodia',
	'Cameroon',
	'Canada',
	'Cape Verde',
	'Cayman Islands',
	'Central African Republic',
	'Chad',
	'Chile',
	'China',
	'Christmas Island',
	'Cocos (Keeling) Islands',
	'Colombia',
	'Comoros',
	'Congo',
	'Congo, Democratic Republic',
	'Cook Islands',
	'Costa Rica',
	'Cote D\'Ivoire',
	'Croatia',
	'Cuba',
	'Cyprus',
	'Czech Republic',
	'Denmark',
	'Djibouti',
	'Dominica',
	'Dominican Republic',
	'Ecuador',
	'Egypt',
	'El Salvador',
	'Equatorial Guinea',
	'Eritrea',
	'Estonia',
	'Ethiopia',
	'Falkland Islands (Malvinas)',
	'Faroe Islands',
	'Fiji',
	'Finland',
	'France',
	'French Guiana',
	'French Polynesia',
	'French Southern Territories',
	'Gabon',
	'Gambia',
	'Georgia',
	'Germany',
	'Ghana',
	'Gibraltar',
	'Greece',
	'Greenland',
	'Grenada',
	'Guadeloupe',
	'Guam',
	'Guatemala',
	'Guernsey',
	'Guinea',
	'Guinea-Bissau',
	'Guyana',
	'Haiti',
	'Heard Island & Mcdonald Islands',
	'Holy See (Vatican City State)',
	'Honduras',
	'Hong Kong',
	'Hungary',
	'Iceland',
	'India',
	'Indonesia',
	'Iran, Islamic Republic Of',
	'Iraq',
	'Ireland',
	'Isle Of Man',
	'Israel',
	'Italy',
	'Jamaica',
	'Japan',
	'Jersey',
	'Jordan',
	'Kazakhstan',
	'Kenya',
	'Kiribati',
	'Korea',
	'Kuwait',
	'Kyrgyzstan',
	'Lao People\'s Democratic Republic',
	'Latvia',
	'Lebanon',
	'Lesotho',
	'Liberia',
	'Libyan Arab Jamahiriya',
	'Liechtenstein',
	'Lithuania',
	'Luxembourg',
	'Macao',
	'Macedonia',
	'Madagascar',
	'Malawi',
	'Malaysia',
	'Maldives',
	'Mali',
	'Malta',
	'Marshall Islands',
	'Martinique',
	'Mauritania',
	'Mauritius',
	'Mayotte',
	'Mexico',
	'Micronesia, Federated States Of',
	'Moldova',
	'Monaco',
	'Mongolia',
	'Montenegro',
	'Montserrat',
	'Morocco',
	'Mozambique',
	'Myanmar',
	'Namibia',
	'Nauru',
	'Nepal',
	'Netherlands',
	'Netherlands Antilles',
	'New Caledonia',
	'New Zealand',
	'Nicaragua',
	'Niger',
	'Nigeria',
	'Niue',
	'Norfolk Island',
	'Northern Mariana Islands',
	'Norway',
	'Oman',
	'Pakistan',
	'Palau',
	'Palestinian Territory, Occupied',
	'Panama',
	'Papua New Guinea',
	'Paraguay',
	'Peru',
	'Philippines',
	'Pitcairn',
	'Poland',
	'Portugal',
	'Puerto Rico',
	'Qatar',
	'Reunion',
	'Romania',
	'Russian Federation',
	'Rwanda',
	'Saint Barthelemy',
	'Saint Helena',
	'Saint Kitts And Nevis',
	'Saint Lucia',
	'Saint Martin',
	'Saint Pierre And Miquelon',
	'Saint Vincent And Grenadines',
	'Samoa',
	'San Marino',
	'Sao Tome And Principe',
	'Saudi Arabia',
	'Senegal',
	'Serbia',
	'Seychelles',
	'Sierra Leone',
	'Singapore',
	'Slovakia',
	'Slovenia',
	'Solomon Islands',
	'Somalia',
	'South Africa',
	'South Georgia And Sandwich Isl.',
	'Spain',
	'Sri Lanka',
	'Sudan',
	'Suriname',
	'Svalbard And Jan Mayen',
	'Swaziland',
	'Sweden',
	'Switzerland',
	'Syrian Arab Republic',
	'Taiwan',
	'Tajikistan',
	'Tanzania',
	'Thailand',
	'Timor-Leste',
	'Togo',
	'Tokelau',
	'Tonga',
	'Trinidad And Tobago',
	'Tunisia',
	'Turkey',
	'Turkmenistan',
	'Turks And Caicos Islands',
	'Tuvalu',
	'Uganda',
	'Ukraine',
	'United Arab Emirates',
	'United Kingdom',
	'United States',
	'United States Outlying Islands',
	'Uruguay',
	'Uzbekistan',
	'Vanuatu',
	'Venezuela',
	'Viet Nam',
	'Virgin Islands, British',
	'Virgin Islands, U.S.',
	'Wallis And Futuna',
	'Western Sahara',
	'Yemen',
	'Zambia',
	'Zimbabwe'
);
$every_sector = array(
	'Finance',
	'Oil and Gas',
	'ICT',
	'Agrobusiness and Fishery',
	'Construction',
	'Renewable Energy',
	'Mines and Metal',
	'Child Foundation',
	'Health care and Life services',
	'Training-Business',
	'Services',
	'Other'
);
$every_price = array(
	'0 - 50.000 EUR',
	'50.000 EUR - 100.000 EUR',
	'100.000 EUR - 200.000 EUR',
	'200.000 EUR - 300.000 EUR',
	'300.000 EUR - 400.000 EUR',
	'400.000 EUR - 500.000 EUR',
	'500.000+ EUR',
);
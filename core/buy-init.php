<?php

require_once('stripe/init.php');

$stripe = [
	'secret' => 'STRIPE_SECRET',
	'publishable' => 'STRIPE_PUBLISHABLE'
];

\Stripe\Stripe::setApiKey($stripe['secret']);
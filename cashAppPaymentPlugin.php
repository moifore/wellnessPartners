<?php

/*
 * Plugin Name: Cash App Payment Integration
 * Description: Adds Cash App payment functionality to PANMA site.
 * Version: 1.0
 * Author: TECHPRO AFRICA
 * License: GPL2
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    exit;
}

// Function to generate Cash App payment link
function cashapp_generate_payment_link($amount, $cashtag) {
    $amount = floatval($amount); // Ensure amount is a number
    if ($amount <= 0 || empty($cashtag)) {
        return false;
    }
    return "https://cash.app/{$cashtag}/{$amount}";
}

// Shortcode to display Cash App payment button
function cashapp_payment_shortcode($atts) {
    // Default attributes
    $atts = shortcode_atts(
        array(
            'amount' => '10', // Default amount
            'cashtag' => '$PANMAPANMA', // PANMA $cashtag
            'label' => 'Pay with Cash App', // Button text
        ),
        $atts,
        'cashapp_payment'
    );

    $payment_link = cashapp_generate_payment_link($atts['amount'], $atts['cashtag']);
    
    if (!$payment_link) {
        return '<p>Error: Invalid amount or cashtag.</p>';
    }

    // Generate QR code (optional, requires a QR code library)
    $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($payment_link);

    // Output HTML for payment button and QR code
    $output = '<div class="cashapp-payment">';
    $output .= '<a href="' . esc_url($payment_link) . '" target="_blank" class="cashapp-button">' . esc_html($atts['label']) . '</a>';
    $output .= '<p>Or scan to pay:</p>';
    $output .= '<img src="' . esc_url($qr_code_url) . '" alt="Cash App QR Code" />';
    $output .= '</div>';

    // Add some basic CSS
    $output .= '<style>
        .cashapp-payment { text-align: center; margin: 20px 0; }
        .cashapp-button { 
            display: inline-block; 
            padding: 10px 20px; 
            background-color: #00d632; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
        }
        .cashapp-button:hover { background-color: #00b82b; }
    </style>';

    return $output;
}
add_shortcode('cashapp_payment', 'cashapp_payment_shortcode');
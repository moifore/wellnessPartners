<?php
function cashapp_payment_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'cashtag' => '$PANMAPANMA',
            'label' => 'Pay with Cash App',
        ),
        $atts,
        'cashapp_payment'
    );

    $output = '<div class="cashapp-payment">';
    
    if (isset($_POST['cashapp_amount']) && is_numeric($_POST['cashapp_amount'])) {
        $amount = floatval($_POST['cashapp_amount']);
        $payment_link = cashapp_generate_payment_link($amount, $atts['cashtag']);
        $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($payment_link);

        $output .= '<a href="' . esc_url($payment_link) . '" target="_blank" class="cashapp-button">' . esc_html($atts['label']) . '</a>';
        $output .= '<p>Or scan to pay $' . number_format($amount, 2) . ':</p>';
        $output .= '<img src="' . esc_url($qr_code_url) . '" alt="Cash App QR Code" />';
    } else {
        $output .= '<form method="post">';
        $output .= '<label for="cashapp_amount">Enter Amount ($):</label>';
        $output .= '<input type="number" step="0.01" min="1" name="cashapp_amount" id="cashapp_amount" required />';
        $output .= '<input type="submit" value="Generate Payment Link" />';
        $output .= '</form>';
    }

    if (isset($_POST['cashapp_amount']) && is_numeric(value: $_POST['cashapp_amount'])) {
        $amount = floatval(value: $_POST['cashapp_amount']);
        $payment_link = cashapp_generate_payment_link(amount: $amount)
    }

    if (isset($_POST['cashapp_amount'] && is_numeric()) )

    $output .= '</div>';

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
        form { margin-bottom: 20px; }
        input[type="number"] { padding: 5px; margin-right: 10px; }
        input[type="submit"] { padding: 5px 10px; }
    </style>';

    return $output;
}
add_shortcode('cashapp_payment', 'cashapp_payment_shortcode');
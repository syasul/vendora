<?php

require_once "../module.php";

$json = file_get_contents('php://input');

// ambil callback signature
$callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE'])
    ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE']
    : '';

$privateKey = $rest_sistem['result']['tripay_privatekey'];

// generate signature untuk dicocokkan dengan X-Callback-Signature
$signature = hash_hmac('sha256', $json, $privateKey);

// validasi signature
if ($callbackSignature !== $signature) {
    exit(json_encode([
        'success' => false,
        'message' => 'Invalid signature',
    ]));
}

$data = json_decode($json);

if (JSON_ERROR_NONE !== json_last_error()) {
    exit(json_encode([
        'success' => false,
        'message' => 'Invalid data sent by payment gateway',
    ]));
}

// hentikan proses jika callback event-nya bukan payment_status
if ('payment_status' !== $_SERVER['HTTP_X_CALLBACK_EVENT']) {
    exit(json_encode([
        'success' => false,
        'message' => 'Unrecognized callback event: ' . $_SERVER['HTTP_X_CALLBACK_EVENT'],
    ]));
}

$status = strtoupper((string) $data->status);

if ($data->is_closed_payment === 1) {

    if ($status=='PAID') {
        $arr = array('status' => 'y', 'idtrx' => $data->merchant_ref, 'callback' => $json);
        $rest = loadData('rest_proses/proses_update_transaksi_tripay', $arr);
    }else {
        $arr = array('status' => 'b', 'idtrx' => $data->merchant_ref, 'callback' => $json);
        $rest = loadData('rest_proses/proses_update_transaksi_tripay', $arr);
    }

    if ($rest['code']==0) {
        exit(json_encode([
            'success' => false,
            'message' => 'Invoice not found or already paid: ' . $data->merchant_ref,
        ]));
    }else if ($rest['code']==2) {
        exit(json_encode([
            'success' => false,
            'message' => ' Update failed: ' . $data->merchant_ref,
        ]));
    }else if ($rest['code']==1) {
        exit(json_encode([
            'success' => true
        ]));
    }else{
        exit(json_encode([
            'success' => false,
            'message' => ' Unrecognized payment status: ' . $data->merchant_ref,
        ]));
    }
}
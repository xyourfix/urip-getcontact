<?php

class GetContactAPI {
    private $token;
    private $finalKey;
    private $apiUrl;
    
    public function __construct($token = null, $finalKey = null) {
        $this->token = $token ?: GETCONTACT_TOKEN;
        $this->finalKey = $finalKey ?: GETCONTACT_KEY;
        $this->apiUrl = GETCONTACT_API_URL;
    }
    
    public function checkNumber($number) {
        try {
            if (empty($this->token)) {
                throw new Exception("Token is required!");
            }
            if (empty($this->finalKey)) {
                throw new Exception("Final key is required!");
            }
            
            $number = $this->validateNumber($number);
            
            $payload = [
                'countryCode' => 'us',
                'phoneNumber' => $number,
                'source' => 'profile',
                'token' => $this->token
            ];
            
            $timestamp = (string)(time() * 1000);
            $signature = $this->generateSignature($timestamp, json_encode($payload));
            
            $encryptedData = $this->encrypt(json_encode($payload));
            
            $headers = [
                'X-Os: android 9',
                'X-Mobile-Service: GMS',
                'X-App-Version: 5.6.2',
                'X-Client-Device-Id: 063579f5e0654a4e',
                'X-Lang: en_US',
                'X-Token: ' . $this->token,
                'X-Req-Timestamp: ' . $timestamp,
                'X-Encrypted: 1',
                'X-Network-Country: us',
                'X-Country-Code: us',
                'X-Req-Signature: ' . $signature,
                'Content-Type: application/json'
            ];
            
            $postData = json_encode(['data' => $encryptedData]);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($response === false) {
                throw new Exception("Failed to connect to GetContact API");
            }
            
            $responseData = json_decode($response, true);
            
            if ($httpCode !== 200) {
                throw new Exception("API Error: " . ($responseData['error'] ?? 'Unknown error'));
            }
            
            if (isset($responseData['data'])) {
                $decryptedResponse = $this->decrypt($responseData['data']);
                $jsonResponse = json_decode($decryptedResponse, true);
                
                $tags = [];
                if (isset($jsonResponse['result']['tags'])) {
                    foreach ($jsonResponse['result']['tags'] as $tag) {
                        $tags[] = $tag['tag'];
                    }
                }
                
                return [
                    'success' => true,
                    'number' => $number,
                    'tags' => $tags,
                    'count' => count($tags)
                ];
            }
            
            throw new Exception("Invalid response from API");
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'number' => $number ?? 'Invalid'
            ];
        }
    }
    
    private function validateNumber($number) {
        if (empty($number)) {
            throw new Exception("Number is not defined");
        }
        
        // Remove spaces and dashes
        $number = str_replace(['-', ' '], '', $number);
        
        // Convert Indonesian format
        if (substr($number, 0, 1) === '0') {
            $number = '+62' . substr($number, 1);
        } elseif (substr($number, 0, 2) === '62') {
            $number = '+' . $number;
        }
        
        return $number;
    }
    
    private function encrypt($data) {
        $key = hex2bin($this->finalKey);
        $encrypted = openssl_encrypt($data, 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
        return base64_encode($encrypted);
    }
    
    private function decrypt($data) {
        $key = hex2bin($this->finalKey);
        $decrypted = openssl_decrypt(base64_decode($data), 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
        return $decrypted;
    }
    
    private function generateSignature($timestamp, $message) {
        $key = hex2bin('793167597c4a25263656206b5469243e5f416c69385d2f7843716d4d4d503124');
        $signature = hash_hmac('sha256', $timestamp . '-' . $message, $key, true);
        return base64_encode($signature);
    }
}
?>
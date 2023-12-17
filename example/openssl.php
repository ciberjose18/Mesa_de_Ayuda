<?php

/**TODO: Datos a cifrar */
$data = "123456";
/**TODO: Clave de cifrado asegurarse de usar una clave segura */
$key = "mi_key_987";
/**TODO: Metodo de cifrado */
$cipher = "aes-256-cbc";


/**TODO: Vector de inicialiacion necesario para el cifrado */
$ivLength = openssl_cipher_iv_length($cipher);
$iv = openssl_random_pseudo_bytes($ivLength);

/**TODO: Cifrado */
$output = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
// Verificar si el cifrado fue exitoso
if ($output === false) {
    exit('Error en el cifrado');
}
/* Concatenar el IV al texto cifrado */
$cifrado = base64_encode($iv . $output);
/* Obtener el IV del texto cifrado */
$iv_dec = substr(base64_decode($cifrado), 0, openssl_cipher_iv_length($cipher));
/* Obtener el texto cifrado sin el IV */
$cifradoSinIV = substr(base64_decode($cifrado), openssl_cipher_iv_length($cipher));
/**TODO: desifrado */
$decifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

// Mostrar texto cifrado
echo "Texto Cifrado: " . $cifrado;
echo "<br>Texto Decifrado: " . $decifrado;

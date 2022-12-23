<?php

// Fungsi enkripsi
function encrypt($plaintext, $key) {
    // Menambahkan "x" ke dua karakter yang sama berurutan
    $i = 0;
    while ($i < strlen($plaintext) - 1) {
        if ($plaintext[$i] == $plaintext[$i + 1]) {
            $plaintext = substr_replace($plaintext, "x", $i + 1, 0);
        }
        $i++;
    }
    
    // Menambahkan "x" ke akhir jika panjang kata ganjil
    if (strlen($plaintext) % 2 == 1) {
        $plaintext .= "x";
    }
    
    // Memecah teks menjadi blok 2 karakter
    $blocks = str_split($plaintext, 2);
    
    // Menghitung ukuran matriks kunci
    $key_size = count($key);
    
    // Enkripsi blok teks
    $ciphertext = "";
    foreach ($blocks as $block) {
        // Memecah blok teks menjadi array
        $characters = str_split($block);
        
        // Menghitung nilai blok teks yang terdekripsi
        $encrypted_block = "";
        for ($i = 0; $i < $key_size; $i++) {
            $encrypted_block .= chr(($key[$i][0] * ord($characters[0]) + $key[$i][1] * ord($characters[1])) % 26 + 65);
        }
        
        // Menambahkan blok terdekripsi ke ciphertext
        $ciphertext .= $encrypted_block;
    }
    
    return $ciphertext;
}

// Fungsi dekripsi
function decrypt($ciphertext, $key) {
    // Menghitung ukuran matriks kunci
    $key_size = count($key);
    
    // Memecah teks menjadi blok 2 karakter
    $blocks = str_split($ciphertext, 2);
    
    // Dekripsi blok teks
    $plaintext = "";
    foreach ($blocks as $block) {
        // Memecah blok teks menjadi array
        $characters = str_split($block);
        
        // Menghitung nilai blok teks yang terdekripsi
        $decrypted_block = "";
        for ($i = 0; $i < $key_size; $i++) {
            $decrypted_block .= chr((($key[$i][0] * (ord($characters[0]) - 65)) - ($key[$i][1] * (ord($characters[1]) - 65))) % 26 + 65);
        }
        
        // Menambahkan blok terdekripsi ke plaintext
        $plaintext .= $decrypted_block;
    }
    
    return $plaintext;
}

// Contoh penggunaan
$plaintext = "Hello, world!";
$key = [[2, 3], [1, 1]];
$ciphertext = encrypt($plaintext, $key);
echo "Plaintext: $plaintext\n";
echo "Ciphertext: $ciphertext\n";
echo "Decrypted plaintext: " . decrypt($ciphertext, $key) . "\n";

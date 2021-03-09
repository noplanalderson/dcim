<?php defined('BASEPATH') OR exit('No Direct Script Access Allowed');

	function encrypt($id)
	{
		/**
		 * 
		 * Ini adalah Method untuk mengenkripsi id data atau pun file dan direktori
		 * 
		 * @param $id akan dienkripsi terlebih dahulu dengan md5()
		 *
		 * Lalu dipecah menjadi beberapa blok dan diacak
		 *
		 * @return $blok[i]
		 * 
		*/
		$hash  = md5($id);
		$blok1 = substr($hash, 0,8);
		$blok2 = substr($hash, 8,8);
		$blok3 = substr($hash, 16,4);
		$blok4 = substr($hash, 20,4);
		$blok5 = substr($hash, 24,8);

		return $blok2.'-'.$blok4.'-'.$blok5.'-'.$blok3.'-'.$blok1;
	}

	function decrypt($id)
	{
		/**
		 *
		 * @param $id adalah parameter yang akan dikembalikan nilainya
		 * ke enkripsi md5()
		 *
		 * Sebelum dikembalikan, validasi terlebih dahulu 
		 * string dan panjang karakter dari $id
		 *
		 * Karakter yang diizinkan hanya huruf,angka (0-9), dan dash (-)
		 * dengan panjang karakter 36
		 * 
		 * Jika validasi cocok, maka akan mengembalikan nilai $hash
		 * Jika tidak, maka kembalikan nilai false
		 *
		*/
		$id = preg_replace("/[^a-z0-9\-]/", "", $id);
		if(strlen($id) == 36)
		{
			$hash = explode("-", $id);
			$hash = $hash[4].$hash[0].$hash[3].$hash[1].$hash[2];
			return $hash;
		}
		else
		{
			return false;
		}
	}

	function encodeImage($path)
	{
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

		return $base64;
	}
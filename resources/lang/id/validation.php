<?php

return [
	
	/*
	|---------------------------------------------------------------------------------------
	| Baris Bahasa untuk Validasi
	|---------------------------------------------------------------------------------------
	|
	| Baris bahasa berikut ini berisi standar pesan kesalahan yang digunakan oleh
	| kelas validasi. Beberapa aturan mempunyai multi versi seperti aturan 'size'.
	| Jangan ragu untuk mengoptimalkan setiap pesan yang ada di sini.
	|
	*/
	
	'accepted'             => 'Isian :attribute harus diterima.',
	'active_url'           => 'Isian :attribute bukan URL yang valid.',
	'after'                => 'Isian :attribute harus tanggal setelah :date.',
	'alpha'                => 'Isian :attribute hanya boleh berisi huruf.',
	'alpha_dash'           => 'Isian :attribute hanya boleh berisi huruf, angka, dan strip.',
	'alpha_num'            => 'Isian :attribute hanya boleh berisi huruf dan angka.',
	'array'                => 'Isian :attribute harus berupa sebuah array.',
	'before'               => 'Isian :attribute harus tanggal sebelum :date.',
	'between'              => [
		'numeric' => 'Isian :attribute harus antara :min dan :max.',
		'file'    => 'Isian :attribute harus antara :min dan :max kilobytes.',
		'string'  => 'Isian :attribute harus antara :min dan :max karakter.',
		'array'   => 'Isian :attribute harus antara :min dan :max item.',
	],
	'boolean'              => 'Isian :attribute harus berupa true atau false',
	'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
	'date'                 => 'Isian :attribute bukan tanggal yang valid.',
	'date_format'          => 'Isian :attribute tidak cocok dengan format :format.',
	'different'            => 'Isian :attribute dan :other harus berbeda.',
	'digits'               => 'Isian :attribute harus berupa angka :digits.',
	'digits_between'       => 'Isian :attribute harus antara angka :min dan :max.',
	'dimensions'           => 'Kolom :attribute tidak memiliki dimensi gambar yang valid.',
	'distinct'             => 'Kolom isian :attribute memiliki nilai yang duplikat.',
	'email'                => 'Isian :attribute harus berupa alamat surel yang valid.',
	'exists'               => 'Isian :attribute yang dipilih tidak valid.',
	'file'                 => 'Kolom :attribute harus berupa sebuah berkas.',
	'filled'               => 'Kolom isian :attribute wajib diisi.',
	'image'                => 'Isian :attribute harus berupa gambar.',
	'in'                   => 'Isian :attribute yang dipilih tidak valid.',
	'in_array'             => 'Kolom isian :attribute tidak terdapat dalam :other.',
	'integer'              => 'Isian :attribute harus merupakan bilangan bulat.',
	'ip'                   => 'Isian :attribute harus berupa alamat IP yang valid.',
	'json'                 => 'Isian :attribute harus berupa JSON string yang valid.',
	'max'                  => [
		'numeric' => 'Isian :attribute seharusnya tidak lebih dari :max.',
		'file'    => 'Isian :attribute seharusnya tidak lebih dari :max kilobytes.',
		'string'  => 'Isian :attribute seharusnya tidak lebih dari :max karakter.',
		'array'   => 'Isian :attribute seharusnya tidak lebih dari :max item.',
	],
	'mimes'                => 'Isian :attribute harus dokumen berjenis : :values.',
	'mimetypes'            => 'Isian :attribute harus dokumen berjenis : :values.',
	'min'                  => [
		'numeric' => 'Isian :attribute harus minimal :min.',
		'file'    => 'Isian :attribute harus minimal :min kilobytes.',
		'string'  => 'Isian :attribute harus minimal :min karakter.',
		'array'   => 'Isian :attribute harus minimal :min item.',
	],
	'not_in'               => 'Isian :attribute yang dipilih tidak valid.',
	'numeric'              => 'Isian :attribute harus berupa angka.',
	'present'              => 'Kolom isian :attribute wajib ada.',
	'regex'                => 'Format isian :attribute tidak valid.',
	'required'             => 'Kolom isian :attribute wajib diisi.',
	'required_if'          => 'Kolom isian :attribute wajib diisi bila :other adalah :value.',
	'required_unless'      => 'Kolom isian :attribute wajib diisi kecuali :other memiliki nilai :values.',
	'required_with'        => 'Kolom isian :attribute wajib diisi bila terdapat :values.',
	'required_with_all'    => 'Kolom isian :attribute wajib diisi bila terdapat :values.',
	'required_without'     => 'Kolom isian :attribute wajib diisi bila tidak terdapat :values.',
	'required_without_all' => 'Kolom isian :attribute wajib diisi bila tidak terdapat ada :values.',
	'same'                 => 'Isian :attribute dan :other harus sama.',
	'size'                 => [
		'numeric' => 'Isian :attribute harus berukuran :size.',
		'file'    => 'Isian :attribute harus berukuran :size kilobyte.',
		'string'  => 'Isian :attribute harus berukuran :size karakter.',
		'array'   => 'Isian :attribute harus mengandung :size item.',
	],
	'string'               => 'Isian :attribute harus berupa string.',
	'timezone'             => 'Isian :attribute harus berupa zona waktu yang valid.',
	'unique'               => 'Anda sudah terdaftar sebelumnya. ',
	//    'unique'               => 'Isian :attribute sudah ada sebelumnya.',
	'uploaded'             => 'The :attribute uploading failed.',
	'url'                  => 'Format isian :attribute tidak valid.',
	
	/*
	|---------------------------------------------------------------------------------------
	| Baris Bahasa untuk Validasi Kustom
	|---------------------------------------------------------------------------------------
	|
	| Di sini Anda dapat menentukan pesan validasi kustom untuk atribut dengan menggunakan
	| konvensi "attribute.rule" dalam penamaan baris. Hal ini membuat cepat dalam
	| menentukan spesifik baris bahasa kustom untuk aturan atribut yang diberikan.
	|
	*/
	
	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
		'email'          => [
			'unique' => 'Email yang Anda masukkan sudah terdaftar'
		],
		'no_sid'         => [
			'unique' => 'No SID yang Anda masukkan sudah terdaftar'
		],
		'agree_ol'       => [
			'required' => 'Anda belum mencentang pernyataan persetujuan'
		]
	],
	
	/*
	|---------------------------------------------------------------------------------------
	| Kustom Validasi Atribut
	|---------------------------------------------------------------------------------------
	|
	| Baris bahasa berikut digunakan untuk menukar atribut 'place-holders'
	| dengan sesuatu yang lebih bersahabat dengan pembaca seperti Alamat Surel daripada
	| "surel" saja. Ini benar-benar membantu kita membuat pesan sedikit bersih.
	|
	*/
	
	'attributes' => [
		'name'              => 'Nama',
		'no_hp'             => 'Nomor Handphone',
		'email'             => 'Email',
		'password'          => 'Password',
		'sid_card'          => 'Kartu SID',
		'no_sid'            => 'No SID',
		'tanggal_lahir'     => 'Tanggal Lahir',
		'tgl_lahir'         => 'Tanggal Lahir',
		'bulan_lahir'       => 'Bulan Lahir',
		'tahun_lahir'       => 'Tahun Lahir',
		'profesi'           => 'Profesi',
		'tmp_lahir'         => 'Tanggal Lahir',
		'no_ktp'            => 'No KTP',
		'jns_kelamin'       => 'Jenis Kelamin',
		'alamat_ktp'        => 'Alamat Sesuai KTP',
		'alamat_skrng'      => 'Alamat Sekarang',
		'is_lulus_s1'       => 'Lulus/Blm Lulus S1',
		'is_confirm'        => 'Konfirmasi',
		'link_video'        => 'Video Youtube',
		'kd_program'        => 'Program',
		'no_sk_ojk'         => 'No Surat Keputusan Izin',
		'tgl_sk_ojk'        => 'Tanggal Surat Keputusan Izin',
		'upload_surat_izin' => 'Upload Surat Keputusan Izin',
		'company'           => 'Instansi',
		'jabatan'           => 'Jabatan',
	],

];

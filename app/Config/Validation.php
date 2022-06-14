<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    // Validasi Login
    public $login = [
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Username Tidak Boleh Kosong!'
            ]
        ],
        'password' => [
            'label'  => 'Password',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Password Tidak Boleh Kosong!'
            ]
        ]
    ];

    // Validasi Data sampah
    public $sampah = [
        'nama_sampah' => [
            'label'  => 'Nama Sampah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Sampah tidak boleh kosong!'
            ]
        ],
        'id_jenis' => [
            'label'  => 'Jenis Sampah',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Jenis Sampah tidak boleh kosong!'
            ]
        ],
        'id_satuan' => [
            'label'  => 'Satuan',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Satuan tidak boleh kosong!'
            ]
        ],
        'deskripsi' => [
            'label'  => 'Deskripsi',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Deskripsi tidak boleh kosong!'
            ]
        ],
        'harga' => [
            'label'  => 'Harga',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Harga tidak boleh kosong!'
            ]
        ],
        'foto' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];

    // Validasi Jenis
    public $jenis = [
        'nama_jenis' => [
            'label'  => 'Nama Jenis',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Jenis Tidak Boleh Kosong!'
            ]
        ]
    ];

    // Validasi Satuan
    public $satuan = [
        'nama_satuan' => [
            'label'  => 'Nama Satuan',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama Satuan Tidak Boleh Kosong!'
            ]
        ]
    ];

    // Validasi Data user
    public $user_add = [
        'nama_user' => [
            'label'  => 'Nama User',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama User tidak boleh kosong!'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Username tidak boleh kosong!'
            ]
        ],
        'password' => [
            'label'  => 'Password',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Password tidak boleh kosong!'
            ]
        ],
        'level' => [
            'label'  => 'Level',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Level tidak boleh kosong!'
            ]
        ],
        'foto' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];
    public $user_edit = [
        'nama_user' => [
            'label'  => 'Nama User',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama User tidak boleh kosong!'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Username tidak boleh kosong!'
            ]
        ],
        'level' => [
            'label'  => 'Level',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Level tidak boleh kosong!'
            ]
        ],
        'foto' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];

    public $profil = [
        'nama_user' => [
            'label'  => 'Nama User',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Nama User tidak boleh kosong!'
            ]
        ],
        'username' => [
            'label'  => 'Username',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Username tidak boleh kosong!'
            ]
        ],
        'level' => [
            'label'  => 'Level',
            'rules'  => 'required',
            'errors' => [
                'required' => 'Level tidak boleh kosong!'
            ]
        ],
        'foto' => [
            'label'  => 'Foto',
            'rules'  => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'max_size' => 'Ukuran File Foto maksimal 2MB!',
                'is_image' => 'Yang anda pilih bukan gambar!',
                'mime_in'  => 'Format Foto tidak sesuai!'
            ]
        ]
    ];
}

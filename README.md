# Rewaste World

This application was created with the intention of reducing household waste which usually only ends up in landfills. With this application, you can connect customers with businesses, one of the concepts of the C2B business model that can be used for sustainable projects.
 
The application was built by Code Igniter 4 Framework Using PHP 7 .

## Feature App
- Backhend (Admin)
  - [x] Login
  - [x] Dashboard
  - [x] Penarikan Saldo
  - [x] Data Sampah
  - [x] Jenis Sampah
  - [x] Satuan Sampah
  - [x] Data Nasabah
  - [x] Pengaturan Profil
  - [x] Managemen User
  - [x] LogOut
- Backhend (Staff)
  - [x] Login
  - [x] Dashboard
  - [x] Setor Sampah
  - [x] Pengaturan Profil
  - [x] LogOut

- Frontend
  - [x] Login
  - [x] Register
  - [x] Visi dan Misi
  - [x] Tentang Kami
- Frontend (Nasabah)
  - [x] Dashboard
  - [x] Setor Sampah
  - [x] Data Rekening
  - [x] Penarikan Saldo
  - [x] Pengaturan Profil
  - [x] LogOut


## Required Software & Installation
- [GIT](https://git-scm.com/downloads)
- [XAMPP](https://www.apachefriends.org/download.html) or [Laragon](https://laragon.org/download/index.html)
- [Composer](https://getcomposer.org/download/)

### Note For XAMPP User
there was a problem with Intl extension so do this step : 

1. Go To ../xampp/php/php.in
2. Search For this Part 
```bash
...
;extension=php_intl.dll 
...
```
3. Delete the semicolon so its looks like these
```bash
...
extension=php_intl.dll 
...
```

4. Save File
5. Restart XAMPP


## Usage
1. Download [The File](https://github.com/tiangithub123/aplikasi-bank-sampah-ci4)
2. Move The File To Directory ../xampp/htdocs
3. Open XAMPP
4. Turn On MySQL & Apache Server 
5. Open Project By Using Text Editor Like [Visual Studio Code](https://code.visualstudio.com/download) or [Sublime](https://www.sublimetext.com/3)
6. Open Terminal make sure that the directory of terminal is same with the project 
7. Write Down and Run (By Pressing Enter) This Command On Terminal :
```bash
composer install
cp env .env
```
8. On the .env file look for : 
```bash
...
#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = ci4_bank_sampah
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi
# database.default.DBPrefix =
...
```
9. Delete the root on the *database.default.password* value so its looks like this : 
```bash
...
#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = ci4_bank_sampah
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
# database.default.DBPrefix =
...
```
10. go to *database.default.database* and copy the  value :
```bash
...
database.default.database = ci4_bank_sampah
...
```
- so the copy value looks like : 
```bash
ci4_bank_sampah
```

11. Open some Browser and  to [https://localhost/phpmyadmin](https://localhost/phpmyadmin)
12. After it opened make a database with the same name that you copied before 
13. Write Down and Run (By Pressing Enter) This Command On Terminal :
```bash
php spark migrate
php spark db:seed DataSeeder
```
14. Last Run server  by using  Write Down and Run (By Pressing Enter) This Command On Terminal :

```bash
php spark serve
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)

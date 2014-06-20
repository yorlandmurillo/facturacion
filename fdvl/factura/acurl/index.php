<?php
require ('acurl.class.php'); 
$acurl = new acurl();

 //$answer = $acurl->ftp_upload('/path/to/my/file.txt', 'ftp.abstraction.fr/path/to/file.txt', 21, 'Absynthe', 'mypassword');
 $acurl->ftp_download('103-16-07-10-14-02.sql.bz2', '190.202.87.5/database/103/103-16-07-10-14-02.sql.bz2', 21, 'libsurfundacion', 'libsuradmsistem03');
?>

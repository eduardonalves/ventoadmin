<?php
// your connection
mysql_connect("db512657722.db.1and1.com","dbo512657722","MysqlLogOn");
mysql_select_db("db512657722");
 
// convert code
$res = mysql_query("SHOW TABLES");
while ($row = mysql_fetch_array($res))
{
    foreach ($row as $key => $table)
    {
        mysql_query("ALTER TABLE " . $table . " CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci");
        echo $key . " => " . $table . " CONVERTED
";
    }
}
?>

下载连接mssql数据库的扩展
http://go.microsoft.com/fwlink/?LinkId=163712
把对应的数据放入php的扩展里面
H:\myphp\php\php-7.0.12-nts\ext
ps:每人人可能都有不一样的路径 具体看个人项目  然后打开php.ini 添加如下语句 并重启服务器
extension=php_pdo_sqlsrv_7_nts_x86.dllextension=php_sqlsrv_7_nts_x86.dll
并且下载对应的驱动文件
https://www.microsoft.com/en-us/download/details.aspx?id=53339

数据库配置文件db.php

支付配置文件 config.php

@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\ingres\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\ingres\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\mysql\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\mysql\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\postgresql\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\apache\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\apache\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\openoffice\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\apache-tomcat\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\resin\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\resin\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\jetty\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\jetty\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\subversion\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\lucene\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\lucene\scripts\ctl.bat START)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\third_application\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\third_application\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\third_application\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\lucene\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\subversion\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\subversion\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\jetty\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\jetty\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\resin\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\resin\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\Users\ACER\Documents\lab\Projects\WP_PJ\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\openoffice\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\apache\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\apache\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\ingres\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\ingres\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\mysql\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\mysql\scripts\ctl.bat STOP)
if exist C:\Users\ACER\Documents\lab\Projects\WP_PJ\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\ACER\Documents\lab\Projects\WP_PJ\postgresql\scripts\ctl.bat STOP)

:end


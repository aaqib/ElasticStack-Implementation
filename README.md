<pre>
Company: Cloudways Ltd. www.cloudways.com

Developed on:
Apache Version :
    2.2.21
PHP Version :
    5.3.8
MySQL Version :
    5.5.16	

This OpenSource Tool is created to automate the process of creating/managing servers and several other tasks on ElasticStack based Clouds.  
It automates some frequent tasks ( like uploading custom images ) which otherwise take more time if done via "command line" tool, 
managing pre-defined parameters to avoid human-errors, Drive, VLANS and other resources management etc
	
Please update vars.php file first resides under system/include directory and set variable according to your environment.

Directory Structure

|-- docs (contains project documents)
|-- keys (contains key (.pem) files to communicate with server - optional)
|-- modules (here are the files which are basically related to Elastic Hosts)
|		|-- cms
|		|	|-- ajax_content
|		|-- setup
|		|	|-- ajax_content
|-- scripts (contains script (.ssh) files to communicate with server - optional)
|-- system
|		|-- classes (3rd party resources)
|		|-- editor (fck editor resources)
|		|-- front-hand (UI include file header, navigation, footer etc)
|		|-- include (eh_funcs.php, vars.php, config.php are the files to focus on)
|		|-- js (project js files)
|-- template
		|-- default_1 (template css files and images)

modules directory:
modules directory contains file which holds all UI of the project. All CMS related pages are prt of 'cms' directory while EH operations are in 'setup' directory.
Pages are based on ajax so both cms and setup directory further holds 'ajax_content' directories. 

include directory:
- include directory contains config.php and vars.php files which can be updated according to your requirement.
- eh_funcs.php is the wrapper class of elastic hosts and contains all function to communicate with EH.
- com_cms_funcs.php is the file which generates table colums and action links on pages of cms and setup directory.

credits:
https://phpseclib.com/
</pre>
# Nnginx Web Server & Web Server monitoring tool (updownio)
## Description
This repository includes a basic nginx/php webserver with a few extra features. The web server comes pre-packaged with three services within the document root, all password protected using an .htpaccess file. The following urls can be accessed:
- /Drive
- /Media
- /updownio

##### Drive
Allows for file upload, download, and deletion
##### Media
Simple url space for downloading media stored at this address space 
##### Updownio
The updownio interface can be accessed at:
```
ip_address/updownio
```
The defeult admin login is:
```
admin:admin
```
This can be changed by changing the SHA256 hash on line **31** in `Dockerfiles/sources.sql`

To enable email notfications for updownio:
1. Uncomment lines **65 - 67** in `Dockerfiles/ping_script.sh`
2. Edit lines in **33 - 40** in `webroot/updownio/mail.php`
```PHP
...
$mail->Host = 'smtp.gmail.com';			# Replace with your email providers outgoing smpt server
$mail->Port = 587;				# Relace with according port (587 is secure) 
$mail->SMTPAuth = true;				# Authenticate True/Falsez`
$mail->Username = 'example@gmail.com';		# Your email address 
$mail->Password = '123456';		# Your email password
$mail->setFrom('example@gmail.com', 'updown.io');	# Your email address and email 'name' (e.g: 'bob@gmail.com', 'Bob Smith')
$mail->addReplyTo('noreply', 'updown.io');				
$mail->addAddress('bobsmith@gmail.com', 'Bob Smith');	# Option to add more addresses
...
```
## Install
Download Repository
```
git clone git@github.com:leespe11/rpi-nginx-website-moniting.git
````
Change the configuration of **config.env** based on your requirments 

Execute permissions for run script
```
chmod +x run
```
Start the service
```
./run
```
# Strings

## Overview
Strings is an open discussion platform aiming to allow users to engage in immersive and engaging conversations. We strive to provide our users the ultimate discussion space, where users have the ability to view, comment, and rate other posts. Our diverse collection of topics ensures that there is always an interest every post. Come experience what you've been missing out on, on Strings!

## Tips

### Testing on your end

1. git clone the repository into your htdocs folder

2. access the application at: localhost/strings/

### Interacting with DB:

1. Need to start MySQL DB in XAMPP

2. Go to config.php and comment/uncomment DB info for Server or Personal DB (we are using my student num for server 90172180)

3. Server: https://cosc360.ok.ubc.ca/phpmyadmin   Personal: http://localhost/phpmyadmin

4. Use the strings.sql file in our GitHub repo for the DB schema stuff...

### Script for Server pulls from public_html
cd strings/; git stash; git pull; cd ..; chmod -R 775 strings/;

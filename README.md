# PrivatePastes
Simple, clean self destructing note site!

By reading this project's source code, compiling as a binary, redistributing assets found in this repository, etc, or ANY form of use, you must agree to the license enlisted below.

### [Demo] (http://suicide.pw/paste/)

# Features
- [x] Self destructing pastes
- [x] Rijndael 256 paste encryption
- [x] Option to make paste accessible by multiple people
- [x] Deleting own pastes
- [x] Limit number of pastes per IP
- [x] AJAX operations
- [x] Fluid, interactive theme
- [ ] Users
- [ ] Syntax highlighting

# Credits
- [MaterializeCSS] (http://materializecss.com/) Used this theme for a clean, simple and flat design
- [jacoborus] (https://github.com/jacoborus) Used his 'nanobar' for the loader
- [PrivNote] (https://privnote.com/) Got the idea for this from their site
- [FontAwesome] (https://fortawesome.github.io/Font-Awesome/icons/) The favicon uses their 'pencil-square' icon

# Usage
## On a VPS

Simply edit 'config.php' to work with your MySQL installation and then run 'install.php'. Then delete 'install.php' as it can be a security risk.

## On cPanel

Create a database and user (with all permissions) to be used for this project. Put in the username, password and database name into 'config.php', along with the host. Edit 'install.php' by replacing the part where it creates the database with 'true', and then run the script like normal. And then delete it.

## Manual
Create database
```SQL
CREATE DATABASE <your database name>
```
Create table
```SQL
CREATE TABLE IF NOT EXISTS `<your table name>` (
  `prime_key` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL, `access_key` text NOT NULL,
  `create_ip` text NOT NULL,
  `create_time` text NOT NULL,
  `melt` int(11) NOT NULL,
  PRIMARY KEY (`prime_key`)
)
```
Of course, all the variables have to be filled in, in the config, but if you're doing manual installation; you know that.

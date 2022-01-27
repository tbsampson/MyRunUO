# MyRunUO
Website and server scripts to display character, guild, and shard information for ServUO Ultima Online server

How to setup MyRunUO
This guide assumes you have a basic understanding of web hosting, mysql (phpMyAdmin or HeidiSQL), editing php files (Notepad++, or your favorite editor), and ServUO basics.
This will work on both Linux and Windows.  You will need MySQL dotnet connector: https://dev.mysql.com/downloads/connector/net/
For Windows users, create a dsn 

Step 1 – Creating your database
Create a new database in MySQL and create the tables using the SQL file in the /sql folder.  If your MySQL server is not on the same server as your website, be sure to allow remote access.  Make your password long and complicated, use copy/paste to save it somewhere safe.

Step 2 – Adding the MyRunUO scripts to your Shard
The existing MyRunUO files with ServUO and RunUO should be deleted first.  In your Shard root directory, find and delete the contents of /Scripts/Services/MyRunUO  directory, then copy the files from the /scripts directory of this distribution into your /Scripts/Services/MyRunUO  directory.

*** Note: you will need to update your existing /Scripts/Misc/PlayerMoble.cs ***
around line 220 look for "private DesignContext m_DesignContext;"  and paste the following just after it:
// MyRunUO Start
	public bool PublicMyRunUO;
	public bool ChangedMyRunUO;
// MyRunUO End

Step 3 – Editing /Scripts/Services/MyRunUO/Config.cs
Using your favorite text editor, edit the Config.cs file, change these settings, and save the file
-------------------------------------------------------------
public const string DatabaseServer = "localhost"; //This is your server’s name (fqdn or IP address)
public const string DatabaseName = "myrunuo";// This is the name of the database you create in step 1
public const string DatabaseUserID = "root";//This is the login name for your database
public const string DatabasePassword = "";// This is the password for your database login
// Export character database every 30 minutes
public static TimeSpan CharacterUpdateInterval = TimeSpan.FromMinutes(1.0); // **time between full updates
 // Export online list database every 5 minutes
public static TimeSpan StatusUpdateInterval = TimeSpan.FromMinutes(1.0); // **time between online player updates
-------------------------------------------------------------
** Note, for testing, leave the time intervals at 1.0, but change after you confirm its working to 30 & 5.

** Note, see comments in Config.cs for dsn (ODBC Data Sources) if you are a Windows user and need to use a dsn.

Step 4 – Verify MyRunUO server scripts are working properly.
Launch your server and watch the status screen.  You should see success messages after about one minute.  If you have errors, check that your settings again in the Config.cs file.  You can also find help on the forums at www.servuo.com.
If everything is working properly, stop your server and change the time intervals in your Config.cs file to save bandwidth and CPU on your servers.

Step 5 – Upload the web files
Make a home somewhere for your MyRunUO website.  PHP 5 or newer is required.  Upload the contents of the /www directory to your web root.
Edit the file config.php file and enter your Shard and Database server information, and save the file.

// Path
$base_ref="localhost"; // This is the root URL where your MyRunUO resides, minus the http://

// Shard Info - This will appear on your logo and also in the Razor setup image.
$shard_name="My Shard"; //Your shard name
$shard_addr="localhost"; //  Your server name (ie. servuo.myhost.com)
$shard_port="2593"; //  your server port

// Edit your database settings:
$SQLhost = "localhost"; // Your database server name (same as in Step 3)
$SQLport = "3306";// Your database server port, in most cases 3306 
$SQLuser = "root";// Your database server login name (same as in Step 3)
$SQLpass = "";// Your database server password (same as in Step 3)
$SQLdb   = "myrunuo";// The name of the database you created in Step 1


Step 6 – Upload the MUL files
If they were not included in this distribution in the /www/MUL_FILES directory, then you will need to copy a few files from the first Stygian Abyss Classic distribution of Ultima Online.  This should be easy to find online.  You cannot use these files from newer clients.  As of now, I have not been able to get newer files to work.  The files you need to add to your website in the /MUL_FILES directory are:
gumpart.mul
gumpidx.mul
hues.mul
tiledata.mul
Without this files, the player paperdolls will not display correctly.  If your characters are all naked, then you have the wrong version of these files.
Step 7 – Check Your MyRunUO website
You should now see your servers players and guilds listed.  Please note, if you just made a new shard, the shard owners characters will not show up.  Make a new non-owner account and a few characters.
For support, check the forums on www.servuo.com and search for MyRunUO.

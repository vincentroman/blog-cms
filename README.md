<h1 align="center">Blog CMS</h1>
<p>A blogging system built in php that hadles an admin user, registration of regular users/bloggers 
and will eventually be able to have subscribers. This specific code base is a little messy at the 
and will be under continuous refactoring. But feel free to check it out and play with it yourself.</p>

<h3>Set Up</h3>
<ol>
    <li>Open the file '/includes/db.php' and add your database credentials to the DSN, USERNAME and PASSWORD constants for the PDO instance. The application was tested with mysql.</li>
    <li>Open the file '/createtables.sql' and run all the queries in that file from top to bottom.</li>
    <li>Visit '/register' and fill in the form to create a user account. Afterwards, you will be routed back to the '/index.php' page.</li>
    <li>As of right now, the account you just made was a user account which will not allow you to see any of the admin pages, to become and admin, visit '/toAdmin.php'. What you should see is "You are now the admin user". Click the button to go back to the login page.</li>
    <li>Login in as the user that you just registered and you should see the Dashboard. In the info card, it should say that your users role is 'Admin'. If you see this page, everything was a success!</li>
</ol>

<p>Have fun checking out the application. Some functionality may not be present right away.</p>

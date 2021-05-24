<h1>Group 33</h1>

This is the README for the database project for the course IDATG2204, this file contains information about deployment as well as some test cases and endpoints. 
**For the full Endpoint documentation see the Endpoint Documentation in the doc folder**
For a detailed description of the project see the project report found on Inspera. 

**Use software like postman to make API requests**

<h2>Local deployment guide</h2>

1. Clone git repo
2. Configure .htaccess file (located in *xampp/htdocs/*) with the following data:

```bash
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule dbproject-33/(.*)$ dbproject-33/v0.1/api.php?request=$1 [QSA,NC,L]
```

3. Setup PHPStorm: settings -> Build Execution Deployment -> Deployment -> + -> localhost -> 

    Connection:

    - Folder: Path to *xampp/htdocs/*
    - Web server URL: http://localhost

    Mappings:

    - Deployment path: `dbproject-33/v0.1`
    - Web path: `/dbproject-33`

    Excluded Paths: Exclude local paths; tests, doc and vendor folders.

4. Start XAMPP: Apache + MySQL

5. Import database with the test data from `dbproject-33\doc\physical_database\assignment_project_with_data.sql`

6. Configure dbCredentials.php (copy-paste dbCredentialsTemplate.php and rename) with *DB_NAME*, *DB_USER* and *DB_PWD*.

7. Right click root directory -> Deployment -> Upload to localhost 

8. Configure Postman with authorization cookie: 

    1. We assume that you have now created a request and is ready to send it to the API. Under the send button, click on "Cookies".
    2. Input the domain that you are using to access the API (probably localhost or 127.0.0.1), and press "Add".
    3. "Add cookie". Modify the cookie name and value, `Cookie_3=value;` -> `auth_token=c9caceea4162fdad403fbdf926ebc9ebf6b9f37688fbb051c15913cc3058c739;`
    4. Do not modify anything else, just save!

9. Call endpoints in postman  (**see examples below**)



## Authorization:

The authorization is done through cookies, and we have one cookie for each endpoint:

| User (endpoint level) | Token                                                        |
| --------------------- | ------------------------------------------------------------ |
| Root                  | `c9caceea4162fdad403fbdf926ebc9ebf6b9f37688fbb051c15913cc3058c739` |
| Customer              | `18116b636a868fd03c4f100dc0c95eccf38dffa44f7d5262ce18544d812ba4e3` |
| Customer-rep          | `8917768390cedfaffe5540e7605cbaff187c596aeeaf98a961bdebfe33ba1f32` |
| Storekeeper           | `aed65a99dad688ac946d725782199e7cfbb4fa112daaf1a6c359799dc2f10723` |
| Planner               | `b6d7d2cfb05ed255dfa37022955d99d9236c6a81c8534e8d766bf4f98ca60cb8` |
| Transporter           | `e49c8c771ee7409bd66ecc573ff7741d94e6f0c922e88bb21fe0abe6f418beda` |



<h2>Test data:</h2>

**When testing order placement please use the following ski models:**
 - Active
 - Active Pro
 - Endurance
 - Intrasonic
 - Race Pro
 - Race Speed
 - Redline 

**Existing order numbers:** 
 - 10005
 - 10006
 - 10007 
 - 10008 
 - 10009

**Existing customer numbers:** 
- 10000
- 10001 
- 10002 

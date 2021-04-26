# Tiny Social Network

*Read this in other languages: [English](README.md), [Français](README.fr.md)*

## Welcome

It's a *tiny social network* where **USER**s can **POST** messages and **COMMENT** these messages.

### Goal

This project was done for my PHP courses.
The goal is to review the **PHP syntax** and use **PDO** (PHP Data Objects)  for accessing databases.



![screenshot](screenshot.png)

### Database

The structure is really simple:

![dbschema](dbschema.png)

### MVC

It's a simple **MVC** implementation **without OOP** (Object-Oriented Programming) in **PHP** .

```
+---config/
|       data.sql
|       structure.sql
|       
+---controllers/
|       controller.php
|       
+---models/
|       PDO.php
|       PostManager.php
|       CommentManager.php
|       UserManager.php
|       
+---views/
|       DisplayPosts.php
|       LoginForm.php
|       RegisterForm.php
|       
\---web/
    |   index.php      <----- entry point
    |   
    +---css/
    +---img/       
    \---js/
```

## Getting Started

These instructions will get you a copy of the project up and running on your local machine.

### Prerequisites

You need to have a **L.A.M.P.** architecture working on your computer.

Else you need to install the missing parts (instructions for Ubuntu below).

**MySQL server**:

Installation

```sh
sudo apt-get install mysql-server
```

Start MySQL server

```sh
sudo systemctl start mysql
```

Create a new  MySQL user.
Of course, you can change the queries to replace **dbuser** & **1234Soleil!** with your own **username** & **password**, just don't forget what you enter because you will need them after.

```sh
sudo mysql
```
```sql
CREATE USER 'dbuser'@'localhost' IDENTIFIED BY '1234Soleil!';
GRANT ALL PRIVILEGES ON * . * TO 'dbuser'@'localhost';
EXIT;
```

**Apache2 server**:

Installation

```sh
sudo apt-get install apache2
```

Start the server:

```sh
sudo systemctl start apache2
```

**PHP & PDO**:

Installation

```sh
sudo apt update
sudo apt install php php-cli php-mysql
```

Restart apache2:

```sh
sudo systemctl restart apache2
```



### Installing

- **Fork** this repo and **clone** it on your computer inside the **DocumentRoot** of apache (by default it should be inside /var/www/html).

  ```sh
  cd /var/www/html
  git clone https://github.com/YOUR-USERNAME/socialnetwork
  ```

- Create an populate the database:

  Go into the **config directory** and run the <u>2 SQL scripts</u> (replace **dbuser** by the user you entered before)

  ```sh
  cd socialnetwork/config
  mysql -u dbuser -p < structure.sql
  mysql -u dbuser -p < data.sql
  ```

  - You can connect to the database **tsn** to see if the database and the table were well created

    ```sh
    sudo mysql
    ```
    ```sql
    use tsn;
    show tables;
    select * from user;
    exit;
    ```

- Go into the **models directory** and modify **PDO.php** to set the right credentials (**$db_user** & **$db_passwd**).

```php
<?php
  $db_user = "dbuser";
  $db_passwd = "1234Soleil!";
  $db_host = "localhost";
  $db_port = "3306";
  $db_name = "tsn";
  $db_dataSourceName = "mysql:host=$db_host;port=$db_port;dbname=$db_name";

  $PDO = new PDO($db_dataSourceName, $db_user, $db_passwd);
  $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

```

- Now if you go on your web browser you should see something:

  http://localhost/socialnetwork/web/



## Exercise 1

The posts are dynamically retrieved from the database, nonetheless, the comments are hardcoded.

**<u>Final Goal</u>: You have to retrieve these comments dynamically for each post.**

### 1 - Show me the code

Have a look inside the project to **understand approximately each line of code**.
Start with the entry point, the *index.php* inside the **web directory**.
And follow the execution to understand the whole project.

```php
<?php
session_start();

include "../controllers/controller.php";
```

### 2 - Use Git in the right way

Never work on the **master** branch, so start to create a **develop** branch from master and push it to GitHub.

```sh
git branch develop
git checkout develop
git push origin develop
```

As you will work on the feature to retrieve comments, create a new branch **feature/retrieveComments** from develop and push it to GitHub.

```sh
git branch feature/retrieveComments
git checkout feature/retrieveComments
git push origin feature/retrieveComments
```

Now you are ready to code.

### 3 - Do the job

If you have a look to *controllers/**controller.php*** you'll see some fake data about comments:

```php
case 'display':
    include "../models/PostManager.php";
    $posts = GetAllPosts();

    include "../models/CommentManager.php";
    $comments = array();

    // ===================HARDCODED PART===========================
    $comments[1] = array(
        array("nickname" => "FakeUser1", "created_at" => "1970-01-01 00:00:00", "content" => "Fake comment 01."),
        array("nickname" => "FakeUser2", "created_at" => "1970-01-02 00:00:00", "content" => "Fake comment 02."),
        array("nickname" => "FakeUser1", "created_at" => "1970-01-03 00:00:00", "content" => "Fake comment 03.")
    );
    $comments[3] = array(
        array("nickname" => "FakeUser1", "created_at" => "1970-01-01 00:00:00", "content" => "Fake comment 04."),
    );
    // =============================================================

    include "../views/DisplayPosts.php";
    break;
```
<u>You have to:</u>

1.  Go into *models/**CommentManager.php*** to create a new function **GetAllCommentsFromPostId**.
    This new function should return **all comments** from a **post id**.
    <u>Don't forget you need the nickname of the user who commented</u>.
    To do that, have a look to the **GetAllCommentsFromUserId**. 
    Your new function do almost the same thing but instead of 
    "WHERE comment.**user_id = $userId** " you should have "WHERE comment.**post_id = $postId** ".

```php
   function GetAllCommentsFromPostId($postId) {
	// Code here...
   }
```

2. Inside *controllers/**controller.php*** remove the *hardcoded part* but keep **$comments = array()**.

3. Instead, loop over **$posts** and call your new function **GetAllCommentsFromPostId** <u>for each post</u> giving the **post id**.

4. Inside the loop, we need to fill the **$comments** array.
   **$comments** is an associative array.
   The "key" should be the **post id**.
   The "value" is the result of your function **GetAllCommentsFromPostId**.

### 4 - Save on GitHub

When all is ok, **commit your changes** and **push** your work to GitHub.

You can **merge your feature branch into develop** and **push** develop too !!!

```sh
git commit -a -m "Remove the hardcoded comments"
git push origin feature/retrieveComments
git checkout develop
git merge feature/retrieveComments
git push origin develop
```



## Exercise 2

**<u>Final Goal:</u> Made a simple search feature.**

### 1 - New feature = new branch

You should be on the **develop** branch else enter this line.

```sh
git checkout develop
```

Create a new branch **feature/search** from develop and push it to GitHub.

```sh
git branch feature/search
git checkout feature/search
git push origin feature/search
```

Now you are ready to code.

### 2 - Add the search form into the navbar.

Modify the file: views/**DisplayPosts.php**

Before the "Login" and "Sign Up" links, add the **search form** like this:

![screenshot_search](screenshot_search.png)

```html
<ul class="navbar-nav">
    <li class="nav-item">
        <form class="nav-link" method="get">
            <input name="search" type="text"></input>
        </form>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?action=login" role="button">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?action=register" role="button">Sign Up</a>
    </li>
</ul>
```

### 3 - Modify the source code to add the search feature

1. Modify the file: controllers/**controller.php**

   If the **search** parameter is well defined into **$_GET** we will use it to retrieve the right posts.

   Else the posts will continue to come from the **GetAllPosts** function.

```php
case 'display':
default:
    include "../models/PostManager.php";
    if (isset($_GET['search'])) {
      $posts = SearchInPosts($_GET['search']);
    } else {
      $posts = GetAllPosts();
    }
    
    include "../models/CommentManager.php";
```

2. You have to write the **SearchInPosts** function into models/**PostManager.php**. 

   To do that copy/paste the **GetAllPosts** function, rename it into **SearchInPosts**.

3. Add the argument **$search** to this function.

4. Add a *where* clause into the sql query using this argument, it should look like this:

```php
 "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "WHERE content like '%$search%' "
      . "ORDER BY post.created_at DESC"
```

### 4 - Save on GitHub

When your search works well, **commit your changes** and **push** your work to GitHub.

You can **merge your feature branch into develop** and **push** develop too !!!

```sh
git commit -a -m "Simple search using the sql like"
git push origin feature/search
git checkout develop
git merge feature/search
git push origin develop
```



## Exercise 3

**<u>Final Goal:</u> Made a simple login & logout feature.**

### 1 - New feature = new branch

You should be on the **develop** branch else enter this line.

```sh
git checkout develop
```

Create a new branch **feature/login** from develop and push it to GitHub.

```sh
git branch feature/login
git checkout feature/login
git push origin feature/login
```

Now you are ready to code.

### 2 - Modify the navbar to display a logout when it needs

When the user will be logged, **$_SESSION['userId']** will contain his user id.

Modify the file: views/**DisplayPosts.php**

The content of the navbar-nav section depends if the variable **$_SESSION['userId']** is set or not.

```php+HTML
      <ul class="navbar-nav">
        <li class="nav-item">
          <form class="nav-link" method="get">
            <input name="search" type="text"></input>
          </form>
        </li>
    <?php
      if (isset($_SESSION['userId'])) {
    ?>
        <li class="nav-item">
          <a class="nav-link" href="?action=logout" role="button">Logout</a>
        </li>
    <?php
      } else {
    ?>
        <li class="nav-item">
          <a class="nav-link" href="?action=login" role="button">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?action=register" role="button">Sign Up</a>
        </li>
    <?php
      }
    ?>
      </ul>
```

### 3 - Modify the source code to be able to login & logout.

1. Modify the file: controllers/**controller.php**

   The **logout** action **unset $_SESSION['userId']** and redirect the visitor to the display action.

   The **login** action try to get the user id from his username & password.

   If it **succeed**, it sets the user id into the **$_SESSION['userId']** and **redirect the visitor to the display** action.
   
   If it **failed**, it set an **error message** and **display the login form again**.

```php
  case 'logout':
      if (isset($_SESSION['userId'])) {
        unset($_SESSION['userId']);
      }
      header('Location: ?action=display');
      break;

  case 'login':
    include "../models/UserManager.php";
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $userId = GetUserIdFromUserAndPassword($_POST['username'], $_POST['password']);
      if ($userId > 0) {
        $_SESSION['userId'] = $userId;
        header('Location: ?action=display');
      } else {
        $errorMsg = "Wrong login and/or password.";
        include "../views/LoginForm.php";
      }
    } else {
      include "../views/LoginForm.php";
    }
    break;
```

2. You have to write the **GetUserIdFromUserAndPassword** function into models/**UserManager.php**. This function takes 2 arguments **$username** and **$password** and it has to **return the user id** (if the user well exists and his password is the same) else this function has to return -1.

### 4 - Save on GitHub

When your login/logout works well, **commit your changes** and **push** your work to GitHub.

You can **merge your feature branch into develop** and **push** develop too !!!

```sh
git commit -a -m "Simple login/logout system"
git push origin feature/login
git checkout develop
git merge feature/login
git push origin develop
```



## Exercise 4

**<u>Final Goal:</u> Be able to post a new message on the tiny social network.**

### 1 - New feature = new branch

You should be on the **develop** branch else enter this line.

```sh
git checkout develop
```

Create a new branch **feature/newmsg** from develop and push it to GitHub.

```sh
git branch feature/newmsg
git checkout feature/newmsg
git push origin feature/newmsg
```

Now you are ready to code.

### 2 - Modify the main page to display a form to post a message

![screenshot_newMsg](screenshot_newMsg.png)

Modify the file: views/**DisplayPosts.php**

When the user is logged (when the variable **$_SESSION['userId']** is set) display the form.

```php+HTML
<?php
if (isset($_SESSION['userId'])) {
?>
  <div class="row newMsg">
    <div class="col">
      <form class="input-group" method="POST" action="?action=newMsg">
        <input name="msg" class="form-control" placeholder="Add a message" type="text">
        <button type="submit" class="btn btn-primary">Submit</button>    
      </form>
    </div>
  </div>
<?php
}
?>
```

### 3 - Modify the source code to create a new post.

1. Modify the file: controllers/**controller.php**

   If the user is logged and want to post a new message (value read from **$_POST['msg']**) so we will create an **insert** into the **post** table with the function **CreateNewPost**.


```php
  case 'newMsg':
    include "../models/PostManager.php";
    if (isset($_SESSION['userId']) && isset($_POST['msg'])) {
      CreateNewPost($_SESSION['userId'], $_POST['msg']);
    }
    header('Location: ?action=display');
    break;
```

2. You have to write the **CreateNewPost** function into models/**PostManager.php**. 

   This function takes 2 arguments **$userId** and **$msg**. 
   It has to execute this query: 

```php
"INSERT INTO post(user_id, content) values ($userId, '$msg')"
```

### 4 - Save on GitHub

When you are to able to post a new message, **commit your changes** and **push** your work to GitHub.

You can **merge your feature branch into develop** and **push** develop too !!!

```sh
git commit -a -m "Simple post system"
git push origin feature/newmsg
git checkout develop
git merge feature/newmsg
git push origin develop
```



## Exercise 5

**<u>Final Goal:</u> Prevent for sql injections.**

### 1 - New feature = new branch

You should be on the **develop** branch else enter this line.

```sh
git checkout develop
```

Create a new branch **feature/security** from develop and push it to GitHub.

```sh
git branch feature/security
git checkout feature/security
git push origin feature/security
```

Now you are ready to code.

### 2 - Modify the managers to use prepared queries

The current version can be hacked when posting a new message because the input of the user is directly put inside the sql query. You have to use [prepared statements/queries](https://www.php.net/manual/en/pdo.prepare.php) to prevent sql injections.

**TODO**
Replace in the 3 managers (**CommentManager**, **UserManager**, **PostManager**) the sql queries that use input data by **prepared queries**.

See the example below for the **CreateNewPost** function of the **PostManager**.

<u>Before</u>:

```php
function CreateNewPost($userId, $msg)
{
  global $PDO;
  $response = $PDO->exec("INSERT INTO post(user_id, content) values ($userId, '$msg')");
}
```

<u>After</u>:

```php
function CreateNewPost($userId, $msg)
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO post(user_id, content) values (:userId, :msg)");
  $response->execute(
    array(
      "userId" => $userId,
      "msg" => $msg
    )
  );
}
```

Another example for the **GetOneCommentFromId** function of the **CommentManager**.

<u>Before</u>:

```php
function GetOneCommentFromId($id)
{
  global $PDO;
  $response = $PDO->query("SELECT * FROM comment WHERE id = " . $id);
  return $response->fetch();
}
```

<u>After</u>:

```php
function GetOneCommentFromId($id)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM comment WHERE id = :id ");
  $response->execute(
    array(
      "id" => $id
    )
  );
  return $response->fetch();
}
```

Another example for the **SearchInPosts** function of the **PostManager**.

<u>Before</u>:

```php
function SearchInPosts($search)
{
  global $PDO;
  $response = $PDO->query(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "WHERE content like '%$search%' "
      . "ORDER BY post.created_at DESC"
  );
  return $response->fetchAll();
}
```

<u>After</u>:

```php
function SearchInPosts($search)
{
  global $PDO;
  $response = $PDO->prepare(
    "SELECT post.*, user.nickname "
      . "FROM post LEFT JOIN user on (post.user_id = user.id) "
      . "WHERE content like :search "
      . "ORDER BY post.created_at DESC"
  );
  $searchWithPercent = "%$search%";
  $response->execute(
    array(
      "search" => $searchWithPercent
    )
  );
  return $response->fetchAll();
}
```

### 3 - Save on GitHub

If all the features are still working, **commit your changes** and **push** your work to GitHub.

You can **merge your feature branch into develop** and **push** develop too !!!

```sh
git commit -a -m "Prevent SQL Injection"
git push origin feature/security
git checkout develop
git merge feature/security
git push origin develop
```



## Exercise 6

**<u>Final Goal:</u> Made a simple registration process.**

### 1 - New feature = new branch

You should be on the **develop** branch else enter this line.

```sh
git checkout develop
```

Create a new branch **feature/registration** from develop and push it to GitHub.

```sh
git branch feature/registration
git checkout feature/registration
git push origin feature/registration
```

Now you are ready to code.

### 2 - Modify the source code to be able to register.

1. Modify the file: controllers/**controller.php**


```php
   case 'register':
    include "../models/UserManager.php";
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordRetype'])) {
      $errorMsg = NULL;
      if (!IsNicknameFree($_POST['username'])) {
        $errorMsg = "Nickname already used.";
      } else if ($_POST['password'] != $_POST['passwordRetype']) {
        $errorMsg = "Passwords are not the same.";
      } else if (strlen(trim($_POST['password'])) < 8) {
        $errorMsg = "Your password should have at least 8 characters.";
      } else if (strlen(trim($_POST['username'])) < 4) {
        $errorMsg = "Your nickame should have at least 4 characters.";
      }
      if ($errorMsg) {
        include "../views/RegisterForm.php";
      } else {
        $userId = CreateNewUser($_POST['username'], $_POST['password']);
        $_SESSION['userId'] = $userId;
        header('Location: ?action=display');
      }
    } else {
      include "../views/RegisterForm.php";
    }
    break;
```

2. You have to write the **IsNicknameFree** and  **CreateNewUser** functions into **UserManager.php**.

```php
function IsNicknameFree($nickname)
{
  global $PDO;
  $response = $PDO->prepare("SELECT * FROM user WHERE nickname = :nickname ");
  $response->execute(
    array(
      "nickname" => $nickname
    )
  );
  return $response->rowCount() == 0;
}

function CreateNewUser($nickname, $password)
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO user (nickname, password) values (:nickname , :password )");
  $response->execute(
    array(
      "nickname" => $nickname,
      "password" => $password
    )
  );
  return $PDO->lastInsertId();
}
```

### 3 - Save on GitHub

When your registration process works well, **commit your changes** and **push** your work to GitHub.

You can **merge your feature branch into develop** and **push** develop too !!!

```sh
git commit -a -m "Simple registration process"
git push origin feature/registration
git checkout develop
git merge feature/registration
git push origin develop
```



## Exercise 7

**<u>Final Goal:</u> Don't store the passwords like this use md5**

Store clear text passwords is not a good idea. 
[You have to hash them, for example with the MD5 function.](https://en.wikipedia.org/wiki/MD5)

Update the current passwords of your database with this SQL query (run this only once !!!):

```sql
UPDATE user SET password = MD5(password);
```

### 1 - New feature = new branch

You should be on the **develop** branch else enter this line.

```sh
git checkout develop
```

Create a new branch **feature/md5** from develop and push it to GitHub.

```sh
git branch feature/md5
git checkout feature/md5
git push origin feature/md5
```

Now you are ready to code.

### 2 - Repair the login process.

The **login doesn't work** anymore because the passwords are now stored in md5 format and we compare the given password without md5, so you have to modify the **GetUserIdFromUserAndPassword** function into **UserManager.php** to fix it

```php
function GetUserIdFromUserAndPassword($username, $password)
{
  global $PDO;
  $response = $PDO->prepare("SELECT id FROM user WHERE nickname = :username AND password = MD5(:password) ");
  $response->execute(
    array(
      "username" => $username,
      "password" => $password
    )
  );
  if ($response->rowCount() == 1) {
    $row = $response->fetch();
    return $row['id'];
  } else {
    return -1;
  }
}
```

### 3 - Repair the registration process.

The **registration doesn't work as it should**. The passwords have to be stored in md5 format so you have to modify the **CreateNewUser** function into **UserManager.php**

```php
function CreateNewUser($nickname, $password)
{
  global $PDO;
  $response = $PDO->prepare("INSERT INTO user (nickname, password) values (:nickname , MD5(:password) )");
  $response->execute(
    array(
      "nickname" => $nickname,
      "password" => $password
    )
  );
  return $PDO->lastInsertId();
}
```

### 4 - Save on GitHub

When your registration & login process work well using md5, **commit your changes** and **push** your work to GitHub.

You can **merge your feature branch into develop** and **push** develop too !!!

```sh
git commit -a -m "Use md5 for the passwords"
git push origin feature/md5
git checkout develop
git merge feature/md5
git push origin develop
```



## Exercise 8

**<u>Final Goal:</u> Be able to post a new comment on any post.**

### 1 - New feature = new branch

You should be on the **develop** branch else enter this line.

```sh
git checkout develop
```

Create a new branch **feature/newcomment** from develop and push it to GitHub.

```sh
git branch feature/newcomment
git checkout feature/newcomment
git push origin feature/newcomment
```

Now you are ready to code.

### 2 - Modify the main page to display a form to post a comment

![screenshot_newComment](screenshot_newComment.png)

Modify the file: views/**DisplayPosts.php**

When the user is logged (when the variable **$_SESSION['userId']** is set) display the form to comment.

```php+HTML
<?php
if (isset($_SESSION['userId'])) {
?>
  <div class="input-group">
    <form class="input-group" method="POST" action="?action=newComment">
      <input name="postId" type="hidden" value="<?= $onePost['id'] ?>">
      <input name="comment" class="form-control" placeholder="Add a comment" type="text">
      <span class="input-group-text">
        <a href="#" onclick="$(this).closest('form').submit()"><i class="fa fa-edit"></i></a>
      </span>
    </form>
  </div>
<?php
}
?>
```

### 3 - Modify the source code to create a new comment.

1. Modify the file: controllers/**controller.php**

   If the user is logged and want to post a new message (values read from **$_POST['msg']** & **$_POST['postId']**) so we will create an **insert** into the **post** table with the function **CreateNewPost**.


```php
  case 'newComment':
    include "../models/CommentManager.php";
    if (isset($_SESSION['userId']) && isset($_POST['postId']) && isset($_POST['comment'])) {
      CreateNewComment($_SESSION['userId'], $_POST['postId'], $_POST['comment']);
    }
    header('Location: ?action=display');
    break;
```

2. You have to write the **CreateNewComment** function into models/**CommentManager.php**. 

   This function takes 3 arguments **$userId**, **$postId** and **$comment**. 
   It has to execute this query: 

```php
"INSERT INTO comment(user_id, post_id, content) values (:userId, :postId, :comment)"
```

### 4 - Save on GitHub

When you are to able to post a new comment, **commit your changes** and **push** your work to GitHub.

You can **merge your feature branch into develop** and **push** develop too !!!

```sh
git commit -a -m "Simple comment system"
git push origin feature/newcomment
git checkout develop
git merge feature/newcomment
git push origin develop
```


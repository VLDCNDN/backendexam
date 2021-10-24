## Backend Developer Assessment

**Framework**: Laravel
### Requirements
- PHP 7.4^
- MySQL
- composer
- php-redis

### Installation Guide

------------


1. Clone this repository `https://github.com/VLDCNDN/backendexam`
2. add php-redis in php extension
	- Instruction to install in windows [here](https://ourcodeworld.com/articles/read/1502/how-to-install-and-use-the-redis-extension-in-xampp-locally-in-windows-10 "here")
3. make sure to install `mysql` and add database depends on the name in `.env` file
	- **database default name:** laravel
	- Configure mysql credential in `.env` file if you have your own mysql
4. open cmd and change directory to the repository path, run the command below:

       composer install
       
       php artisan migrate:fresh --seed
       
       php artisan serve

## API
### **Resources**
- [POST /api/register](#post-apiregister)
- [POST /api/login](#post-apilogin)
- [GET /users](#get-users)
- [GET /users/{username}](#get-usersusername)
- [POST /api/hammingdistance](#post-apihammingdistance)

### POST /api/register
**Header**: Accept: application/json

**Example** : http://localhost:8080/api/register
##### Body
| Name  | Type   |   |
| ------------ | ------------ | ------------ |
| name  | string  | required  |
|  username | string  | required  |
|  password |  string | required  |
|  company |  string |  required |
| follower_count  |  integer | optional  |
| public_repository_count  | integer  | optional  |

### POST /api/login
**Header**: Accept: application/json

**Example** : http://localhost:8080/api/login

##### Body
| Name  | Type   |   |
| ------------ | ------------ | ------------ |
|  username | string  | required  |
|  password |  string | required  |

### GET /users
**Authentication** : Bearer Token

**Header**: Accept: application/json

**Example** : 
 - http://localhost:8080/users
 - http://localhost:8080/users?page=2

##### Params
| Name  | Type   |   |
| ------------ | ------------ | ------------ |
|  page | integer  | optional  |

### GET /users/{username}
**Authentication** : Bearer Token

**Header**: Accept: application/json

**Example** : 
 - http://localhost:8080/users/juan.santos
 - http://localhost:8080/users/juan.santos,marco.polo,rastaMan01

##### Params
| Name  | Type   |   |
| ------------ | ------------ | ------------ |
|  username | string  | for multiple username filter, separate using comma ( , )  |

### POST /api/hammingdistance

##### Body
*Prefer to use raw-json*

| Name  | Type   |   |
| ------------ | ------------ | ------------ |
| x | integer:gte=0:lt=2^31  | required  |
| y | integer:gte=0:lt=2^31  | required  |

# test-1
## 역할
회원가입과 로그인, 로그아웃, 고객정보 조회를 할 수 있는 API

## 스펙
* Laravel : 8.73
* php : 7.4
* mysql - innodb
* nginx
## docker
### prebuild
* 프로젝트를 올리기 위한 운영체제와 웹서버 기타 설정정보를 위한 도커 이미지(자주 변경되지 않음)
* ~~~bash
  cd /test-project1/.docker
  docker build -t prebuild:t1 .
  ~~~
### test-project(source)
* 실질적인 변경이 잦은 코드와 패키지들을 위한 도커 이미지
* docker run으로 실행
* ~~~bash
  cd /test-project1
  docker build -t test-project:0.1 .
  
  #.....processing
  #.....success
  
  docker run -d -p 8000:80 test-project:0.1
  ~~~
## db : test_db
### table
* user - 고객 정보 테이블
    * ~~~mysql
          CREATE TABLE `user` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
            `nick_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
            `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
            `tel` int NOT NULL,
            `gender` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
            `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
      ~~~
* order - 주문 정보 테이블
    * ~~~mysql
          CREATE TABLE `order` (
            `id` int unsigned NOT NULL AUTO_INCREMENT,
            `user_id` int NOT NULL,
            `order_id` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
            `order_date` datetime NOT NULL,
            `payment_date` datetime DEFAULT NULL,
            `product_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `foregin-user-id` (`user_id`),
            CONSTRAINT `foregin-user-id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
      ~~~


## API
* **POST** /api/join : 회원가입 - 요청한 정보 바탕으로 사용자 정보 생성
    * requestBody(JSON)
    * ex)
        * ~~~http request
            POST http://localhost:8000/api/join
            Accept: application/json
            Content-Type: application/json
               
            {
                "name" : "홍길동",
                "nickName":"testusr",
                "password":"abcdefhijK1@",
                "tel":"01041719406",
                "email":"abcdefg@test.com",
                "gender":"m"
            }
          ~~~
* **POST** /api/login : 로그인 - 요청한 정보 바탕으로 로그인 정보 생성
    * requestBody(JSON)
    * ex)
        * ~~~http request
            POST http://localhost:8000/api/login
            Accept: application/json
            Content-Type: application/json
               
            {
                "nickName" : "testusr",
                "password":"abcdefhijK1@"
            }
          ~~~
* **GET** /api/logout : 로그아웃 - 로그인 정보 삭제
    * ex)
        * ~~~http request
            GET http://localhost:8000/api/logout
          ~~~
* **GET** /api/users : 유저 조회 - 유저 리스트 제공
    * 페이지네이션 : 5
    * ex)
        * ~~~http request
            GET http://localhost:8000/api/users?page=2&name=홍길동&email=adef@cd.com
          ~~~
        * querystring
            * page : integer 값이 없는 경우 기본값 1로 세팅됨
            * name : string
            * email : string
* **GET** /users/{id} : 유저 상세 조회 - 아이디 기준으로 고객 상세정보 제공
    * ex)
        * ~~~http request
            GET http://localhost:8000/api/users/1
          ~~~
        
* **GET** /users/{id}/orders : 주문 정보 조회 - 아이디 기준으로 주문정보 제공
    * ex)
        * ~~~http request
            GET http://localhost:8000/api/users/1/orders
          ~~~
  
  

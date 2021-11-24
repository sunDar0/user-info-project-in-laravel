# test-1
## 역할
회원가입과 로그인, 로그아웃, 고객정보 조회를 할 수 있는 API

## 스펙
* Laravel : 8.73
* php : 7.4
* mysql - innodb
* nginx
## db : test_db
### table
* user - 고객 정보 테이블
* order - 주문 정보 테이블


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
  
  

<?php


namespace App\Http\Controllers;


use App\Classes\Converter\OrderConverter;
use App\Classes\Converter\UserConverter;

use App\Http\Request\RequestGetUserList;
use App\Http\Request\RequestJoin;
use App\Http\Request\RequestLogin;

use App\Models\Order;
use App\Models\User;


use App\Traits\TraitWhereConditioner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;


class UserController extends Controller
{
    use TraitWhereConditioner;

    /** 회원 가입
     * @param RequestJoin $request
     * @return Application|ResponseFactory|Response
     */
    public function join(RequestJoin $request)
    {

        return $this->process(function() use ($request){

            //가입되어있는 계정인지 확인
            $isUseNickName = User::where('nick_name', $request->nickName)->count();
            //가입한 유저라면 fail return
            if($isUseNickName) return response(['code'=>-1, 'msg'=>'already use nickName']);

            //유저 생성
            User::create([
                'name'=>$request->name,
                'nick_name'=>$request->nickName,
                'password'=>$request->password,
                'tel'=>$request->tel,
                'email'=>$request->email,
                'gender'=>!empty($request->gender) ? $request->gender:null
            ]);

            //더미 상품을 생성하기 위한 팩토리
            Order::factory()->count(rand(0,10))->create();

            return response(['code'=>0, 'msg'=>'join success']);
        });
    }

    /** 로그인
     * @param RequestLogin $request
     * @return Application|ResponseFactory|Response
     */
    public function login(RequestLogin $request)
    {
        return $this->process(function() use ($request){

            //이미 세션이 존재한다면 로그인 안내
            if(session()->has('login.user')) return response([
                    'code' => 0,
                    'userInfo'=>session('login.user'),
                    'msg' => 'already login user'
                ]);

            //사용자 nick_name 조회 없다면 fail return
            $user = User::where('nick_name', $request->nickName)->firstOrFail();

            //패스워드 일치 여부 체크 불일치 시 fail return
            if(!password_verify($request->password, $user->password)) throw new \Exception('User information does not match');


            //session 생성
            session()->put("login.user", [
                'name' => $user->name,
                'nickName' => $user->nick_name,
                'lastLoginDate' => now()
            ]);

            return response(['code'=>0, 'msg'=>'login success']);
        });
    }

    /**
     * @return Application|ResponseFactory|Response
     */
    public function logout()
    {
        return $this->process(function(){
            //세션이 없다면 fail return
            if(!session()->has('login.user')) throw new \Exception('not login user');
            //세션 삭제
            session()->forget('login.user');

            return response(['code'=>0, 'msg'=>'logout success']);
        });

    }


    /**
     * 고객 리스트 가져오기
     * @param RequestGetUserList $request
     * @return Application|ResponseFactory|Response
     */
    public function getUserList(RequestGetUserList $request)
    {
        return $this->process(function() use($request){
            //request따라 조건절 생성
            $whereCondition = UserConverter::makeWhereCondition($request);
            //페이지네이션을 위한 쿼리 세팅
            $userWhere = User::where($whereCondition)->with('lastOrder');
            //전체 갯수 가져오기
            $total = $userWhere->count();
            //offset값 세팅
            $offset = ($request->page - 1) * 5;
            //고객정보 가져오기
            $users = $userWhere->get()->skip($offset)->take(5);
            //가져온 고객정보 치환
            $convertedData = UserConverter::makeUserListData($users);
            //페이지네이션 세팅
            $pagenateData = new LengthAwarePaginator($convertedData, $total, 5);

            return response([
                'code'=> 0,
                'pagenateUsers'=> $pagenateData
            ]);
        });
    }

    /** 고객상세 정보 가져오기
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function getUserDetail($id)
    {
        return $this->process(function() use($id){
            //id 기준으로 고객정보 조회
            $user = User::findOrFail($id);
            $convertedData = UserConverter::makeUserDetailData($user);
            return response([
                'code'=> 0,
                'user' => $convertedData
            ]);
        });
    }


    /** 고객의 주문 상세 정보 가져오기
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function getOrderListByUserId($id)
    {
        return $this->process(function() use($id){
            $orders = Order::where('user_id',$id)->get();
            $convertedData = OrderConverter::makeOrderListData($orders);
            return response([
                'code'=> 0,
                'orders' => $convertedData
            ]);
        });
    }
}

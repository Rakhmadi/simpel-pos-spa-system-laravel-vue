<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\category;
use App\constumer;
use App\order_detail;
use App\order;
use App\User;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Validator;
use App\product;
use App\cart;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Int_;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Illuminate\Support\Facades\Schema;
use App\Models\Datapoint;
use App\Models\Sensor;
use DB;

class pos_co extends Controller
{
    public function showcat(){
        return category::all();
    }

    public function createcategory(Request $r){
        $val=Validator::make($r->all(),[
            'name'=>'required',
            'discription'=>'required'
        ]);
        if ($val->fails()) {
            return response()->json($val->errors());
        }
        $e=category::firstOrCreate([
           'name' => $r->name,
           'discription'=>  $r->discription,
        ])->save();
        return response()->json(['msg'=>'success']);
    }

    public function deletecategory($id){
        $idprd=product::where('category_id',$id)->exists();
        if ($idprd) {
            return response()->json(['msg'=>'Sedang Terpakai'],500);
        } else {
            try {
                $e=category::findOrFail($id);
                $e->delete();
                return response()->json(['msg'=>'success']);
               } catch (\Throwable $th) {
                return response()->json(['msg'=>'not_found']);
               }

        }


    }
    public function updatecategory(Request $r,$id){
        $val=Validator::make($r->all(),[
            'name'=>'required',
            'discription'=>'required'
        ]);
        if ($val->fails()) {
            return response()->json([
                $val->errors()
            ]);
        } else {
            try {
                $e=category::findOrFail($id);
                $e->update([
                    'name'=>$r->name,
                    'discription' =>$r->discription,
                ]);
                return response()->json(['msg'=>'success']);
            } catch (\Throwable $th) {
                return response()->json(['msg'=>'not_found']);
            }
        }
    }
    public function category_all(){
        return category::all();
    }
    /////////////////////////////////
    public function r_product(){
        return product::with('category')->get();
    }

    public function c_product(Request $r){
        $val=Validator::make($r->all(),[
            'name'=>'required|string|max:100',
            'code'=>'required|string|max:10|unique:products',
            'discription'=>'required|string|max:100',
            'stock'=>'required|integer',
            'price'=>'required|integer',
            'category_id'=>'required|exists:category,id',
            'photo'=>'nullable|image|mimes:jpg,png,jpeg'
        ]);
        if ($val->fails()) {
            return response()->json($val->errors());
        } else {
           try {
            if ($r->hasFile('photo')) {
                $imageName = time().'.'.$r->photo->extension();

                $r->photo->move(public_path('images'), $imageName);
             } else {
                 $imageName=null;
             }
             $t=product::create([
                 'name'=>$r->name,
                 'code'=>$r->code,
                 'discription'=>$r->discription,
                 'stock'=>$r->stock,
                 'price'=>$r->price,
                 'category_id'=>$r->category_id,
                 'photo'=>$imageName
             ])->save();
             return response()->json(['msg'=>'success']);
           } catch (\Throwable $th) {
              return response()->json(['msg'=>$th->getMessage()],500);
           }
        }
    }

    public function detail_product($id){
        $t=product::with('category')->findOrFail($id);
        return response()->json($t);

    }
    public function d_product($id){
       try {

        $r=product::findOrFail($id);
        if ($r->photo != null) {
            $image_path = "images/".$r->photo;  // Value is not URL but directory file path
             if(File::exists($image_path)) {
                 File::delete($image_path);
             }
             $r->delete();
        } else {
            $r->delete();
        }

        return response()->json(['msg'=>'success',$image_path]);
       } catch (\Throwable $th) {
        return response()->json(['msg'=>'err']);
       }
    }
    public function u_product(Request $r,$id){
        $val=Validator::make($r->all(),[
            'name'=>'required|string|max:100',
            'code'=>'required|string|max:10|unique:products',
            'discription'=>'required|string|max:100',
            'stock'=>'required|integer',
            'price'=>'required|integer',
            'category_id'=>'required|exists:category,id',
            'photo'=>'nullable|image|mimes:jpg,png,jpeg'
        ]);
        if ($val->fails()) {
            return response()->json($val->errors());
        } else {
           try {
            if ($r->hasFile('photo')) {
                $imageName = time().'.'.$r->photo->extension();

                $r->photo->move(public_path('images'), $imageName);
             } else {
                 $imageName=null;
             }
             $s=product::findOrFail($id);
             $s->update([
                 'name'=>$r->name,
                 'code'=>$r->code,
                 'discription'=>$r->discription,
                 'stock'=>$r->stock,
                 'price'=>$r->price,
                 'category_id'=>$r->category_id,
                 'photo'=>$imageName
             ]);
             return response()->json(['msg'=>'success']);
           } catch (\Throwable $th) {
              return response()->json(['msg'=>'err']);
           }
        }
    }
    public function register(Request $r){
        $val=Validator::make($r->all(),[
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
        ]);
        if ($val->fails()) {
            return response()->json($val->errors());
        } else {
            $token=bcrypt(Hash::make(Str::random(60)));
            User::create([
                'name'=>$r->name,
                'email'=>$r->email,
                'password'=>bcrypt($r->password),
                'api_token'=>$token
            ])->save();
            return response()->json(['msg'=>'success','token'=>$token]);
        }
    }
    public function login(Request $r){
        $val=Validator::make($r->all(),[
            'name'=>'required',
            'password'=>'required',
        ]);
        if ($val->fails()) {
            return response()->json($val->errors());
        } else {
            $c = $r->only('name', 'password');

            if (Auth::attempt($c)) {
               return response()->json(['name'=>Auth::user()->name,'token'=>Auth::user()->api_token]);
            }else{
                return response()->json(['msg'=>'err']);
            }
        }


    }
    public function addcart(Request $r,$id){
        $val=Validator::make($r->all(),[
            'qty'=>'required',
        ]);
        $rs=product::findOrFail($id);
        $rs->update([
            'stock'=>$rs->stock - $r->qty
        ]);
        $total=$r->qty * $rs->price;
        cart::create([
            'qty'=>$r->qty,
            'price'=>$total,
            'product_id'=>$rs->id,
        ])->save();
        return response()->json([
            'msg'=>'success'
        ]);
    }
    public function cart(){

         $t= cart::with('prod')->get();
         return response()->json($t);
    }
    public function cartprice(){
        $c=cart::sum('price');
        return response()->json($c);
    }
    public function swcart(){
        $h=cart::count();
        return response()->json($h);
    }
    public function delcart($id){
        $h=cart::findOrFail($id);
        $rs=product::findOrFail($h->product_id);
        $rs->update([
            'stock'=>$rs->stock + $h->qty
        ]);
        $h->delete();
        return response()->json(['msg'=>'success']);
    }
    public function order(){
        return order::with('cart')->get();
    }
    public function addorder(Request $r){
       $yf= constumer::where('email',$r->email_cos)->exists();
        if ($yf) {
            $k=constumer::where('email',$r->email_cos)->first();
            $y=User::where('api_token',$r->token)->first();
            $o= cart::sum('price');
            $tod=Carbon::now();
            $yr=$tod->year;
            $m=$tod->month;
            $d=$tod->day;
            order::create([
                'costomer_id'=>$k->id,
                'user_id'=>$y->id,
                'invoice'=>rand(1,100).$yr.$m.$d,
                'total'=>$o
            ])->save();
            return response()->json([
                'msg'=>'success'
                ]);
        } else {
            return response()->json(['msg'=>'email'],500);
        }

    }
    public function cs(Request $r){
        $val=Validator::make($r->all(),[
            'email'=>'required|unique:costomers',
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
        ]);
        if ($val->fails()) {
            return response()->json($val->errors(),400);
        } else {
            constumer::create([
                'email'=>$r->email,
                'name'=>$r->name,
                'address'=>$r->address,
                'phone'=>$r->phone,
            ])->save();
            return response()->json(['msg'=>'success']);
        }
    }
    public function done(){

Schema::disableForeignKeyConstraints();
order::truncate();
cart::truncate();
Schema::enableForeignKeyConstraints();

        return response()->json(['msg'=>'success']);

    }
    public function dash(){
        $n=User::count();
        $h=constumer::count();
        $j=cart::count();
        $p=product::count();
        return response()->json([
            'usr'=>$n,
            'cos'=>$h,
            'cart'=>$j,
            'product'=>$p,
        ]);

    }
    public function ch(){
        $g =order::select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as totals'))
        ->groupBy('date')
        ->get();
        return  $g;
    }
}

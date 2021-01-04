<?php
namespace Database\Seeders;
use App\Models\Pclassify;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{

    protected $life_file = '/seeders/data/life_insurance.json';
    protected $more_file = '/seeders/data/product_more_basic.json';
    protected $firms = []; //保险公司
    protected $products = []; //保险产品
    public $mapLogos = [
        [
            'name' => '中英人寿', //名称
            'logo' => 'zhongyingrenshou.jpg', //图标
            'url' => 'http://www.aviva-cofco.com.cn' //官网地址
        ], [
            'name' => '同方全球',
            'logo' => 'tongfangquanqiurenshou.jpg',
            'url' => 'http://www.aegonthtf.com'
        ], [
            'name' => '工银安盛',
            'logo' => 'gongyinansheng.jpg',
            'url' => 'https://www.icbc-axa.com'
        ], [
            'name' => '阳光人寿',
            'logo' => 'yangguangbaoxianjituan.jpg',
            'url' => 'https://www.sinosig.com'
        ], [
            'name' => '泰康人寿',
            'logo' => 'taikangrenshou.jpg',
            'url' => 'http://www.tk.cn'
        ], [
            'name' => '国华人寿',
            'logo' => 'guohuarenshou.jpg',
            'url' => 'https://www.95549.cn'
        ], [
            'name' => '中意人寿',
            'logo' => 'zhongyirenshou.jpg',
            'url' => 'http://www.generalichina.com'
        ], [
            'name' => '恒大人寿',
            'logo' => 'hengda.jpg',
            'url' => 'http://www.lifeisgreat.com.cn'
        ], [
            'name' => '天安人寿',
            'logo' => 'tianan.jpg',
            'url' => 'http://www.tianan-life.com'
        ], [
            'name' => '人民人寿',
            'logo' => 'renmin.jpg',
            'url' => 'http://www.epicc.com.cn'
        ], [
            'name' => '恒安标准',
            'logo' => 'hengan.jpg',
            'url' => 'http://www.hengansl.com'
        ], [
            'name' => '长城人寿',
            'logo' => 'changchengrenshou.png',
            'url' => 'http://www.greatlife.cn'
        ], [
            'name' => '国宝人寿',
            'logo' => 'guobaorenshou.jpg',
            'url' => 'https://www.guobaojinrong.com'
        ], [
            'name' => '中华人寿',
            'logo' => 'zhonghuarenshou.gif',
            'url' => 'http://life.cic.cn'
        ], [
            'name' => '复星联合',
            'logo' => 'fuxinglianhe.gif',
            'url' => 'http://www.fosun-uhi.com'
        ], [
            'name' => '长生人寿',
            'logo' => 'changshengrenshou.jpg',
            'url' => 'http://www.gwcslife.com'
        ], [
            'name' => '百年人寿',
            'logo' => 'bainianrenshou.jpeg',
            'url' => 'http://www.aeonlife.com.cn'
        ], [
            'name' => '东吴人寿',
            'logo' => 'dongwurenshou.jpg',
            'url' => 'http://www.e-soochowlife.com'
        ], [
            'name' => '华安保险',
            'logo' => 'huaanbaoxian.jpg',
            'url' => 'https://www.sinosafe.com.cn'
        ], [
            'name' => '前海人寿',
            'logo' => 'qianhairenshou.jpg',
            'url' => 'https://www.foresealife.com'
        ], [
            'name' => '永安保险',
            'logo' => 'yonganbaoxian.jpg',
            'url' => 'https://www.yaic.com.cn'
        ], [
            'name' => '永诚保险',
            'logo' => 'yongchengbaoxian.jpg',
            'url' => 'http://www.yongcheng.com'
        ], [
            'name' => '中国平安',
            'logo' => 'zhongguopingan.jpg',
            'url' => 'https://www.pingan.com'
        ], [
            'name' => '中国人寿',
            'logo' => 'zhongguorenshoucaixian.jpg',
            'url' => 'https://www.chinalife.com.cn'
        ], [
            'name' => '中国太平',
            'logo' => 'zhongguotaiping.jpg',
            'url' => 'http://www.cntaiping.com'
        ], [
            'name' => '紫金保险',
            'logo' => 'zijincaichanbaoxian.jpg',
            'url' => 'http://www.zking.com'
        ], [
            'name' => '长生人寿',
            'logo' => 'csrs.jpg',
            'url' => 'http://www.gwcslife.com'
        ], [
            'name' => '和谐健康',
            'logo' => 'hxjk.png',
            'url' => 'http://www.hexiehealth.com'
        ], [
            'name' => '史带保险',
            'logo' => 'sdbx.png',
            'url' => 'http://www.starrchina.cn'
        ], [
            'name' => '中信保诚',
            'logo' => 'zxbc.jpg',
            'url' => 'http://www.citic-prudential.com.cn'
        ],
    ];
    protected $maps = [
        'status'=>[
            '0'=>'停售',
            '1'=>'在售',
            '2'=>'停用'
        ]
    ];

    protected $now;
    protected $now_time;
    protected $year;
    protected $pclassifys = [];
    protected $pclassifys_list = [];
    protected $map_classifys = [
        '3'=>[9,12],
        '4'=>[9,10],
        '5'=>[9,11],
        '7'=>[19,21],
        '8'=>[6,8],
        '23'=>[17,18],
        '24'=>[6,7]
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ini_set ('memory_limit', -1);
        $this->now = date('Y-m-d H:i:s');
        $this->now_time = time();
        $this->year = date('Y');
        $urls = collect($this->mapLogos)->pluck('url','name')->toArray();
        $firm_id = 1;
        $product_id = 1;
        $pclassifys_list = Pclassify::get()->toArray();
        $this->pclassifys = listToTree($pclassifys_list,'id',  'parent_id',  'children',  1);
        $this->pclassifys_list = collect($pclassifys_list)->keyBy('name');
        if(file_exists(database_path($this->life_file))){
            //读取文件内容
            $data = json_decode(file_get_contents(database_path($this->life_file)),true)?:[];
            //获取保险公司名称
            collect($data)
                ->map(function ($item)use($urls,&$firm_id){
                    if(!Arr::get($this->firms,$item['firm'])){ //保险公司
                        $firm_name = str_replace(['保险股份有限公司','保险有限公司','保险有限责任公司'],'',$item['firm']);
                        $this->firms[$item['firm']] = [
                            'id'=>$firm_id,
                            'name'=>$firm_name,
                            'full_name'=>$item['firm'],
                            'type'=>1,
                            'description'=>$item['firm'],
                            'url'=>Arr::get($urls,$firm_name,''),
                            'created_at'=>$this->now,
                            'updated_at'=>$this->now
                        ];
                        $firm_id++;
                    }
                    //
                });
        }
        if(file_exists(database_path($this->more_file))){
            //读取文件内容
            $data = json_decode(file_get_contents(database_path($this->more_file)),true)?:[];
            $map_status = array_flip($this->maps['status']);
            //获取保险公司名称
            collect($data)
                ->map(function ($item)use($urls,&$firm_id,&$product_id,$map_status){
                    if(!Arr::get($this->firms,$item['firm'])){ //保险公司
                        $firm_name = str_replace(['保险股份有限公司','保险有限公司','保险有限责任公司'],'',$item['firm']);
                        $this->firms[$item['firm']] = [
                            'id'=>$firm_id,
                            'name'=>$firm_name,
                            'full_name'=>$item['firm'],
                            'type'=>1,
                            'description'=>$item['firm'],
                            'url'=>Arr::get($urls,$firm_name,''),
                            'created_at'=>$this->now,
                            'updated_at'=>$this->now
                        ];
                        $firm_id++;
                    }
                    if(!Arr::get($this->products,$item['id'])){
                        $type = array_unique(explode('-',$item['type']));
                        if(count($type)==3){
                            array_splice($type,1,0,['非个人税收优惠型健康保险']);
                        }
                        $pclassify_id = $this->getPclassifyId($type,$this->pclassifys);
                        if(!$pclassify_id){
                            $pclassify_id = Arr::get($this->pclassifys_list,$type[count($type)-1].'.id',0);
                        }
                        $classify_id = 0;
                        $classify2_id = 0;
                        if($pclassify_id==21){ //意外伤害险
                            $classify_id=14;
                            $classify2_id = str_contains($item['is_long'],'长期')?15:16;
                        }elseif ($pclassify_id>8 && $pclassify_id<21){ //健康险
                            $classify_id=2;
                            if(str_contains($item['is_long'],'长期')){
                                $classify2_id = 3;
                            }elseif (str_contains($item['is_long'],'超过一年')){
                                $classify2_id = 5;
                            }else{
                                $classify2_id = 4;
                            }
                        }elseif (isset($this->map_classifys[$pclassify_id])){
                            $classify_id = $this->map_classifys[$pclassify_id][0];
                            $classify2_id = $this->map_classifys[$pclassify_id][1];
                        }
                        $this->products[$item['id']] = [
                            'id'=>$product_id,
                            'uid'=>$item['id'],
                            'firm_id'=>Arr::get(Arr::get($this->firms,$item['firm'],[]),'id',0),
                            'classify_id'=>$classify_id,
                            'classify2_id'=>$classify2_id,
                            'pclassify_id'=>$pclassify_id,
                            'name'=>$item['name'],
                            'is_long_time'=>str_contains($item['is_long'],'长期')?1:0,
                            'class'=>$item['classify']=='传统型产品'?0:1,
                            'buy_type'=>$item['classify']=='个人'?1:2,
                            'pay_type'=>multipleToNum(collect(explode(',',$item['pmodel']))->map(function ($value){
                                $val = 0;
                                collect(array_flip(["1"=>'一次性交费',
                                    "2"=>'分期交费',
                                    "4"=>'灵活交费']))->map(function ($v,$k)use($value,&$val){
                                        if(str_contains($value,$k)){
                                            $val = $val|$v;
                                        };
                                });
                                return $val;
                            })->toArray()),
                            'attr'=>Arr::get(array_flip([
                                "0"=>'无',
                                "1"=>'学生平安险',
                                "2"=>'女性专属产品',
                                "3"=>'少儿专属产品',
                                "4"=>'老年专属产品',
                                "5"=>'航空意外险'
                            ]),str_replace('保险','险',$item['attr']),0),
                            'pdf_url'=>$item['pdf_url'],
                            'company_no'=>$item['company_no'],
                            'no'=>$item['no'],
                            'status'=>Arr::get($map_status,$item['status']),
                            'issue_at'=>$this->handleDate($item['issue_at']),
                            'stop_at'=>$this->handleDate($item['stop_at']),
                            'created_at'=>$this->now,
                            'updated_at'=>$this->now
                        ];
                        $product_id++;
                    }
                });
        }
        \App\Models\Firm::insertReplaceAll(collect($this->firms)->values()->toArray());
        \App\Models\Product::insertReplaceAll(collect($this->products)->values()->toArray());

    }

    public function handleDate($date){
        $date = str_replace('.0','',$date)?:null;
        if(Arr::get(explode('-',$date),0,'')>$this->year){
           return null;
        }
        if(strtotime($date)>$this->now_time){
            return null;
        }
        return $date;
    }

    public function getPclassifyId($types,$classifys){
        $classifys = collect($classifys)->keyBy('name');
        $type=array_shift($types);
        if(!$types){
            return Arr::get($classifys,$type.'.id',0);
        }
        $classifys = Arr::get($classifys,$type.'.children',[]);
        return $this->getPclassifyId($types,$classifys);
    }


}
